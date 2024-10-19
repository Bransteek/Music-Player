<?php
    include_once("../BD.php");
    
    
    function obtenerIdGoogleDrive($url) {
        // Expresión regular para extraer el ID del enlace de Google Drive
        $pattern = '/\/d\/([a-zA-Z0-9_-]+)\//';
        preg_match($pattern, $url, $matches);
    
        // Si se encuentra un ID, se devuelve, de lo contrario se retorna null
        return $matches[1] ?? null;
    }
    
    // Ejemplo de uso
    $urlf = $_POST['songfile'];  // El enlace de Google Drive enviado por POST
    $urli = $_POST['songimage'];
    $Song_File = obtenerIdGoogleDrive($urlf);  // Extraemos solo el ID
    $Song_Image = obtenerIdGoogleDrive($urli);
    
    
    echo "El ID del archivo es: " . $Song_File_ID;
    
    
    // Connect to the database
    $conn = conexion::conexion_bd();

    if ($conn) {
        // Prepare a query
        $sql = "INSERT INTO song (song_name, duration, song_category_id, song_album_id, song_artist_id, 
                likes, dislikes, visualizations,song_file, song_image )
                VALUES (:Song_Name, :Duration, :Category, :Album, :Artist, 0, 0, 0, :Song_File, :Song_Image)";

        // Execute the query
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(':Song_Name',$Song_Name);
        $stmt -> bindParam(':Duration',$Duration);
        $stmt -> bindParam(':Category',$Category);
        $stmt -> bindParam(':Album',$Album);
        $stmt -> bindParam(':Artist',$Artist);
        $stmt -> bindParam(':Song_File',$Song_File);
        $stmt -> bindParam(':Song_Image',$Song_Image);
        $Song_Name = $_POST['songname'];
        $Duration  = $_POST['duration'];
        $Category  = $_POST['category'];
        $Album  = $_POST['album'];
        $Artist  = $_POST['artist'];
        

        if($Album == ""){
            $sql = "INSERT INTO song (song_name, duration, song_category_id, song_artist_id, 
                likes, dislikes, visualizations,song_file, song_image )
                VALUES (:Song_Name, :Duration, :Category, :Artist, 0, 0, 0, :Song_File, :Song_Image)";
                $stmt->execute();
        }else{
            
        }
        $stmt->execute();

        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the results
        if($results == null){
            echo "<br>";
            echo "No se agrego la cancion";
        }else{
        

            header("Location: ../../Frontend/administrator_management/add_song.html");
            exit();
        }
        }

    
?>