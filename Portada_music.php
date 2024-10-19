<?php
// Verificar si se ha pasado el nombre de la canción y la URL de la carátula por la URL
if (isset($_GET['song_name']) && isset($_GET['song_image'])) {
    $songName = htmlspecialchars($_GET['song_name']);
    $songImageURL = htmlspecialchars($_GET['song_image']);
    $songPath = 'Music_temp/' . $songName . '.mp3'; // Ruta a la canción

    // Crear un nombre de archivo para la imagen
    $imageFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $songName) . '.jpg'; // Reemplazar caracteres no válidos
    $imagePath = 'album_covers/' . $imageFileName; // Ruta de la imagen

    // Descargar la imagen y guardarla permanentemente en el servidor
    if (file_put_contents($imagePath, file_get_contents($songImageURL)) === false) {
        // Si la descarga falla, redirigir a la página principal
        header("Location: Prueba.php");
        exit;
    }

} else {
    // Si no se ha pasado la información necesaria, redirigir a la página principal
    header("Location: Prueba.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentación de Canción - Tipo Spotify</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .song-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
        .album-cover img {
            width: 250px;
            height: 250px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .song-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .song-info h2, .song-info p {
            margin: 5px 0;
        }
        audio {
            margin-top: 20px;
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>
<body>
<div class="song-container">
    <!-- Carátula del álbum con opción de descarga -->
    <div class="album-cover">
        <!-- Enlace con atributo download para descargar la imagen -->
        <a href="<?php echo $imagePath; ?>" download="album-cover.jpg">
            <img src="<?php echo $imagePath; ?>" alt="music-image" class="card__img" />
        </a>
    </div>
    
    <!-- Información de la canción -->
    <div class="song-info">
        <h2><?php echo $songName; ?></h2>
        <p>Artista Desconocido</p>
    </div>
    
    <!-- Controles de reproducción -->
    <audio controls>
        <source src="<?php echo $songPath; ?>" type="audio/mpeg">
        Tu navegador no soporta el elemento de audio.
    </audio>
</div>

</body>
</html>
