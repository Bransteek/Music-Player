
<?php
// Verificar si se ha pasado el nombre de la canción y la URL de la carátula por la URL
if (isset($_GET['delete_id'])) {
    $delete_id = htmlspecialchars($_GET['delete_id']);
    
    include_once('BD.php');
    $conn = conexion::conexion_bd();
    
    // Suponiendo que ya tienes la variable $user_name disponible
    
    try {
        // Prepara la consulta
        $query = "DELETE FROM song_playlist WHERE sp_id = :delete_id;";
        
        $stmt = $conn->prepare($query); // $conn debe ser la conexión PDO
    
        // Asigna el valor a la variable
        $stmt->bindParam(':delete_id', $delete_id);
        $stmt->execute();
    
        // Obtiene los resultados
        $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error en la consulta: " . $e->getMessage();
    }

    $name = $_GET['playlist_name'];
    
   header("Location: ../../../Music-Player/Frontend/playlist.php?playlist_name=$name");  // Redirige a login.php después de cerrar sesión
    exit();
}

    ?>
