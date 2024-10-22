<?php
include_once("BD.php");
session_start(); // Mover esto al principio

if (isset($_GET['song_id']) && isset($_GET['playlist_id'])&& isset($_GET['song_name'])&& isset($_GET['song_artist'])) {
    $song_id = htmlspecialchars($_GET['song_id']);
    $playlist_id = htmlspecialchars($_GET['playlist_id']);
    $songName = htmlspecialchars($_GET['song_name']);
    $song_artist = htmlspecialchars($_GET['song_artist']);
    
} else {
    // Si no se ha pasado la información necesaria, redirigir a la página principal
    header("Location: Prueba.php");
    exit;
}

// Iniciar la conexión
$conn = conexion::conexion_bd();

// Verificar si el usuario está en la sesión
if (!isset($_SESSION['usuario'])) {
    // Si no está en la sesión, redirigir a login.php
    header("Location: Frontend/Login.html");
    exit();
}

if ($conn) {
    // Preparar la consulta SQL
    $sql = "INSERT INTO song_playlist (sp_playlist_id, sp_song_id) VALUES (:playlist_id, :song_id)";
    
    // Preparar la sentencia
    $stmt = $conn->prepare($sql);
    
    // Asignar valores a los parámetros
    $stmt->bindParam(':playlist_id', $playlist_id);
    $stmt->bindParam(':song_id', $song_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de éxito si se crea la playlist
        header("Location: ../Portada_music.php?song_name=" . urlencode($songName) . "&song_artist=" . urlencode($song_artist) . "&song_id=" . urlencode($song_id));
        exit();
    } else {
        // Mostrar un mensaje de error si la inserción falla
        echo "No se pudo crear la playlist. Inténtalo de nuevo. Error: " . $stmt->errorInfo()[2]; // Muestra el error de PDO
    }
} else {
    echo "No se pudo conectar a la base de datos.";
}
?>
