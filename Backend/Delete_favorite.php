
<?php
// Verificar si se ha pasado el nombre de la canción y la URL de la carátula por la URL
if (isset($_GET['id_favorite'])) {
    $id_favorite = htmlspecialchars($_GET['id_favorite']);
    
    include_once('BD.php');
    $conn = conexion::conexion_bd();
    
    // Suponiendo que ya tienes la variable $user_name disponible
    
    try {
        // Prepara la consulta
        $query = "DELETE FROM favorites WHERE favorite_id = :id_favorite;";
        
        $stmt = $conn->prepare($query); // $conn debe ser la conexión PDO
    
        // Asigna el valor a la variable
        $stmt->bindParam(':id_favorite', $id_favorite);
        $stmt->execute();
    
        // Obtiene los resultados
        $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error en la consulta: " . $e->getMessage();
    }
    
   header("Location: ../../../Music-Player/Frontend/favorites.php");  // Redirige a login.php después de cerrar sesión
    exit();
}

    ?>
