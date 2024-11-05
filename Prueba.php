<?php

include_once("Backend\BD.php");

// Conectar a la base de datos usando la clase conexion
$conn = conexion::conexion_bd();

if ($conn) {
    // Consulta para obtener los nombres de las canciones
    $sql = "SELECT song_name,song_image,song_file,artist_name,song_id FROM song  JOIN artist ON song.song_artist_id= artist.artist_id"; // Ajusta según tu esquema de base de datos
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
    foreach ($canciones as $favs) {
        // Redirigir a presentacion_cancion.php pasando el nombre de la canción
        echo '<li onclick="window.location.href=\'Backend/download.php?song_file_id=' . urlencode($favs['song_file']) . '&song_image=' . urlencode($favs['song_image']). '&song_name=' . urlencode($favs['song_name'])  . '&song_artist=' . urlencode($favs['artist_name'])   . '&song_id=' . urlencode($favs['song_id'])  . '\'">' . htmlspecialchars($favs['song_name']) . '</li>';

    }
    ?>
  </ul>

</body>
</html>


