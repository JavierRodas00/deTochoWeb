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
        <h2>Lista de Usuarios</h2>
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
                    <th>ID USUARIO</th>
                    <th>NOMBRE</th>
                    <th>GENERO</th>
                    <th>FECHA NACIMIENTO</th>
                    <th>TELEFONO</th>
                    <th>ROL</th>
                </tr>
            </thead>
            <!-- Cuerpo de tabla -->
            <tbody>
                <?php
                    include '../../bd/conexion.php';
                    
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $buscar = $_POST['buscar'];
                        if($buscar === ''){
                            $sql = "SELECT usuario, correo, nombre, apellido, genero, fecha_nac, telefono, rol
                            FROM usuarios";
                        }
                        else{
                            $sql = "SELECT usuario, correo, nombre, apellido, genero, fecha_nac, telefono, rol
                                    FROM usuarios WHERE 
                                        nombre LIKE '%$buscar%' OR
                                        apellido LIKE '%$buscar%' OR
                                        telefono LIKE '%$buscar%'";
                        }
                    }
                    else{
                        $sql = "SELECT usuario, correo, nombre, apellido, genero, fecha_nac, telefono, rol
                            FROM usuarios";
                    }
                    $result = $conn->query($sql);

                    if(!$result){
                        die("Invalid Query: " . $conn->error);
                    }
                    
                    while($row = $result->fetch_assoc()){
                ?>

                <tr>
                    <td><?php echo $row["usuario"]; ?></td>
                    <td><?php echo $row["nombre"]." ".$row["apellido"]; ?></td>
                    <td>
                        <?php 
                            $genero = $row["genero"];
                            $sql = "SELECT gdesc FROM generos WHERE genero='$genero'";
                            $result1 = $conn->query($sql);
                            if(!$result1){
                                die("Invalid Query: " . $conn->error);
                            }
                            
                            while($row1 = $result1->fetch_assoc()){
                                echo $row1["gdesc"];
                            }
                        ?>
                    </td>
                    <td><?php echo $row["fecha_nac"]; ?></td>
                    <td><?php echo $row["telefono"]; ?></td>
                    <td>
                        <?php 
                            $rol = $row["rol"];
                            $sql = "SELECT roldesc FROM rol WHERE rol='$rol'";
                            $result2 = $conn->query($sql);
                            if(!$result2){
                                die("Invalid Query: " . $conn->error);
                            }
                            
                            while($row2 = $result2->fetch_assoc()){
                                echo $row2["roldesc"];
                            }
                        ?>
                    </td>
                    <td>
                        <a href='<?php echo "actualizar_usuario.php?id=".$row["usuario"]; ?>' class="btn btn-primary btn-sm">Editar</a>
                        <!-- <a href='<?php echo "eliminar_usuario.php?id=".$row["usuario"]; ?>' class="btn btn-danger btn-sm">Borrar</a> -->
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