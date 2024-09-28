<?php

include_once("Backend\BD.php");

// Conectar a la base de datos usando la clase conexion
$conn = conexion::conexion_bd();

if ($conn) {
    // Consulta para obtener los nombres de las canciones
    $sql = "SELECT song_name FROM song"; // Ajusta según tu esquema de base de datos
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
    audio {
      margin-top: 20px;
      width: 100%;
      max-width: 600px;
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
    #search-bar {
      width: 100%;
      max-width: 600px;
      padding: 10px;
      margin-bottom: 20px;
      background-color: #1e1e1e;
      color: white;
      border: none;
    }
  </style>
</head>
<body>
  <h1>Reproductor de Música</h1>

  <!-- Barra de búsqueda -->
  <input type="text" id="search-bar" placeholder="Buscar canción...">

  <!-- Lista de canciones -->
  <ul class="song-list">
    <?php
    // Iterar sobre los resultados de la consulta y generar la lista de canciones
    foreach ($canciones as $cancion) {
        // Se agrega el nombre de la canción como el texto visible y también como data-src
        echo '<li data-src="Music_temp/' . htmlspecialchars($cancion['song_name']) . '.mp3">' . htmlspecialchars($cancion['song_name']) . '</li>';
    }
    ?>
  </ul>

  <!-- Reproductor de audio que reproduce la canción desde la carpeta Music_temp -->
  <audio id="audio-player" controls>
    <source id="audio-source" src="" type="audio/mpeg">
    Tu navegador no soporta el elemento de audio.
  </audio>

  <!-- Enlace para descargar la canción -->
  <a href="/Music-Player/Backend/download.php">Descargar y reproducir canción</a>

  <script>
    const audioPlayer = document.getElementById('audio-player');
    const audioSource = document.getElementById('audio-source');
    const songListItems = document.querySelectorAll('.song-list li');
    const searchBar = document.getElementById('search-bar');

    // Reproducir canción al hacer clic
    songListItems.forEach(item => {
      item.addEventListener('click', function() {
        const newSrc = this.getAttribute('data-src'); // Obtener la ruta de la canción del data-src
        audioSource.src = newSrc;
        audioPlayer.load(); // Cargar la nueva canción
        audioPlayer.play(); // Reproducir automáticamente
      });
    });

    // Filtrar canciones según el término de búsqueda
    searchBar.addEventListener('input', function() {
      const searchTerm = searchBar.value.toLowerCase();
      songListItems.forEach(item => {
        const songName = item.textContent.toLowerCase();
        if (songName.includes(searchTerm)) {
          item.style.display = 'block'; // Mostrar coincidencia
        } else {
          item.style.display = 'none'; // Ocultar si no coincide
        }
      });
    });
  </script>

</body>
</html>



