<?php
    // Inicia la sesión
    session_start();

    // Elimina todas las variables de sesión
    $_SESSION = array();

    // Destruye la sesión
    session_destroy();

    // Redirige al usuario a la página de inicio de sesión u otra página de tu elección
    header('Location: /detocho');
    exit();   
?>