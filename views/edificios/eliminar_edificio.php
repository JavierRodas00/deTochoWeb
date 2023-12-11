<?php 
    include '../../bd/conexion.php';
    $edificio = $_GET["id"];

    $sql = "DELETE FROM edificios WHERE edificio = '$edificio'";
    $result = $conn->query($sql);

    if($result){
        header('Location: index.php');
    }

?>