<link rel="stylesheet" href="../Music-Player/Frontend/Sidebar.css" />

<button class="open-btn" onclick="toggleSidebar()">☰ Abrir</button>

<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" onclick="toggleSidebar()">Cerrar ×</a>
  <a href="#home">Inicio</a>
  <a href="#services">Servicios</a>
  <a href="#about">Acerca de</a>
  <a href="#contact">Contacto</a>
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
</script>
