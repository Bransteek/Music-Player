<?php
// Configuración de la base de datos
$DB_HOST = "localhost";
$DB_NAME = "50_de_cilantro";
$DB_USER = "postgres";
$DB_PASSWORD = "Brian_2005";

// Conectar a la base de datos
try {
    $pdo = new PDO("pgsql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
    exit;
}

// Obtener los datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta para verificar las credenciales
$query = 'SELECT COUNT(*) FROM "User" WHERE "User_Name" = :username AND "Password" = :password';
$stmt = $pdo->prepare($query);
$stmt->execute(['username' => $username, 'password' => $password]);
$count = $stmt->fetchColumn();

// Verificar las credenciales y mostrar mensaje directamente
if ($count > 0) {
    echo "Inicio de sesión exitoso";
} else {
    echo "Credenciales incorrectas";
}
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Existing PHP code...
?>
<?php
phpinfo();
?>

