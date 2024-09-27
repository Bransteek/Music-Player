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
        $stmt -> bindParam(':User_Name',$User_Name);
        $stmt -> bindParam(':rol',$rol);
        $User_Name = $_POST['username'];
        $rol  = $_POST['rol'];
        $stmt->execute();

        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the results
        if($results == null){
            echo "<br>";
            echo "No se cambio el rol";
        }else{
        

            header("Location: ../../Frontend/administrator_management/role_management.html");
            exit();
        }
        }

    
?>
