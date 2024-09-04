<?php
class conexion{
    public static function conexion_bd(){
        $host ="localhost";
        $dbname="50_de_cilantro";
        $username="postgres";
        $password="1040871723";

        try{
            $conn = new PDO ("pgsql:host = $host; dbname = $dbname",$username,$password);
            echo "Se conecto correctamente a la base de datos";

        }catch(PDOException $exp){
            echo("No se pudo conectar a la base de datos, $exp");

        }
        return $conn;
    }
}
?>