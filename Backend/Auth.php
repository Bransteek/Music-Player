<?php
    include_once("BD.php");
    $User_Name = $_POST['username'];
    $Password  = $_POST['password'];

    // Connect to the database
    $conn = conexion::conexion_bd();

    if ($conn) {
        // Prepare a query
        $sql = "SELECT * from user_ Where user_name = '$User_Name' and password_ ='$Password'";

        // Execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the results
        if($results == null){
            echo "<br>";
            echo "Usuario o Contraseña incorrectos";
        }else{
            foreach ($results as $row) {
                echo "<br>";
                echo "User: " . $row['user_name'] . " - Email: " . $row['email'] . " - Password: " . $row['password_'] . "<br>";
            }
        }

    }
?>
