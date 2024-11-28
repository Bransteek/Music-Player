
<?php
// Verificar si se ha pasado el nombre de la canción y la URL de la carátula por la URL
if (isset($_GET['id_playlist'])) {
    $id_playlist = htmlspecialchars($_GET['id_playlist']);

    include_once('BD.php');
    $conn = conexion::conexion_bd();
    
    // Suponiendo que ya tienes la variable $user_name disponible
    
    try {
        // Prepara la consulta
        $query = "DELETE FROM song_playlist WHERE sp_playlist_id = :id_playlist;
                  ";
        
        $stmt = $conn->prepare($query); // $conn debe ser la conexión PDO
    
        // Asigna el valor a la variable
        $stmt->bindParam(':id_playlist', $id_playlist);
        $stmt->execute();
    
        // Obtiene los resultados
        $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error en la consulta: " . $e->getMessage();
    }
    $query = "DELETE FROM playlist WHERE playlist_id = :id_playlist;";
    $stmt = $conn->prepare($query); // $conn debe ser la conexión PDO
    
    // Asigna el valor a la variable
    $stmt->bindParam(':id_playlist', $id_playlist);
    $stmt->execute();

    // Obtiene los resultados
    $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);
   header("Location: ../../../Music-Player/Frontend/list-playlist.php");  // Redirige a login.php después de cerrar sesión
    exit();
}

    ?>
