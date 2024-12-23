<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../administrator_management/category.css" />
  <link rel="icon" href="../Image/Logo.ico" type="image/x-icon" />
  <title>Aizzy</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .chart-container {
      margin: 10vh;
      width: 70%;
      max-width: 600px;
    }
  </style>
</head>

<body>
  <?php
  // Verificamos si se ha enviado el formulario
  $Año = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Año = $_POST['Año']; // Guardamos el valor del input en la variable $Año
  } else {
    $Año = "2024"; // Definimos $Año como cadena vacía si el formulario no ha sido enviado
  }
  ?>
  <form action="" method="post">
    <section class="form-login">
      <h5>Año para analizar</h5>

      <input type="text" id="Año" name="Año" class="controls" value="<?php echo htmlspecialchars($Año); ?>" />
      <button type="submit" class="buttons">ver</button>
    </section>



  </form>
  <div class="chart-container">
    <canvas id="viewsChart"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

<script>
  // script.js
  const ctx = document.getElementById("viewsChart").getContext("2d");
  // Tamaño del array



  <?php  
  include_once("../../Backend/BD.php");

  $conn = conexion::conexion_bd();

  $añoN = (int)$Año; 
  $valoresPHP = [0,0,0,0,0,0,0,0,0,0,0,0];
  session_start();
  $username = $_SESSION['usuario'];
    $user_name = htmlspecialchars($username);
  if ($conn) {

    $query = "SELECT 
DATE_TRUNC('month', history_date) AS mes,
COUNT(*) AS total_reproducciones FROM history
JOIN song ON history.history_song_id=song.song_id
JOIN artist ON artist.artist_id=song_artist_id
WHERE artist.artist_name= :User_Name AND EXTRACT(YEAR FROM history_date) = $añoN
GROUP BY DATE_TRUNC('month', history_date)
ORDER BY mes;";
$stmt = $conn->prepare($query);
$stmt->bindParam(':User_Name', $user_name);

$stmt->execute();
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($history as $historys): 

  
 
    $mes = (int)date("m", strtotime(htmlspecialchars(string: $historys['mes'])));

    $valoresPHP[$mes - 1] = htmlspecialchars(string: $historys['total_reproducciones']);
  endforeach;
  } else {
    echo "Error en la conexión a la base de datos.";
}











    


  ?>
  const valoresPHP = <?php echo json_encode($valoresPHP); ?>;
  // Datos de visualizaciones por mes
  const data = {
    labels: [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Diciembre",
    ],
    datasets: [
      {
        label: "Visualizaciones",
          /*<?php
          $valoresPHP = [128, 129, 124, 126]; // Array en PHP
          ?>*/
      //[<?php echo implode(",", $valoresPHP); ?>]
      data: valoresPHP, // Cambia estos valores según los datos reales
      backgroundColor: "rgba(203, 49, 245, 0.5)",
      borderColor: "rgba(203, 49, 245, 1)",
      borderWidth: 1,
        },
      ],
    };

  // Configuración del gráfico
  const config = {
    type: "bar",
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  };

  // Crear el gráfico
  const viewsChart = new Chart(ctx, config);
</script>

</html>