<?php

include_once("Backend\BD.php");

// Conectar a la base de datos usando la clase conexion
$conn = conexion::conexion_bd();

if ($conn) {
    // Consulta para obtener los nombres de las canciones
    $sql = "SELECT song_name,song_image FROM song"; // Ajusta según tu esquema de base de datos
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Error en la conexión a la base de datos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reproductor de Música</title>
  <style>
    body {
      background-color: #121212;
      color: white;
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 50px;
    }
    h1 {
      margin-bottom: 20px;
    }
    .song-list {
      list-style-type: none;
      padding: 0;
      margin: 20px 0;
    }
    .song-list li {
      cursor: pointer;
      padding: 10px;
      background-color: #1e1e1e;
      margin: 5px 0;
      transition: background-color 0.3s;
    }
    .song-list li:hover {
      background-color: #3a3a3a;
    }
  </style>
</head>
<body>
  <h1>Reproductor de Música</h1>

  <!-- Lista de canciones -->
  <ul class="song-list">
    <?php
    // Iterar sobre los resultados de la consulta y generar la lista de canciones
    foreach ($canciones as $cancion) {
        // Redirigir a presentacion_cancion.php pasando el nombre de la canción
        echo '<li onclick="window.location.href=\'Portada_music.php?song_name=' . urlencode($cancion['song_name']) . '&song_image=' . urlencode($cancion['song_image']) . '\'">' . htmlspecialchars($cancion['song_name']) . '</li>';
    }
    ?>
  </ul>

</body>
</html>


