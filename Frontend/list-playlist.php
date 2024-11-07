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
      
    </div>
    <div class="song-list">
      <?php if (!empty($playlists)): ?>
        <?php foreach ($playlists as $playlist): ?>
          <a href="playlist.php?playlist_name=<?php echo urlencode($playlist['playlist_name']); ?>" class="card">
            <div class="song-item"> 
              <span class="song-number">1</span>
              <img src="../Music_temp/Imagen playlist.jpg" />
              <div class="song-details">
                <div class="song-title"><?php echo htmlspecialchars($playlist['playlist_name']); ?></div>
              </div>
              
            </div>
          </a>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No hay playlist disponibles.</p>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>