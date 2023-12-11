<?php 
    include '../../bd/conexion.php';
    $categoria = $_GET["id"];

    $sql = "DELETE FROM categorias WHERE categoria = '$categoria'";
    $result = $conn->query($sql);

    if($result){
        header('Location: index.php');
    }

?>