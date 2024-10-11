<?php
include_once("BD.php");

// Conectar a la base de datos
$conn = conexion::conexion_bd();

if (!$conn) {
    die("Error en la conexión a la base de datos.");
}

// Preparar la consulta con PDO (sin parámetros, ya que ID está fijado en 1)
$query = "SELECT song_file FROM song WHERE song_id = 1";
$stmt = $conn->prepare($query);

// Ejecutar la consulta (sin pasar ningún parámetro)
$stmt->execute();

// Obtener los datos binarios
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    // Asegúrate de que el campo tiene un valor
    if (isset($row['song_file'])) {
        $archivo_mp3 = $row['song_file'];

        // Obtener los datos binarios directamente desde PDO
        $contenido_binario = $archivo_mp3;

        // Definir la ruta para guardar el archivo
        $ruta_archivo = 'C:\\xampp\\htdocs\\Music-Player\\Music_temp\\cancion.mp3';

        // Escribir el contenido binario en el archivo
        file_put_contents($ruta_archivo, pg_unescape_bytea($archivo_mp3));

        echo "Archivo guardado en: " . $ruta_archivo;
    } else {
        echo "No se encontró el campo 'song_file'.";
    }
} else {
    echo "No se encontró la canción.";
}

// Cerrar la conexión
$conn = null;
?>