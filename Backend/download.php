<?php
// URL del archivo de Google Drive para descargar
$fileUrl = 'https://drive.google.com/uc?export=download&id=1gmcp3FKO6Ikhb9K0UYvHzsfbuow7V_hX';
// Ruta donde se guardará temporalmente el archivo
$destination = 'C:/xampp/htdocs/Music-Player/Music_temp/song.mp3';

// Descargar y guardar el archivo
if (file_put_contents($destination, file_get_contents($fileUrl))) {
    // Redirigir a la página del reproductor después de la descarga
    header("Location: ../Prueba.html");
    exit();
} else {
    echo "Error al descargar el archivo.";
}
header("Location: ../Prueba.html");
?>
