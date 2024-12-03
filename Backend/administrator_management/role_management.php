<?php
include_once("../BD.php");



// Connect to the database
$conn = conexion::conexion_bd();

if ($conn) {
    // Prepare a query
    $sql = "UPDATE user_
        SET user_rol_id = :rol
        WHERE user_.user_name = :User_Name";

    // Execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':User_Name', $User_Name);
    $stmt->bindParam(':rol', $rol);
    $User_Name = $_POST['username'];
    $rol = $_POST['rol'];
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the results
    if ($results == null) {
        echo "<br>";
        echo "No se cambio el rol";
    }






    // Prepare a query
    $sql = "INSERT INTO artist (artist_name)
    SELECT user_name
FROM user_
WHERE user_rol_id = 3 AND user_name = :User_Name AND
 NOT EXISTS (
    SELECT 1 FROM artist 
    WHERE artist_name = :User_Name)
";

    // Execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':User_Name', $User_Name);
    $rol = $_POST['rol'];
    $User_Name = $_POST['username'];
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the results
    


        header("Location: ../../Frontend/administrator_management/role_management.html");
        exit();
    
}


?>