<?php 
    include '../../bd/conexion.php';

    $usuario = "";
    $correo = "";
    $nombre = "";
    $apellido = "";
    $genero = "";
    $fecha_nac = "";
    $telefono = "";
    $rol = "";
        
    
    if(isset($_GET["id"])){
        $usuario = $_GET["id"];
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $result = $conn->query($sql);

        if(!$result){
            die("Invalid Query: " . $conn->error);
        }
        
        while($row = $result->fetch_assoc()){
            $correo = $row["correo"];
            $nombre = $row["nombre"];
            $apellido = $row["apellido"];
            $genero = $row["genero"];
            $fecha_nac = $row["fecha_nac"];
            $telefono = $row["telefono"];
            $rol = $row["rol"];
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $usuario = $_POST["usuario"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $genero = $_POST["genero"];
        $fecha_nac = $_POST["fecha_nac"];
        $telefono = $_POST["telefono"];
        $rol = $_POST["rol"];

        $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', genero='$genero', fecha_nac='$fecha_nac', telefono='$telefono', rol='$rol'
                WHERE usuario = '$usuario'";
        
        $result = $conn->query($sql);
        if($result == true){
            header('Location: /detocho/views/usuarios/');
        }
        else{
            echo "Error";
        }

        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <title>deTocho</title>
</head>
<?php include '../layouts/app.php'; ?>
<body>
    <div class="container">
        <h2>Actualizar Usuario</h2>
        <!-- Formulario de Datos -->
        <form action="actualizar_usuario.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="usuario" hidden value="<?php echo $usuario; ?>">
            <!-- CORREO -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">CORREO</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="correo" value="<?php echo $correo; ?>" disabled>
                </div>
            </div>
            <!-- NOMBRE -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">NOMBRE</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" required>
                </div>
            </div>
            <!-- APELLIDO -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">APELLIDO</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="apellido" value="<?php echo $apellido; ?>" required>
                </div>
            </div>
            <!-- GENERO -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">GENERO</label>
                <div class="col-sm-6">
                    <select name="genero" id="genero" class="form-control" required>
                        <option value="0" selected></option>
                        <?php
                            include '../../bd/conexion.php';
                            $sql = "SELECT * FROM generos";
                            $result = $conn->query($sql);

                            if(!$result){
                                die("Invalid Query: " . $conn->error);
                            }
                            
                            while($row = $result->fetch_assoc()){
                        ?>
                        <option value="<?php echo $row['genero']; ?>"<?php if($row['genero']==$genero) echo "selected"; ?>><?php echo $row["gdesc"]; ?></option>
                        <?php 
                            } 
                        ?>
                    </select>
                </div>
            </div>
            <!-- FECHA NACIMIENTO -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">FECHA NACIMIENTO</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="fecha_nac" value="<?php echo $fecha_nac; ?>" required>
                </div>
            </div>
            <!-- TELEFONO -->
            <div class="row mb-3">
                <label for="imagen" class="col-sm-3 col-form-label">TELEFONO</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="telefono" value="<?php echo $telefono; ?>" required >
                </div>
            </div>
            <!-- ROL -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">ROL</label>
                <div class="col-sm-6">
                    <select name="rol" id="rol" class="form-control" required>
                        <option value="0" selected></option>
                        <?php
                            include '../../bd/conexion.php';
                            $sql = "SELECT * FROM rol";
                            $result = $conn->query($sql);

                            if(!$result){
                                die("Invalid Query: " . $conn->error);
                            }
                            
                            while($row = $result->fetch_assoc()){
                        ?>
                        <option value="<?php echo $row['rol']; ?>"<?php if($row['rol']==$rol) echo "selected"; ?>><?php echo $row["roldesc"]; ?></option>
                        <?php 
                            } 
                        ?>
                    </select>
                </div>
            </div>
            <!-- BOTON -->
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button class="btn btn-primary">Actualizar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a href="index.php" class="btn btn-outline-primary" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<style>
    body{
        padding-left: 100px;
    }
</style>