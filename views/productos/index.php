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
        <h2>Lista de Productos</h2>
        <!-- Boton nuevo producto -->
        <a href="nuevo_producto.php" class="btn btn-primary" role="button">
            Nuevo Producto
        </a>
        <br>
        <!-- Buscador -->
        <br>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="buscar" name="buscar" class="form-control" placeholder="Buscar"/>
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
                    <th>ID PRODUCTO</th>
                    <th>MOSTRAR</th>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION</th>
                    <th>PRECIO</th>
                    <th>CATEGORIA</th>
                    <th>INVENTARIO</th>
                    <th>IMAGEN</th>
                </tr>
            </thead>
            <!-- Cuerpo de tabla -->
            <tbody>
                <?php
                    include '../../bd/conexion.php';


                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $buscar = $_POST["buscar"];
                        if($buscar === ''){
                            $sql = "SELECT * FROM productos";
                        }
                        else{
                            $sql = "SELECT * FROM productos WHERE 
                                        nombre LIKE '%$buscar%' OR
                                        pdesc LIKE '%$buscar%' OR
                                        precio LIKE '%$buscar%' OR 
                                        inventario LIKE '%$buscar%'";
                        }
                    }
                    else{
                        if(isset($_GET['id'])){
                            $categoria = $_GET['id'];
                            $sql = "SELECT * FROM productos WHERE categoria = '$categoria'";
                        }
                        else{
                            $sql = "SELECT * FROM productos";
                        }
                    }
                    $result = $conn->query($sql);

                    if(!$result){
                        die("Invalid Query: " . $conn->error);
                    }
                    
                    while($row = $result->fetch_assoc()){
                ?>

                <tr>
                    <td><?php echo $row["producto"]; ?></td>
                    <td>
                        <?php 
                            if($row["mostrar"]=="1"){
                                echo "Si";
                            } 
                            else echo "No";
                        ?>
                    </td>                    
                    <td><?php echo $row["nombre"]; ?></td>
                    <td><?php echo $row["pdesc"]; ?></td>
                    <td><?php echo $row["precio"]; ?></td>
                    <td>
                        <?php 
                            $categoria = $row["categoria"];
                            $sql = "SELECT * FROM categorias WHERE categoria = '$categoria'";
                            $result1 = $conn->query($sql);
                            if(!$result1){
                                die("Invalid Query: " . $conn->error);
                            }
                            
                            while($row1 = $result1->fetch_assoc()){
                                echo $row1["cdesc"];
                            } 
                        ?>
                    </td>
                    <td><?php echo $row["inventario"]; ?></td>
                    <td><?php echo '<img src="data:image/jpeg;base64,' . $row["imagen"] . '" alt="Imagen procesada" width="75">'; ?></td>
                    <td>
                        <a href='<?php echo "actualizar_producto.php?id=".$row["producto"]."]"; ?>' class="btn btn-primary btn-sm">Editar</a>
                        <a href='<?php echo "eliminar_producto.php?id=".$row["producto"]."]"; ?>' class="btn btn-danger btn-sm">Borrar</a>
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