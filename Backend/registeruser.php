<?php
include_once("BD.php");

$conn = conexion::conexion_bd();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

if ($conn) {
 
$user_name=htmlspecialchars($user);
$user_password=htmlspecialchars($password);
$user_email=htmlspecialchars($email);
$query = "INSERT INTO user_ (user_name, password_, email, user_rol_id) 
                  VALUES (:user_name, :password_, :email, 2)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_name', $user_name);
$stmt->bindParam(':password_', $user_password);
$stmt->bindParam(':email', $user_email);
// Ejecutar la consulta (sin pasar ningún parámetro)


if ($stmt->execute()) {
    // Redirigir a la página de éxito si se crea la playlist
    header("Location: ../Frontend/Login.html");
    exit();
} else {
    // Mostrar un mensaje de error si la inserción falla
    echo "No se pudo crear la playlist. Inténtalo de nuevo.";
    header("Location: ../Frontend/register.html");
    exit();
}
} else {
echo "Error en la conexión a la base de datos.";
}

}

?>