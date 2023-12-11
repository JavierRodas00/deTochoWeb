<?php
    include("../../bd/conexion.php");

    $action = $_GET["action"];

    if ($action == "agregar") {

        $descripcion_categoria = $_POST["descripcion_categoria"];

        $sql = "INSERT INTO categorias(cdesc) 
                VALUES('".$descripcion_categoria."')";

        $result = $conn->query($sql);

        $arr = [];
        if($result == true){
            $ultimo_id = mysqli_insert_id($conn); 
            $arr = array(
                "success"=> "true",
                "id" => $ultimo_id
            );
            echo json_encode($arr);
        }
        else{
            $arr["success"] = "false";
            echo json_encode($arr);
        }
    }
    else if ($action == "eliminar") {
        $id_producto = $_POST["id_categoria"];

        $sql = "DELETE FROM categorias WHERE categoria = '$id_producto'";
        $res = mysqli_query($conn, $sql);

        $arr = [];

        if($res == true){
            $arr["success"] = "true";
        }
        else{
            $arr["success"] = "false";
        }
        echo json_encode($arr);
    }
    else if ($action == "ver") {
        $sql = "SELECT * FROM categorias";
        $res = mysqli_query($conn, $sql);
        $lista = array();
        $count = mysqli_num_rows($res);

        $arr=[];

        if($count > 0){
            while($datos = mysqli_fetch_assoc($res)){
                $fila = array('id_categoria' => $datos['categoria'],
                            'descripcion_categoria' => $datos['cdesc']);
                array_push($lista, $fila);
            }
            echo json_encode($lista);
        }
        else{
            echo '0';
        }
    }
    $conn->close();
?>