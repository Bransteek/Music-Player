<?php
session_start();

// Verificar si el usuario está en la sesión
if (!isset($_SESSION['usuario'])) {
    // Si no está en la sesión, redirigir a login.php
    header("Location: Frontend/Login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Music-Player/Frontend/Menu.css" />

  <link rel="icon" href="../Music-Player/Image/Logo.ico" type="image/x-icon" />
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
              const url = "Frontend/busqueda.php?query=" + query;
              window.location.href = url; // Redirige a la página de resultados de Google
            } else {
              console.log("Error");
            }
          }
        });
    });
  </script>


  <?php
  include_once("Frontend\layouts\sidebar.php");
  ?>

  <!-- carousel de playlists-->

  <link rel="stylesheet" href="Frontend/carousel.css" />

  <div class="carousel-container">
    <h2>Playlists</h2>

    <div class="carousel">
      <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
      <div class="slide">
        <a href="#" class="card">
          <img src="Music_temp/MURDER FUNK.jpg" alt="music-image" class="card__img" />
          <span class="card__footer">
            <span>Playlist</span>
            <span>2 minutes!</span>
          </span>
        </a>
      </div>

      <div class="slide">
        <a href="#" class="card">
          <img src="Image/Music.jpeg" alt="music-image" class="card__img" />
          <span class="card__footer">
            <span>Playlist</span>
            <span>2 minutes!</span>
          </span>
        </a>
      </div>

      <div class="slide">
        <a href="#" class="card">
          <img src="Music_temp/MURDER FUNK.jpg" alt="music-image" class="card__img" />
          <span class="card__footer">
            <span>Playlist</span>
            <span>2 minutes!</span>
          </span>
        </a>
      </div>
      <button class="next" onclick="moveSlide(1)">&#10095;</button>
      <!-- Puedes agregar más elementos según lo necesites -->
    </div>

  </div>

  <script src="Backend/caruosel.js"></script>


  <div class="music-grid">
    <div class="container">
      <div class="music-card">
        <a href="Prueba.html">
          <img src="../Music-Player/Image/Music.jpeg" alt="Portada de Canción 1" class="thumbnail" />

          <div class="song-info">
            <h3 class="song-title">Murder funk</h3>
            <p class="song-artist">Artista 1</p>
          </div>
        </a>
      </div>
    </div>

    <div class="container">
      <div class="music-card">
        <img src="https://via.placeholder.com/150" alt="Portada de Canción" class="thumbnail" />
        <div class="song-info">
          <h3 class="song-title">Canción 2</h3>
          <p class="song-artist">Artista 2</p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="music-card">
        <img src="https://via.placeholder.com/150" alt="Portada de Canción" class="thumbnail" />
        <div class="song-info">
          <h3 class="song-title">Canción 3</h3>
          <p class="song-artist">Artista 3</p>
        </div>
      </div>
    </div>
    <!-- Añadir más canciones aquí -->
  </div>
</body>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            // Comprobar si la sesión se está volviendo desde la navegación de "Atrás"
            if (!sessionStorage.getItem("visited")) {
                // Si no hay valor en sessionStorage, significa que es la primera vez que visita esta página
                sessionStorage.setItem("visited", "true");
            } else {
                // Si hay un valor, significa que se está devolviendo con el botón de "Atrás"
                // Destruir la sesión en el servidor
                fetch('../Music-Player/Backend/logout.php')
                    .then(response => {
                        if (response.ok) {
                            // Redirigir a login una vez destruida la sesión
                            sessionStorage.removeItem("visited");
                            window.location.href = 'Frontend/Login.html';
                        }
                    });
            }
        });
    </script>

</html>