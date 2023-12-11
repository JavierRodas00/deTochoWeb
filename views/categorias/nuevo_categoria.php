<?php
    include '../../bd/conexion.php';
    $descripcion = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $descripcion = $_POST["descripcion"];

        $sql = "INSERT INTO categorias (cdesc) 
                VALUES ('$descripcion')";
        
        $result = $conn->query($sql);
        $arr = [];
        if($result == true){
            header('Location: /detocho/views/categorias/');
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
        <h2>Nueva Categoria</h2>
        <!-- Formulario de Datos -->
        <form action="nuevo_categoria.php" method="POST" enctype="multipart/form-data">
            <!-- DESCRIPCION -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Descripcion</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="descripcion" value="" required>
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