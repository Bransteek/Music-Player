
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['selected_songs'])) {
       
        $selected_songs = $_POST['selected_songs'];
        // Procesa los IDs seleccionados, por ejemplo, insertándolos en una tabla de playlists.
        print_r($selected_songs); // Muestra los IDs seleccionados (para debug).

    } else {
        echo "No seleccionaste ninguna canción.";
    }


include_once('BD.php');
$conn = conexion::conexion_bd();
$name_album = $_POST['album_name'];

session_start();
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

$sql = "INSERT INTO playlist (playlist_name, descripcion, playlist_user_name, tipe_playlist_album) VALUES (:playlist_name, '', :user_name,2)";

$stmt = $conn->prepare($sql);
        
        // Asignar valores a los parámetros
        $stmt->bindParam(':playlist_name', $name_album);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->execute();

        $playlist_id = $conn->lastInsertId();

        // Ahora, inserta las canciones en la tabla song_playlist usando el playlist_id obtenido
        for ($i = 0; $i < count($selected_songs); $i++) {
            $song_id = $selected_songs[$i];
            
            // Insertar solo si la canción no está ya asociada a la playlist
            $sql = "INSERT INTO song_playlist (sp_playlist_id, sp_song_id)
                    SELECT :playlist_id, :song_id
                    WHERE NOT EXISTS (
                        SELECT 1 FROM song_playlist 
                        WHERE sp_playlist_id = :playlist_id AND sp_song_id = :song_id
                    )";
            
            $stmt = $conn->prepare($sql);
            // Asignar valores a los parámetros
            $stmt->bindParam(':playlist_id', $playlist_id);
            $stmt->bindParam(':song_id', $song_id);
            $stmt->execute();
        }
} else {
    echo "No se pudo conectar a la base de datos.";
}

}

header("Location: ../../../Music-Player/index.php");  // Redirige a login.php después de cerrar sesión
exit();
?>