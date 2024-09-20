<?php 
include_once("BD.php");

// Conectar a la base de datos
$conn = conexion::conexion_bd();

if (!$conn) {
    die("Error en la conexión a la base de datos.");
}

// Obtener el ID de la canción desde el parámetro de la URL
$song_id = isset($_GET['id']) ? $_GET['id'] : 1;

// Preparar la consulta con PDO
$query = "SELECT song_file FROM song WHERE song_id = :id";
$stmt = $conn->prepare($query);

// Ejecutar la consulta
$stmt->execute([':id' => $song_id]);

// Obtener los datos binarios
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica si se obtuvo la fila
if ($row) {
    // Asegúrate de que el campo tiene un valor
    if (isset($row['song_file'])) {
        $archivo_mp3 = $row['song_file'];

        // Obtener los datos binarios directamente desde PDO
        $contenido_binario = $stmt->fetchColumn();

        // Definir la ruta para guardar el archivo
        $ruta_archivo = 'C:\\xampp\\htdocs\\Music-Player\\Music_temp\\cancion.mp3';

        // Escribir el contenido binario en el archivo
        file_put_contents($ruta_archivo, $contenido_binario);

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







