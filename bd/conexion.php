<?php 

    $servername = "localhost";
    $username = "root";     
    $password = "";           
    $dbname = "deTocho"; 

    // Crear una conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

?>