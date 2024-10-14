<?php
session_start();
session_destroy();  // Destruye todas las variables de la sesión
header("Location: ../Frontend/Login.html");  // Redirige a login.php después de cerrar sesión
exit();
?>
