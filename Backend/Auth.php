<?php
    include_once("BD.php");
    

    
    // Connect to the database
    $conn = conexion::conexion_bd();

    if ($conn) {
        // Prepare a query
        $sql = "SELECT * from user_ Where user_name = :User_Name and password_ = :pass";

        // Execute the query
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(':User_Name',$User_Name);
        $stmt -> bindParam(':pass',$pass);
        $User_Name = $_POST['username'];
        $pass  = $_POST['password'];
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
