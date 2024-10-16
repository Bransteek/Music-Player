<link rel="stylesheet" href="../Music-Player/Frontend/Sidebar.css" />

<button class="open-btn" onclick="toggleSidebar()">☰ Abrir</button>

<div id="mySidebar" class="sidebar">
  <a href="index.php">Inicio</a>
  <a href="#Favoritos">Favoritos</a>
  <a href="#Historial">Historial</a>
  <a href="#playlist">Playlist</a>
  <?php
  if (isset($_SESSION['usuario']) && $_SESSION['rol'] === "admin") {
    ?>
    <div class="funtion_admin">
      <a href="../Music-Player/Frontend/administrator_management/admin.html">
        Funciones de administrador
      </a>
    </div>
    <?php
  }
  if (isset($_SESSION['usuario']) && $_SESSION['rol'] === "artist") {
    ?>
    <div class="funtion_artist">
      <a href="../Music-Player/Frontend/function artist/artist.html">
        Funciones de artista
      </a>
    </div>
    <?php
  }
  ?>
  <a href="javascript:void(0)" onclick="toggleSidebar()">Cerrar ×</a>

</div>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById("mySidebar");
    const content = document.getElementById("mainContent");
    if (sidebar.style.width === "200px") {
      sidebar.style.width = "0";
      content.style.transform = "translateX(0)";
    } else {
      sidebar.style.width = "200px";
      content.style.transform =
        "translateX(-200px)"; /* Mueve el contenido a la izquierda */
    }
  }

  window.dispatchEvent(new Event('resize'));
</script>