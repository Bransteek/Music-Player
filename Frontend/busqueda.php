<?php
session_start();

// Verificar si el usuario está en la sesión
if (!isset($_SESSION['usuario'])) {
  // Si no está en la sesión, redirigir a login.php
  header("Location: Frontend/Login.html");
  exit();
} else {
  include_once("../../Music-Player/Backend/BD.php");

  // Conectar a la base de datos usando la clase conexion
  $conn = conexion::conexion_bd();

  $query = $_GET['query'];

  $username = $_SESSION['usuario'];
  $user_name = htmlspecialchars($username);

  if ($conn) {
    // Consulta para obtener los nombres de las playlists
    $sql = "SELECT playlist_name, playlist_id FROM playlist 
                WHERE Tipe_playlist_album = 2 AND LOWER(playlist_name) LIKE LOWER(:query) OR LOWER(playlist_user_name) LIKE LOWER(:query)"; // Ajusta según tu esquema de base de datos

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    $searchQuery = "%" . $query . "%";
    // Vincular el parámetro
    $stmt->bindParam(':query', $searchQuery);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo "Error en la conexión a la base de datos.";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../../Music-Player/Frontend/Menu.css" />

  <link rel="icon" href="../../Music-Player/Image/Logo.ico" type="image/x-icon" />
  <link rel="stylesheet" href="../../../Music-Player/Frontend/carousel.css" />
  <title>Menu</title>
</head>

<body>
  <div id="search-container" class="search-container">
    <input type="text" id="search-input" class="search-bar" placeholder="Buscar..." />
  </div>
  <!--Solo se muestra cuando tenga rol de administrador-->


  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document
        .getElementById("search-container")
        .addEventListener("keypress", function (event) {
          if (event.key === "Enter") {
            event.preventDefault(); // Evita que el formulario se envíe
            const query = document.getElementById("search-input").value;

            if (query) {
              //modificar para la web
              const url = "busqueda.php?query=" + query;
              window.location.href = url; // Redirige a la página de resultados de Google
            } else {
              console.log("Error");
            }
          }
        });
    });
  </script>


  <?php
  include_once("layouts\sidebar.php");
  ?>

  <!-- carousel de playlists-->


  <div class="carousel-container">
    <h2>Albumnes</h2>

    <div class="music-grid">
      <?php if (!empty($playlists)): ?>

        <div class="carousel">
          <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
          <?php foreach ($playlists as $playlist): ?>
            <div class="slide">
            <a href="playlist.php?playlist_name=<?php echo urlencode($playlist['playlist_name']); ?>" class="card">              
              
                <img src="../Music_temp/Imagen playlist.jpg"
                  alt="Portada de <?php echo htmlspecialchars($playlist['song_name']); ?>" class="thumbnail" />
                <span class="card__footer">
                  <span><?php echo htmlspecialchars($playlist['playlist_name']); ?></span>
                </span>
              </a>
            </div>

          <?php endforeach; ?>
        <?php else: ?>
          <p>No hay Albumnes disponibles.</p>
        <?php endif; ?>
      </div>

      <button class="next" onclick="moveSlide(1)">&#10095;</button>
      <!-- Puedes agregar más elementos según lo necesites -->
    </div>

  </div>

  <script src="../Backend/caruosel.js"></script>

  <?php
  include_once("../Backend/BD.php");

  // Conectar a la base de datos usando la clase conexion
  $conn = conexion::conexion_bd();

  if ($conn) {
    // Consulta para obtener los nombres de las canciones junto con sus imágenes y archivos
    $sql = "SELECT song_name, song_image, song_file, artist_name, song_id 
            FROM song 
            JOIN artist ON song.song_artist_id = artist.artist_id
            WHERE LOWER(song_name) LIKE LOWER(:query) OR LOWER(artist_name) LIKE LOWER(:query)"; // Ajusta según tu esquema de base de datos
    $stmt = $conn->prepare($sql);

    $searchQuery = "%" . $query . "%";
    // Vincular el parámetro
    $stmt->bindParam(':query', $searchQuery);
    $stmt->execute();
    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo "Error en la conexión a la base de datos.";
  }
  ?>

  <div class="music-grid">
    <?php if (!empty($canciones)): ?>
      <?php foreach ($canciones as $favs): ?>
        <div class="container">
          <div class="music-card">
            <a
              href="../../Music-Player/Backend/download.php?song_file_id=<?php echo urlencode($favs['song_file']);
              ; ?>&song_name=<?php echo urlencode($favs['song_name']); ?>&song_artist=<?php echo urlencode($favs['artist_name']); ?>&song_image=<?php echo urlencode($favs['song_image']); ?>&song_id=<?php echo urlencode($favs['song_id']); ?>">
              <img src="../Music_temp/<?php echo htmlspecialchars($favs['song_name']); ?>Image.jpg"
                alt="Portada de <?php echo htmlspecialchars($favs['song_name']); ?>" class="thumbnail" />
              <div class="song-info">
                <h3 class="song-title"><?php echo htmlspecialchars($favs['song_name']); ?></h3>
                <p class="song-artist"><?php echo htmlspecialchars($favs['artist_name']); ?></p>
              </div>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No hay canciones disponibles.</p>
    <?php endif; ?>
  </div>

  <!-- Añadir más canciones aquí -->
  </div>
</body>


</html>