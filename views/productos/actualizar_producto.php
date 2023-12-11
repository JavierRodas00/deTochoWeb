<?php 
    include '../../bd/conexion.php';

    $mostrar = "";
    $nombre = "";
    $pdesc = "";
    $precio = "";
    $categoria = "";
    $inventario = "";
    $imagen = "";
        
    
    if(isset($_GET["id"])){
        $producto = $_GET["id"];
        $sql = "SELECT * FROM productos WHERE producto = '$producto'";
        $result = $conn->query($sql);

        if(!$result){
            die("Invalid Query: " . $conn->error);
        }
        
        while($row = $result->fetch_assoc()){
            $mostrar = $row["mostrar"];
            $nombre = $row["nombre"];
            $pdesc = $row["pdesc"];
            $precio = $row["precio"];
            $categoria = $row["categoria"];
            $inventario = $row["inventario"];
            $imagen = $row["imagen"];
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $producto = $_POST["producto"];
        $mostrar = $_POST["mostrar"];
        $nombre = $_POST["nombre"];
        $pdesc = $_POST["pdesc"];
        $precio = $_POST["precio"];
        $categoria = $_POST["categoria"];
        $inventario = $_POST["inventario"];
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
            $imagen = base64_encode(file_get_contents($_FILES['imagen']['tmp_name']));
        } else {
            $imagen = $_POST["img1"];
        }

        $sql = "UPDATE productos SET mostrar='$mostrar', nombre='$nombre', pdesc='$pdesc', precio='$precio', categoria='$categoria', inventario='$inventario', imagen='$imagen'
                WHERE producto = '$producto'";
        
        $result = $conn->query($sql);
        $arr = [];
        if($result == true){
            header('Location: /detocho/views/productos/');
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
        <h2>Actualizar Producto</h2>
        <!-- Formulario de Datos -->
        <form action="actualizar_producto.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="producto" hidden value="<?php echo $producto; ?>">
            <!-- Mostrar -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Mostrar</label>
                <div class="col-sm-6">
                    <select name="mostrar" id="mostrar" class="form-control" required>
                        <option value="0" selected>No</option>
                        <option value="1" <?php if($mostrar=="1") echo "selected"; ?>>Si</option>
                    </select>
                </div>
            </div>
            <!-- Nombre -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" required>
                </div>
            </div>
            <!-- Descripcion -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Descripcion</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="pdesc" rows="4" cols="50" required><?php echo $pdesc; ?></textarea>
                </div>
            </div>
            <!-- Precio -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Precio</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="precio" value="<?php echo $precio; ?>" required>
                </div>
            </div>
            <!-- Categoria -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Categoria</label>
                <div class="col-sm-6">
                    <select name="categoria" id="categoria" class="form-control" required>
                        <option value="0" selected></option>
                        <?php
                            include '../../bd/conexion.php';
                            $sql = "SELECT * FROM categorias";
                            $result = $conn->query($sql);

                            if(!$result){
                                die("Invalid Query: " . $conn->error);
                            }
                            
                            while($row = $result->fetch_assoc()){
                        ?>
                        <option value="<?php echo $row['categoria']; ?>"<?php if($row['categoria']==$categoria) echo "selected"; ?>><?php echo $row["cdesc"]; ?></option>
                        <?php 
                            } 
                        ?>
                    </select>
                </div>
            </div>
            <!-- Inventario -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Inventario</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="inventario" value="<?php echo $inventario; ?>" required>
                </div>
            </div>
            <!-- Imagen -->
            <div class="row mb-3">
                <label for="imagen" class="col-sm-3 col-form-label">Imagen</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" >
                </div>
            </div>
            <input type="text" hidden name="img1" value="<?php echo $imagen; ?>">
            <?php echo '<img src="data:image/jpeg;base64,' . $imagen . '" alt="Imagen procesada" width="200">'; ?>
            <!-- Boton -->
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