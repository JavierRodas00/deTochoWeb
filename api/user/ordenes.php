<?php

    include("../../bd/conexion.php");

    $action = $_GET["action"];


    if ($action == "getAllOrders") {
        $id_usuario = $_POST["id_usuario"];
        $sql = "SELECT pe.pedido, pe.usuario, pe.direccion, pe.estado, pp.producto, pp.cantidad,
                    pr.*
                FROM pedidos pe, detalle_pedido pp, productos pr
                WHERE pe.pedido = pp.pedido
                AND pr.producto = pp.producto
                AND pe.estado < 3
                AND pe.usuario = '$id_usuario'
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
                        "precio_producto"=> strval(intval($datos["precio"]) * intval($datos["producto"])),
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
?>