<?php 
    include '../../bd/conexion.php';
    $producto = $_GET["id"];

    $sql = "DELETE FROM productos WHERE producto = '$producto'";
    $result = $conn->query($sql);

    if($result){
        header('Location: index.php');
    }

?>