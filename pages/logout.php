<?php
    session_start();
    session_destroy();//despues de abrir la sesion la cierro, despues de esto redirecionar a login
    header('location:../index.php');//redirigiendo a index.php
?>