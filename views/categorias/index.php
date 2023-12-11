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
        <!-- Titulo -->
        <h2>Lista de Categorias</h2>
        <a href="nuevo_categoria.php" class="btn btn-primary" role="button">
            Nueva Categoria
        </a>
        <br>
        
        <!-- Buscador -->
        <br>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="descripcion" name="descripcion" class="form-control" placeholder="Buscar"/>
                    <!-- <label class="form-label" for="form1">Search</label> -->
                </div>
                <button type="submit" class="btn btn-primary" data-mdb-ripple-init>
                    <i class="bx bx-search"></i>
                </button>
            </div>
        </form>
        <br>

        <!-- Tabla -->
        <table class="table">
            <!-- Encabezado -->
            <thead>
                <tr>
                    <th>ID CATEGORIA</th>
                    <th>DESCRIPCION</th>
                </tr>
            </thead>
            <!-- Cuerpo de tabla -->
            <tbody>
                <?php
                    include '../../bd/conexion.php';

                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $descripcion = $_POST["descripcion"];
                        if($descripcion === ''){
                            $sql = "SELECT * FROM categorias";
                        }
                        else{
                            $sql = "SELECT * FROM categorias WHERE cdesc = '$descripcion'";
                        }
                    }
                    else{
                        $sql = "SELECT * FROM categorias";
                    }
                    $result = $conn->query($sql);

                    if(!$result){
                        die("Invalid Query: " . $conn->error);
                    }
                    
                    while($row = $result->fetch_assoc()){
                ?>

                <tr>
                    <td><?php echo $row["categoria"]; ?></td>
                    <td><?php echo $row["cdesc"]; ?></td>
                    <td>
                        <a href='<?php echo "../productos/index.php?id=".$row["categoria"]; ?>' class="btn btn-primary btn-sm">Ver Productos</a>
                        <a href='<?php echo "actualizar_categoria.php?id=".$row["categoria"]; ?>' class="btn btn-primary btn-sm">Editar</a>
                        <a href='<?php echo "eliminar_categoria.php?id=".$row["categoria"]; ?>' class="btn btn-danger btn-sm">Borrar</a>
                    </td>
                </tr>

                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<style>
    body{
        padding-left: 100px;
    }
</style>