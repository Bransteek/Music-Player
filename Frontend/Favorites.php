<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Favoritos</title>
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
      $sql = "SELECT favorite_song_id,song_name, song_image, song_file, artist_name, song_id,duration FROM favorites 
    JOIN song ON song_id = favorite_song_id 
    JOIN artist ON artist_id = song_artist_id 
    WHERE favorite_user_name = :user_name;"; // Ajusta según tu esquema de base de datos
  
      // Preparar la consulta
      $stmt = $conn->prepare($sql);

      // Vincular el parámetro
      $stmt->bindParam(':user_name', $user_name);

      // Ejecutar la consulta
      $stmt->execute();

      // Obtener los resultados
      $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
      echo "Error en la conexión a la base de datos.";
    }
  }
  ?>
  <div class="container">
    <div class="header">
      <!-- hacer la funcionalidad de reproducir -->
      <div class="play-icon" onclick="play()">&#9658;</div>

      <h1>Favoritos</h1>
      <p>Número de canciones</p>
    </div>
    <div class="song-list">
    <?php $counter = 1; ?>
      <?php if (!empty($canciones)): ?>
        <?php foreach ($canciones as $cancion): ?>
          <a href="../Backend/download.php?song_file_id=<?php echo urlencode($cancion['song_file']);
              ; ?>&song_name=<?php echo urlencode($cancion['song_name']); ?>&song_artist=<?php echo urlencode($cancion['artist_name']); ?>&song_image=<?php echo urlencode($cancion['song_image']); ?>&song_id=<?php echo urlencode($cancion['song_id']); ?>">
            <div class="song-item">
              <span class="song-number"><?php echo $counter?></span>
              <img src="../Music_temp/<?php echo htmlspecialchars($cancion['song_name']); ?>Image.jpg" />
              <div class="song-details">
                <div class="song-title"><?php echo htmlspecialchars($cancion['song_name']); ?></div>
                <div class="song-artist"><?php echo htmlspecialchars($cancion['artist_name']); ?></div>
              </div>
              <span class="song-duration"><?php echo htmlspecialchars($cancion['duration']) . "s"; ?></span>

            </div>
          </a>
          <?php $counter++; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No hay canciones disponibles.</p>
      <?php endif; ?>
    </div>
  </div>
</body>

<script>
  function play() {
    window.location.href = "https://www.google.com";
  }
</script>

</html>