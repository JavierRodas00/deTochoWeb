<?php 
    include '../../bd/conexion.php';
    $action = $_GET["action"];

    // LOGIN     
    if($action == "login"){
        $correo_usuario = $_POST["correo_usuario"];
        $password_usuario = md5($_POST["password_usuario"]);


        $sql = "SELECT * FROM usuarios 
        WHERE correo ='$correo_usuario' 
        AND password ='$password_usuario'";

        $res = mysqli_query($conn, $sql);
        $lista = array();
        $count = mysqli_num_rows($res);

        if($count == 1){
            while($datos = mysqli_fetch_assoc($res)){
                $fila = array(
                    'id_usuario' => $datos['usuario'],
                    'nombre_usuario'=> $datos['nombre'],
                    'apellido_usuario'=> $datos['apellido'],
                    'admin_usuario' => $datos['rol'],
                    'cambio_pass' => $datos['cambio_pass']
                );
                array_push($lista, $fila);
            }
            echo json_encode($lista);
        }
        else{
            echo '0';
        }
    }

    // REGISTRAR USUARIO
    else if($action == "register"){
        $correo_usuario = $_POST["correo_usuario"];
        $nombre_usuario = $_POST["nombre_usuario"];
        $apellido_usuario = $_POST["apellido_usuario"];
        $telefono_usuario = $_POST["telefono_usuario"];
        $id_genero = $_POST["id_genero"];
        $fecha_nac = $_POST["fecha_nac"];
        $password_usuario = md5($_POST["password_usuario"]);

        $id_edificio = $_POST["id_edificio"];
        $numero_apto = $_POST["numero_apto"];

        $sql = "INSERT INTO usuarios(correo, nombre, apellido, genero, fecha_nac, telefono, password) 
                VALUES('$correo_usuario', '$nombre_usuario', '$apellido_usuario', '$id_genero', STR_TO_DATE('$fecha_nac','%Y-%m-%d'), '$telefono_usuario', '$password_usuario')";

        $result = $conn->query($sql);
        if($result){

            $ultimo_id = mysqli_insert_id($conn); 
            $sql2 = "INSERT INTO usuario_direccion (usuario, edificio, numero) VALUES ('$ultimo_id','$id_edificio','$numero_apto')";
            $result2 = $conn->query($sql2);

            if($result2){
                $arr = array(
                "success"=> "true",
                "id" => $ultimo_id
                );
            }
            else{
                $sql3 = "DELETE FROM usuarios WHERE usuario = '$ultimo_id'";
                $result3 = $conn->query($sql3);
            }

            
            echo json_encode($arr);
        }
        else{
            echo json_encode(array("success"=> "false"));
        }
    }

    // OLVIDO SU CONTRASEÑA
    else if($action == "recuperar"){
        $correo_usuario = $_POST["correo_usuario"];
        $telefono_usuario = $_POST["telefono_usuario"];
        $new_password = generarPassword(8);
        $encoded_password = md5($new_password);

        $sql = "UPDATE usuarios SET password = '$encoded_password', cambio_pass = '1'
                WHERE correo = '$correo_usuario' AND telefono = '$telefono_usuario'";

        $result = $conn->query($sql);

        if($result){
            $arr = array(
                "new_password" => $new_password
                );
            echo json_encode($arr);
        }
    }

    // CAMBIAR CONTRASEÑA
    else if($action == "cambiar"){
        $id_usuario = $_POST["id_usuario"];
        $password_usuario = md5($_POST["password_usuario"]);

        $sql = "UPDATE usuarios SET password = '$password_usuario', cambio_pass = '0' WHERE usuario = '$id_usuario'";
        $result = $conn->query($sql);
        if($result){
            $arr = array();
            echo json_encode($arr);
        }
    }

    $conn -> close();


    // Funcion generar password random
    function generarPassword($longitud){
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitudCaracteres = strlen($caracteres);
        $cadenaAleatoria = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indiceAleatorio = mt_rand(0, $longitudCaracteres - 1);
            $cadenaAleatoria .= $caracteres[$indiceAleatorio];
        }
    
        return $cadenaAleatoria;
    }
?>