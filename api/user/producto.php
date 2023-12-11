<?php
    include '../../bd/conexion.php';

    $action = $_GET["action"];

    if ($action == "getAll") {
        $sql = "SELECT * 
                FROM productos p, categorias c
                WHERE p.categoria = c.categoria
                AND p.mostrar = 1
                ORDER BY p.producto";
        $res = mysqli_query($conn, $sql);
        $lista = array();
        $count = mysqli_num_rows($res);

        if($count > 0){
            while($datos = mysqli_fetch_assoc($res)){
                $fila = array('id_producto' => $datos['producto'],
                'nombre_producto' => $datos['nombre'],
                'descripcion' => $datos['pdesc'],
                'precio' => $datos['precio'],
                'imagen_producto' => $datos['imagen'],
                'id_categoria' => $datos['categoria'],
                'descripcion_categoria' => $datos['cdesc'],
            );
                array_push($lista, $fila);
            }
            echo json_encode($lista);
        }
        else{
            echo '0';
        }
    }

    else if ($action == "getFavorites") {
        $id_usuario = $_POST["id_usuario"];
        $sql = "SELECT p.*, c.* 
                FROM favoritos f, producto p, categoria c
                WHERE f.id_producto = p.id_producto AND
                      f.id_usuario = '$id_usuario' AND  
                      p.id_categoria = c.id_categoria
                ORDER BY p.id_producto";
        $res = mysqli_query($conn, $sql);
        $lista = array();
        $count = mysqli_num_rows($res);

        if($count > 0){
            while($datos = mysqli_fetch_assoc($res)){
                $fila = array('id_producto' => $datos['id_producto'],
                'nombre_producto' => $datos['nombre_producto'],
                'descripcion' => $datos['descripcion_producto'],
                'precio' => $datos['precio_producto'],
                'imagen_producto' => $datos['imagen_producto'],
                'id_categoria' => $datos['id_categoria'],
                'descripcion_categoria' => $datos['descripcion_categoria']);
                array_push($lista, $fila);
            }
            echo json_encode($lista);
        }
        else{
            echo '0';
        }
    }

?>