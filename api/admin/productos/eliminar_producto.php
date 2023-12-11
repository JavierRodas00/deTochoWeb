<?php
    include('../../../bd/conexion.php');

    $id_producto = $_POST["id_producto"];

    $sql = "UPDATE productos SET mostrar='0' WHERE producto='$id_producto'";
    $res = mysqli_query($conn, $sql);

    $arr = [];

    if($res == true){
        $arr["success"] = "true";
    }
    else{
        $arr["success"] = "false";
    }
    echo json_encode($arr);
    $conn -> close();
?>