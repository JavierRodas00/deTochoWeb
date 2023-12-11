<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>deTocho</title>
</head>
<body>
    <form method="POST" action="index.php" class="form" >
        <h2 class="form_title">Iniciar Sesion</h2>
        <?php
            // Muestra el mensaje de error si existe
            if (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
        ?>
        <div class="form_container">
            <div class="form_group">
                <input type="text" name="usuario" class="form_input" placeholder=" " >
                <label for="usuario" class="form_label">Usuario</label>
                <span class="form_line"></span>
            </div>
            <div class="form_group">
                <input type="password" name="password" class="form_input" placeholder=" " >
                <label for="password" class="form_label">Contraseña</label>
                <span class="form_line"></span>
            </div>
            <input type="submit" class="form_submit" value="Entrar">
        </div>
    </form>
</body>
</html>

<style>

  @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,300&display=swap');

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body{
        font-family: 'Roboto', sans-serif;
        background-color: #e5e5f7;
        background-image: radial-gradient(#f7bd45 0.1px, #e5e5f7 0.8px);
        background-size: 16px 16px;
        display: flex;
        min-height: 100vh;
    }

    .form{
        background-color: #fff;
        margin: auto;
        width: 90%;
        max-width: 400px;
        padding: 4.5em 3em;
        border-radius: 10px;
        box-shadow: 0 5px 10px -5px rgb(0 0 0 /30%);
        text-align: center;
    }

    .form_title{
        font-size: 2rem;
        margin-bottom: .5em; 
    }

    .form_container{
        margin-top: 3em;
        display: grid;
        gap: 2.5em;

    }

    .form_group{
        position: relative;
        --color: #5757577e;
    }

    .form_input{
        width: 100%;
        background: none;
        color: #706c6c;
        font-size: 1rem;
        padding: .6em .3em;
        border: none;
        outline: none;
        border-bottom: 1px solid var(--color);
        font-family: 'Roboto', sans-serif;
    }

    .form_input:not(:placeholder-shown){
        color: #4d4646;
    }

    .form_input:focus + .form_label,
    .form_input:not(:placeholder-shown) + .form_label{
        transform: translateY(-12px) scale(.7);
        transform-origin: left top;
        color: #3866f2; 
    }

    .form_label{
        color: var(--color);
        cursor: pointer;
        position: absolute;
        top: 0;
        left: 5px;
        transform: translateY(10px);
        transition: transform .5s, color .3s;
    }

    .form_submit{
        background: #3866f2;
        color: #fff;
        font-family: 'Roboto', sans-serif;
        font-weight: 300;
        font-size: 1rem;
        padding: .8em 0;
        border: none;
        border-radius: .5em;
    }

    .form_line{
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #3866f2;
        transform: scale(0);
        transform: left bottom;
        transition: transform .4s;
    }

    .form_input:focus ~ .form_line,
    .form_input:not(:placeholder-shown) ~ .form_line{
        transform: scale(1);
    }

    @media (max-width:425px){
        .form_title{
            font-size: 1.8rem;
        }
    }
</style>

<?php 
    include 'bd/conexion.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtiene los datos del formulario
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['password'];
    
        // Consulta la base de datos para verificar las credenciales
        $query = "SELECT * FROM usuarios WHERE correo = '$usuario' AND password = md5('$contrasena') AND rol = '2'";
        $result = mysqli_query($conn, $query);
    
        // Verifica si se encontró un usuario con las credenciales proporcionadas
        if (mysqli_num_rows($result) == 1) {
            // Inicia la sesión y redirige al usuario a la página de inicio
            $_SESSION['usuario'] = $usuario;
            header('Location: /detocho/views/layouts/app.php');
            exit();
        } else {
            // Mensaje de error si las credenciales son incorrectas
            $error_message = "Usuario o contraseña incorrectos";
        }
    }
?>