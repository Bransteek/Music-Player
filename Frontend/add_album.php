<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lista de Canciones</title>
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
    include_once("layouts/sidebar.php");

    // Conectar a la base de datos usando la clase conexion
    $conn = conexion::conexion_bd();

    $username = $_SESSION['usuario'];
    $user_name = htmlspecialchars($username);

    if ($conn) {
      $playlist_name = isset($_GET['playlist_name']) ? $_GET['playlist_name'] : '';
      // Consulta para obtener los nombres de las playlists
      $sql = "SELECT song_id,song_name, song_image, song_file, artist_name, song_id,duration FROM song
    JOIN artist ON artist_id = song_artist_id
	WHERE artist_name = :user_name;"; // Ajusta según tu esquema de base de datos
  
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
  <form action="../Backend/create_album.php" method="POST">
    <div class="header">
      <!-- hacer la funcionalidad de reproducir -->
      <input type="text" id="album_name" name="album_name" required>

    </div>


    <div class="song-list">
      <?php $counter = 1; ?>
      <?php if (!empty($canciones)): ?>
        <?php foreach ($canciones as $cancion): ?>
          
          
            <div class="song-item">
            <input type="checkbox" name="selected_songs[]" value="<?php echo htmlspecialchars($cancion['song_id']); ?>">
              <span class="song-number"><?php echo $counter ?></span>
              <img src="../Music_temp/<?php echo htmlspecialchars($cancion['song_name']); ?>Image.jpg" />
              <div class="song-details">
                <div class="song-title"><?php echo htmlspecialchars($cancion['song_name']); ?></div>
                <div class="song-artist"><?php echo htmlspecialchars($cancion['artist_name']); ?></div>
              </div>
              <span class="song-duration"><?php echo $cancion['duration'] . " s" ?></span>
              
            </div>

          
          <?php $counter++; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No hay canciones disponibles.</p>
      <?php endif; ?>
    </div>
    <button type="submit">Guardar Playlist</button>
    </form>
  </div>
</body>



</html>