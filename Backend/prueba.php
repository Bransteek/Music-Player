<?php
session_start();
if(isset($_SESSION['usuario'])){
    $usuario = $_SESSION['usuario'];
    $rol = $_SESSION['rol'];

    echo $usuario;
    echo $rol;
}else{
    echo "no dio";
}


?>
