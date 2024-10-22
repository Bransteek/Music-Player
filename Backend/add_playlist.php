<?php
include_once("BD.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $playlistName = $_POST['playlistName'];

    // Sanitizar el nombre de la playlist
    $playlist_name = htmlspecialchars($playlistName);
    
    // Iniciar la conexión
    $conn = conexion::conexion_bd();
    
    // Iniciar la sesión
    session_start();

    // Verificar si el usuario está en la sesión
    if (!isset($_SESSION['usuario'])) {
        // Si no está en la sesión, redirigir a login.php
        header("Location: Frontend/Login.html");
        exit();
    } else {
        $username = $_SESSION['usuario'];
        $user_name = htmlspecialchars($username);
    }

    // Si la conexión a la base de datos fue exitosa
    if ($conn) {
        // Preparar la consulta SQL
        $sql = "INSERT INTO playlist (playlist_name, descripcion, playlist_user_name) VALUES (:playlist_name, '', :user_name)";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);
        
        // Asignar valores a los parámetros
        $stmt->bindParam(':playlist_name', $playlist_name);
        $stmt->bindParam(':user_name', $user_name);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a la página de éxito si se crea la playlist
            header("Location: ../Portada_music.php");
            exit();
        } else {
            // Mostrar un mensaje de error si la inserción falla
            echo "No se pudo crear la playlist. Inténtalo de nuevo.";
        }
    } else {
        echo "No se pudo conectar a la base de datos.";
    }
}
?>
