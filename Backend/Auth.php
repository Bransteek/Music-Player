<?php
include_once("BD.php");



// Connect to the database
$conn = conexion::conexion_bd();

if ($conn) {
    // Prepare a query
    $sql = "SELECT user_.user_name , rol.rol_name
        FROM user_ 
        JOIN rol ON user_.user_rol_id = rol.rol_id
        WHERE user_name = :User_Name AND password_ = :pass";

    // Execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':User_Name', $User_Name);
    $stmt->bindParam(':pass', $pass);
    $User_Name = $_POST['username'];
    $pass = $_POST['password'];
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the results
    if ($results == null) {
        echo "<br>";
        echo "Usuario o Contraseña incorrectos";
    } else {
        foreach ($results as $row) {
            session_start();
            $_SESSION['usuario'] = $row['user_name'];
            $_SESSION['rol'] = $row['rol_name'];
        }

        header("Location: ../index.html");
        exit();
    }

}
?>