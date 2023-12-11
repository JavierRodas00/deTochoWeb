<?php
    include("../../bd/conexion.php");

    $action = $_GET["action"];

    if ($action == "pedir") {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);
        
        $conn -> begin_transaction();
        try{
            $id_usuario = $data["id_usuario"];
            $id_direccion = "";
            $ultimo_id = "";

            // Obtener el id de direccion del usuario
            $sql = "SELECT usuario_direccion FROM usuario_direccion WHERE usuario = '$id_usuario'";
            $result = $conn -> query($sql);
            $count = mysqli_num_rows($result);
            if ($count == 1) {
                while ($datos = mysqli_fetch_assoc($result)) {
                    $id_direccion = $datos["usuario_direccion"];
                }
            }


            // Insertar pedido en tabla pedido
            $lista_productos = $data["lista_productos"];
            $precio = 0.0;

            foreach ($lista_productos as $producto){
                $precio += doubleval($producto["precio"]) * doubleval($producto["cantidad"]);
            }
            $sql = "INSERT INTO pedidos (usuario, direccion, fecha, total) VALUES
                    ('$id_usuario', '$id_direccion', NOW(), '$precio')";
            $result = $conn -> query($sql);
            if($result){
                $ultimo_id = mysqli_insert_id($conn);
            }


            // Insertar productos al pedido
            foreach ($lista_productos as $producto){
                $sql = "INSERT INTO detalle_pedido VALUES ('$ultimo_id', '{$producto["id_producto"]}', '{$producto["cantidad"]}')";
                $result = $conn -> query($sql);
            }

            $conn -> commit();
            echo json_encode(array("id" => $ultimo_id,"id_usuario" => $id_usuario,"id_direccion" => $id_direccion));

        }
        catch(Exception $e) {
            $conn -> rollback();    
        }
        $conn -> close();
    }

?>
