<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lista de playlist</title>
    <link rel="stylesheet" href="list-style.css" />
  </head>
  <body>
    <?php 
    session_start();
    if (!isset($_SESSION['usuario'])) {
      // Si no está en la sesión, redirigir a login.php
      header("Location: Login.html");
      exit();
    } else {
      include_once("../Backend/BD.php");

  // Conectar a la base de datos usando la clase conexion
  $conn = conexion::conexion_bd();

  $username = $_SESSION['usuario'];
  $user_name = htmlspecialchars($username);

  if ($conn) {
    // Consulta para obtener los nombres de las playlists
    $sql = "SELECT playlist_name, playlist_id FROM playlist 
                WHERE playlist_user_name = :user_name"; // Ajusta según tu esquema de base de datos

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro
    $stmt->bindParam(':user_name', $user_name);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo "Error en la conexión a la base de datos.";
  }
}
  ?>
    <div class="container">
      <div class="header">
        <h1>Playlist</h1>
        <p>Número de playlist</p>
      </div>
      <div class="song-list">
      <?php if (!empty($playlists)): ?>
        <?php foreach ($playlists as $favs): ?>
        <div class="song-item">
        
        <a
              href="Backend/download.php?song_file_id=<?php echo urlencode($favs['song_file']);
              ; ?>&song_name=<?php echo urlencode($favs['song_name']); ?>&song_artist=<?php echo urlencode($favs['artist_name']); ?>&song_image=<?php echo urlencode($favs['song_image']); ?>&song_id=<?php echo urlencode($favs['song_id']); ?>">
          <span class="song-number">1</span>
          <img src="../Music_temp/Imagen playlist.jpg" />
          <div class="song-details">
            <div class="song-title"><?php echo htmlspecialchars($playlist['playlist_name']); ?></div>
          </div>
          <span class="song-duration">Cantidad de canciones</span>
          </a>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
          <p>No hay playlist disponibles.</p>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>
