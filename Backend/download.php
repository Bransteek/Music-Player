<?php
// Obtener el ID del archivo de Google Drive y la imagen desde la URL
if (isset($_GET['song_file_id']) && isset($_GET['song_image']) && isset($_GET['song_name'])&& isset($_GET['song_artist'])&&isset($_GET['song_id']) ) {
    
// Obtener el ID del archivo de Google Drive y la imagen desde la URL

$songFile = htmlspecialchars($_GET['song_file_id']); // ID del archivo de Google Drive
$songImageURL = htmlspecialchars($_GET['song_image']);
$songName = htmlspecialchars($_GET['song_name']); // Asegúrate de que estés recibiendo esto correctamente
$song_artist = htmlspecialchars($_GET['song_artist']);
$song_id = htmlspecialchars($_GET['song_id']);
// URL del archivo de Google Drive para descargar
$destinationI = 'C:/xampp/htdocs/Music-Player/Music_temp/' . $songName . 'Image.jpg';
// Ruta donde se guardará la canción descargada
$destination = 'C:/xampp/htdocs/Music-Player/Music_temp/' . $songName . '.mp3';
if (file_exists($destination) && file_exists($destinationI)) {
    // Si ambos archivos existen, redirigir a Portada_music.php sin descargar nuevamente
    header("Location: ../Portada_music.php?song_name=" . urlencode($songName) . '&song_artist=' . urlencode($song_artist) . '&song_id=' . urlencode($song_id));
    exit();
} else {
$fileUrl = 'https://drive.google.com/uc?export=download&id=' . $songFile;
$fileUrlI = 'https://drive.google.com/uc?export=download&id=' . $songImageURL;



// Intentar descargar el archivo
if (file_put_contents($destination, file_get_contents($fileUrl))&&file_put_contents($destinationI, file_get_contents($fileUrlI))) {
    // Si la descarga es exitosa, redirigir a Portada_music.php
    header("Location: ../Portada_music.php?song_name=" . urlencode($songName). '&song_artist=' . urlencode($song_artist) . '&song_id=' . urlencode($song_id)  );
    exit();
} else {
    echo "Error al descargar el archivo.";
}
}


} else {
    // Si no se pasa el ID del archivo, redirigir a la página principal
    header("Location: ../Prueba.php");
    exit();
}
?>
