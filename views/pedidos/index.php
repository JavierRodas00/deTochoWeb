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
        <h2>Lista de Pedidos</h2>
        <!-- Boton nuevo producto -->
        <br>
        <!-- Buscador -->
        <!-- <br>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <div class="form-outline" data-mdb-input-init>
                    <input type="search" id="buscar" name="buscar" class="form-control" placeholder="Buscar"/>
                    <!-- <label class="form-label" for="form1">Search</label> 
                </div>
                <button type="submit" class="btn btn-primary" data-mdb-ripple-init>
                    <i class="bx bx-search"></i>
                </button>
            </div>
        </form> -->
        <br>
        <!-- Tabla -->
        <table class="table">
            <!-- Encabezado -->
            <thead>
                <tr>
                    <th>ID PEDIDO</th>
                    <th>USUARIO</th>
                    <th>FECHA</th>
                    <th>ESTADO</th>
                    <th>DIRECCION</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <!-- Cuerpo de tabla -->
            <tbody>
                <?php
                    include '../../bd/conexion.php';


                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $buscar = $_POST["buscar"];
                        if($buscar === ''){
                            $sql = "SELECT p.pedido, u.nombre, p.fecha, e.edesc, ed.nombre as edificio, ud.numero, p.total
                                    FROM pedidos p, usuarios u, usuario_direccion ud, estados e, edificios ed
                                    WHERE p.usuario = u.usuario
                                    AND p.direccion = ud.usuario_direccion
                                    AND p.estado = e.estado
                                    AND ud.edificio = ed.edificio 
                                    ORDER BY p.pedido";
                        }
                        else{
                            $sql = "SELECT p.pedido, u.nombre, p.fecha, e.edesc, ed.nombre as edificio, ud.numero, p.total
                                    FROM pedidos p, usuarios u, usuario_direccion ud, estados e, edificios ed
                                    WHERE p.usuario = u.usuario
                                    AND p.direccion = ud.usuario_direccion
                                    AND p.estado = e.estado
                                    AND ud.edificio = ed.edificio 
                                    
                                    ORDER BY p.pedido"; 
                            /* "SELECT * FROM pedidos WHERE 
                                        nombre LIKE '%$buscar%' OR
                                        pdesc LIKE '%$buscar%' OR
                                        precio LIKE '%$buscar%' OR 
                                        inventario LIKE '%$buscar%'"; */
                        }
                    }
                    else{                        
                        $sql = "SELECT p.pedido, u.nombre, p.fecha, e.edesc, ed.nombre as edificio, ud.numero, p.total
                                FROM pedidos p, usuarios u, usuario_direccion ud, estados e, edificios ed
                                WHERE p.usuario = u.usuario
                                AND p.direccion = ud.usuario_direccion
                                AND p.estado = e.estado
                                AND ud.edificio = ed.edificio 
                                ORDER BY p.pedido";
                    }
                    $result = $conn->query($sql);

                    if(!$result){
                        die("Invalid Query: " . $conn->error);
                    }
                    
                    while($row = $result->fetch_assoc()){
                ?>

                <tr>
                    <td><?php echo $row["pedido"]; ?></td>                    
                    <td><?php echo $row["nombre"]; ?></td>
                    <td><?php echo $row["fecha"]; ?></td>
                    <td><?php echo $row["edesc"]; ?></td>
                    <td><?php echo $row["edificio"] . ", " . $row["numero"]; ?></td>
                    <td><?php echo $row["total"]; ?></td>
                    <!-- <td>
                        <a href='<?php echo "actualizar_producto.php?id=".$row["producto"]."]"; ?>' class="btn btn-primary btn-sm">Editar</a>
                        <a href='<?php echo "eliminar_producto.php?id=".$row["producto"]."]"; ?>' class="btn btn-danger btn-sm">Borrar</a>
                    </td> -->
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