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
        <div>
        <div class="chart-container" style="position: relative; height:40%; width:40%">
            <canvas id="usuarioEdificio" class="grafica"></canvas>
        </div>
        <div class="chart-container" style="position: relative; height:40%; width:40%">
            <canvas id="ventasDiaria" class="grafica"></canvas>
        </div>
        <div class="chart-container" style="position: relative; height:40%; width:40%">
            <canvas id="ventasMensual" class="grafica"></canvas>
        </div>
        <div class="chart-container" style="position: relative; height:40%; width:40%">
            <canvas id="ventasAnual" class="grafica"></canvas>
        </div>
        <div class="chart-container" style="position: relative; height:40%; width:40%">
            <canvas id="productosVendidos" class="grafica"></canvas>
        </div>
        <div class="chart-container" style="position: relative; height:40%; width:40%">
            <canvas id="gananciaProductos" class="grafica"></canvas>
        </div>
            
            
            
            
            
            
        </div>
    </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx1 = document.getElementById('usuarioEdificio');
    const ctx2 = document.getElementById('ventasDiaria');
    const ctx3 = document.getElementById('ventasMensual');
    const ctx4 = document.getElementById('ventasAnual');
    const ctx5 = document.getElementById('productosVendidos');
    const ctx6 = document.getElementById('gananciaProductos');

    //Usuarios por edificio
    <?php 
        include '../../bd/conexion.php';

        $sql = "select e.nombre, count(*) as cantidad from edificios e, usuario_direccion ud WHERE e.edificio = ud.edificio group by e.edificio";
        $result = $conn -> query($sql);
        if($result){
    ?>
    new Chart(ctx1, {
        type: 'polarArea',
        data: {
            labels: [
                <?php 
                    while($row = $result->fetch_assoc()){
                        echo '"' . $row["nombre"] . '",';
                    }
                ?>
            ],
            datasets: [{
                label: '# de Usuarios',
                data: [
                    <?php 
                    $result = $conn -> query($sql);
                    while($row = $result->fetch_assoc()){
                        echo $row["cantidad"] . ',';
                    }
                    ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    <?php } ?>



    //Ventas diarias
    <?php
        include '../../bd/conexion.php';
        $sql = "select date(pe.fecha) as fecha, sum(pe.total) as total
                from pedidos pe
                group by date(fecha)";
        $result = $conn -> query($sql);
        if($result){
    ?>
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: [
                <?php 
                    while($row = $result->fetch_assoc()){
                        echo '"' . $row["fecha"] . '",';
                    }
                ?>
            ],
            datasets: [{
                label: 'Ventas',
                data: [
                    <?php 
                        $result = $conn -> query($sql);
                        while($row = $result->fetch_assoc()){
                            echo $row["total"] . ',';
                        }
                    ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
        }
    });


    <?php } ?>

    //Ventas mensuales
    <?php
        include '../../bd/conexion.php';
        $sql = "select month(pe.fecha) as fecha, sum(pe.total) as total
                from pedidos pe
                group by month(fecha)";
        $result = $conn -> query($sql);
        if($result){
    ?>
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: [
                <?php 
                    while($row = $result->fetch_assoc()){
                        echo '"' . $row["fecha"] . '",';
                    }
                ?>
            ],
            datasets: [{
                label: 'Ventas',
                data: [
                    <?php 
                        $result = $conn -> query($sql);
                        while($row = $result->fetch_assoc()){
                            echo $row["total"] . ',';
                        }
                    ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
        }
    });
    <?php } ?>

    //Ventas anuales
    <?php
        include '../../bd/conexion.php';
        $sql = "select year(pe.fecha) as fecha, sum(pe.total) as total
                from pedidos pe
                group by year(fecha)";
        $result = $conn -> query($sql);
        if($result){
    ?>
    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: [
                <?php 
                    while($row = $result->fetch_assoc()){
                        echo '"' . $row["fecha"] . '",';
                    }
                ?>
            ],
            datasets: [{
                label: 'Ventas',
                data: [
                    <?php 
                        $result = $conn -> query($sql);
                        while($row = $result->fetch_assoc()){
                            echo $row["total"] . ',';
                        }
                    ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
        }
    });
    <?php } ?>


    //Productos vendidos ultimo mes
    <?php
        include '../../bd/conexion.php';
        $sql = "select dp.producto, pr.nombre, sum(cantidad) as total
                from detalle_pedido dp, productos pr, pedidos pe
                WHERE dp.producto = pr.producto 
                AND pe.pedido = dp.pedido
                group by producto";
        $result = $conn -> query($sql);
        if($result){
    ?>
    new Chart(ctx5, {
        type: 'pie',
        data: {
            labels: [
                <?php 
                    while($row = $result->fetch_assoc()){
                        echo '"' . $row["nombre"] . '",';
                    }
                ?>
            ],
            datasets: [{
                label: 'Ventas',
                data: [
                    <?php 
                        $result = $conn -> query($sql);
                        while($row = $result->fetch_assoc()){
                            echo $row["total"] . ',';
                        }
                    ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
        }
    });
    <?php } ?>

    //Ganancia productos ultimo mes
    <?php
        include '../../bd/conexion.php';
        $sql = "select dp.producto, pr.nombre, sum(cantidad*pr.precio) as total
                from detalle_pedido dp, productos pr, pedidos pe
                WHERE dp.producto = pr.producto 
                AND pe.pedido = dp.pedido
                group by producto";
        $result = $conn -> query($sql);
        if($result){
    ?>
    new Chart(ctx6, {
        type: 'doughnut',
        data: {
            labels: [
                <?php 
                    while($row = $result->fetch_assoc()){
                        echo '"' . $row["nombre"] . '",';
                    }
                ?>
            ],
            datasets: [{
                label: 'Ventas',
                data: [
                    <?php 
                        $result = $conn -> query($sql);
                        while($row = $result->fetch_assoc()){
                            echo $row["total"] . ',';
                        }
                    ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
        }
    });
    <?php } ?>
</script>

<style>
    .grafica{
        width: 50px;
    }
</style>