<?php
    include '../../bd/conexion.php';
    $nombre = "";
    $pdesc = "";
    $precio = "";
    $categoria = "";
    $inventario = "";
    $imagen = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nombre = $_POST["nombre"];
        $pdesc = $_POST["pdesc"];
        $precio = $_POST["precio"];
        $categoria = $_POST["categoria"];
        $inventario = $_POST["inventario"];
        $imagen = base64_encode(file_get_contents($_FILES['imagen']['tmp_name']));

        $sql = "INSERT INTO productos (nombre, pdesc, precio, categoria, inventario, imagen) 
                VALUES ('$nombre','$pdesc','$precio','$categoria','$inventario','$imagen')";
        
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
        <h2>Nuevo Producto</h2>
        <!-- Formulario de Datos -->
        <form action="nuevo_producto.php" method="POST" enctype="multipart/form-data">
            <!-- Nombre -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nombre" value="" required>
                </div>
            </div>
            <!-- Descripcion -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Descripcion</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="pdesc" rows="4" cols="50" value="" required></textarea>
                </div>
            </div>
            <!-- Precio -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Precio</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="precio" value="" required>
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
                        <option value="<?php echo $row['categoria']; ?>"><?php echo $row["cdesc"]; ?></option>
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
                    <input type="number" class="form-control" name="inventario" value="" required>
                </div>
            </div>
            <!-- Imagen -->
            <div class="row mb-3">
                <label for="imagen" class="col-sm-3 col-form-label">Imagen</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                </div>
            </div>
            <!-- Boton -->
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button class="btn btn-primary">Agregar</button>
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

<!-- <script>
    function errorInsert() {
        // Mensaje de error
        var mensaje = "¡Se ha producido un error!";

        // Muestra la alerta de error
        alert(mensaje);
    }
</script> -->