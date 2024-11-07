<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // Redirige al login si el usuario no está autenticado
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

include_once("BD.php");
$conn = conexion::conexion_bd();

if ($conn) {
    $username = $_SESSION['usuario'];
    $favorite_user_name = htmlspecialchars($username);
    $favorite_song_id = $_POST['song_id'];

    // Verificar si el registro ya existe en la tabla 'favorites'
    $query = "SELECT 1 FROM favorites WHERE favorite_user_name = :favorite_user_name AND favorite_song_id = :favorite_song_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':favorite_user_name' => $favorite_user_name, ':favorite_song_id' => $favorite_song_id]);

    if ($stmt->fetch()) {
        // Si el registro ya existe, eliminarlo
        $delete_query = "DELETE FROM favorites WHERE favorite_user_name = :favorite_user_name AND favorite_song_id = :favorite_song_id";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->execute([':favorite_user_name' => $favorite_user_name, ':favorite_song_id' => $favorite_song_id]);
        echo json_encode(['status' => 'removed']);
    } else {
        // Si no existe, agregarlo
        $insert_query = "INSERT INTO favorites (favorite_song_id, favorite_user_name) VALUES (:favorite_song_id, :favorite_user_name)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->execute([':favorite_user_name' => $favorite_user_name, ':favorite_song_id' => $favorite_song_id]);
        echo json_encode(['status' => 'added']);
    }
} else {
    echo json_encode(['error' => 'db_connection_failed']);
}
?>
