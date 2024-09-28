<?php
// URL del archivo de Google Drive para descargar
$fileUrl = 'https://drive.google.com/uc?export=download&id=1naml3mcCV0XIZ01mtsMhHprhzwlbSIsy';

// Obtener los encabezados del archivo
$headers = get_headers($fileUrl, 1);

// Revisar si la cabecera 'Content-Disposition' existe
if (isset($headers['Content-Disposition'])) {
    // Buscar el nombre del archivo en la cabecera 'Content-Disposition'
    $disposition = $headers['Content-Disposition'];
    if (preg_match('/filename="([^"]+)"/', $disposition, $matches)) {
        // El nombre del archivo es el valor de la primera coincidencia
        $fileName = $matches[1];
    } else {
        // Si no se encuentra el nombre en la cabecera, usar un nombre por defecto
        $fileName = 'song.mp3';
    }
} else {
    // Si no hay 'Content-Disposition', usar un nombre por defecto
    $fileName = 'song.mp3';
}

// Ruta donde se guardará temporalmente el archivo
$destination = 'C:/xampp/htdocs/Music-Player/Music_temp/' . $fileName;

// Descargar y guardar el archivo
if (file_put_contents($destination, file_get_contents($fileUrl))) {
    // Redirigir a la página del reproductor después de la descarga
    header("Location: ../Prueba.html");
    exit();
} else {
    echo "Error al descargar el archivo.";
}
?>

