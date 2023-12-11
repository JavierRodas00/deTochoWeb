<?php 

    include("../../bd/conexion.php");

    $action = $_GET["action"];
    if ($action == "ordenRecibida") {
        $sql = "SELECT pe.pedido, pe.usuario, pe.direccion, pe.estado, pp.producto, pp.cantidad,
                       pr.*
                FROM pedidos pe, detalle_pedido pp, productos pr
                WHERE pe.pedido = pp.pedido
                AND pr.producto = pp.producto
                AND pe.estado < 3
                ORDER BY pe.fecha";
        $res = $conn -> query($sql);
        $count = mysqli_num_rows($res);

        if($count > 0){
            $pedidos = array();
            $productos = array();
            $encabezado = array();
            $lastIdPedido = "1";
            $actualIdPedido;
            $cont = 0;
            $auxDatos;

            while ($datos = mysqli_fetch_assoc($res)) {
                $actualIdPedido = $datos["pedido"];
                if($actualIdPedido == $lastIdPedido || $cont == 0){
                    $lastIdPedido = $actualIdPedido;
                    $cont = $cont + 1;
                    $auxDatos = $datos;
                    $producto = array(
                        "id_producto"=> $datos["producto"],
                        "nombre_producto"=> $datos["nombre"],
                        "descripcion"=> $datos["pdesc"],
                        "precio"=> $datos["precio"],
                        "imagen"=> "",
                        "categoria"=> $datos["categoria"],
                        "cantidad_producto"=> $datos["cantidad"],
                        "precio_producto"=> strval(intval($datos["precio"]) * intval($datos["cantidad"])),
                    );
                    array_push($productos, $producto);
                }
                else{
                    $encabezado = array(
                        "id_pedido"=> $auxDatos["pedido"],
                        "id_usuario"=> $auxDatos["usuario"],
                        "id_direccion_usuario"=> $auxDatos["direccion"],
                        "estado"=> $auxDatos["estado"],
                        "productos"=> $productos,
                    );
                    array_push($pedidos, $encabezado);
                    $productos = array();
                    $lastIdPedido = $actualIdPedido;
                    $cont = $cont + 1;
                    $auxDatos = $datos;
                    $producto = array(
                        "id_producto"=> $datos["producto"],
                        "nombre_producto"=> $datos["nombre"],
                        "descripcion"=> $datos["pdesc"],
                        "precio"=> $datos["precio"],
                        "imagen"=> "",
                        "categoria"=> $datos["categoria"],
                        "cantidad_producto"=> $datos["cantidad"],
                        "precio_producto"=> strval(intval($datos["precio"]) * intval($datos["cantidad"])),
                    );
                    array_push($productos, $producto);
                }
                if($cont == $count ){
                    $encabezado = array(
                        "id_pedido"=> $datos["pedido"],
                        "id_usuario"=> $datos["usuario"],
                        "id_direccion_usuario"=> $datos["direccion"],
                        "estado"=> $datos["estado"],
                        "productos"=> $productos,
                    );
                    array_push($pedidos, $encabezado);
                }
                
                
            }
            
            echo json_encode($pedidos, JSON_PRETTY_PRINT);
        }
    }

    if ($action == "modificarEstado"){
        $id_pedido = $_POST["id_pedido"];
        $estado = $_POST["estado"];


        $sql = "UPDATE pedidos SET estado = '$estado' WHERE pedido = '$id_pedido'";
        $res = $conn -> query($sql);

    }

    if($action == "informacionPedido"){
        $id_pedido = $_POST["id_pedido"];
        $sql = "SELECT u.nombre, u.apellido, e.nombre as edificio, du.numero, p.fecha
                FROM usuarios u, usuario_direccion du, edificios e, pedidos p
                WHERE p.direccion = du.usuario_direccion
                AND p.usuario = u.usuario
                AND du.edificio = e.edificio
                AND p.pedido = '$id_pedido'";
        $res = $conn -> query($sql);
        $count = mysqli_num_rows($res);

        if($count > 0){
            while($datos = mysqli_fetch_assoc($res)){
                $respuesta = array(
                    "usuario" => $datos["nombre"] . " " . $datos["apellido"],
                    "direccion" => $datos["edificio"] . ", " . $datos["numero"],
                    "fecha" => $datos["fecha"]
                );
            }
        }
        echo json_encode($respuesta);
    }
?>