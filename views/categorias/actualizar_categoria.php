<?php 
    include '../../bd/conexion.php';

    $descripcion = "";
        
    
    if(isset($_GET["id"])){
        $categoria = $_GET["id"];
        $sql = "SELECT * FROM categorias WHERE categoria = '$categoria'";
        $result = $conn->query($sql);

        if(!$result){
            die("Invalid Query: " . $conn->error);
        }
        
        while($row = $result->fetch_assoc()){
            $descripcion = $row["cdesc"];
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $categoria = $_POST["categoria"];
        $descripcion = $_POST["descripcion"];

        $sql = "UPDATE categorias SET cdesc='$descripcion'
                WHERE categoria = '$categoria'";
        
        $result = $conn->query($sql);
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
        <h2>Actualizar Categoria</h2>
        <!-- Formulario de Datos -->
        <form action="actualizar_categoria.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="categoria" value="<?php echo $categoria ?>" hidden>
            <!-- Descripcion -->
            <div class="row mb-3">
                <label for="" class="col-sm-3 col-form-label">Descripcion</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="descripcion" value="<?php echo $descripcion ?>" required>
                </div>
            </div>
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
