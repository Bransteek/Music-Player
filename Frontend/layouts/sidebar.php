<link rel="stylesheet" href="../Music-Player/Frontend/Sidebar.css" />

<button class="open-btn" onclick="toggleSidebar()">☰ Abrir</button>

<div id="mySidebar" class="sidebar">
  <a href="index.php">Inicio</a>
  <a href="#Favoritos">Favortitos</a>
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
  ?>
  <a href="javascript:void(0)" onclick="toggleSidebar()">Cerrar ×</a>

</div>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById("mySidebar");
    const content = document.getElementById("mainContent");
    if (sidebar.style.width === "250px") {
      sidebar.style.width = "0";
      content.style.transform = "translateX(0)";
    } else {
      sidebar.style.width = "250px";
      content.style.transform =
        "translateX(-250px)"; /* Mueve el contenido a la izquierda */
    }
  }

  window.dispatchEvent(new Event('resize'));
</script>