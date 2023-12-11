<?php
    include('../../bd/conexion.php');

    $sql = "SELECT * FROM edificios";
    $res = mysqli_query($conn, $sql);
    $lista = array();
    $count = mysqli_num_rows($res);

    if($count > 0){
        while($datos = mysqli_fetch_assoc($res)){
            $fila = array('id_edificio' => $datos['edificio'],
                          'nombre_edificio' => $datos['nombre'],
                          'avenida_edificio' => $datos['avenida'],
                          'calle_edificio' => $datos['calle'],
                          'numero_edificio' => $datos['calle'],
                          'zona' => $datos['zona'],
                        );
            array_push($lista, $fila);
        }
        echo json_encode($lista);
    }
    else{
        echo '0';
    }

    $conn->close();
?>