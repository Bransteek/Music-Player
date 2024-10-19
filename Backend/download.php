<?php
// Obtener el ID del archivo de Google Drive y la imagen desde la URL
if (isset($_GET['song_file_id']) && isset($_GET['song_image']) && isset($_GET['song_name'])) {
    
// Obtener el ID del archivo de Google Drive y la imagen desde la URL

$songFile = htmlspecialchars($_GET['song_file_id']); // ID del archivo de Google Drive
$songImageURL = htmlspecialchars($_GET['song_image']);
$songName = htmlspecialchars($_GET['song_name']); // Asegúrate de que estés recibiendo esto correctamente

// URL del archivo de Google Drive para descargar
$fileUrl = 'https://drive.google.com/uc?export=download&id=' . $songFile;


// Ruta donde se guardará la canción descargada
$destination = 'C:/xampp/htdocs/Music-Player/Music_temp/' . $songName . '.mp3';

// Intentar descargar el archivo
if (file_put_contents($destination, file_get_contents($fileUrl))) {
    // Si la descarga es exitosa, redirigir a Portada_music.php
    header("Location: Portada_music.php?song_name=" . urlencode($songName) . "&song_image=" . urlencode($songImageURL));
    exit();
} else {
    echo "Error al descargar el archivo.";
}


} else {
    // Si no se pasa el ID del archivo, redirigir a la página principal
    header("Location: ../Prueba.php");
    exit();
}
?>
