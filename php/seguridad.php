<?php
// Iniciamos la sesión para poder revisar las variables
session_start();

// Si no existe la variable de sesión 'user_id', significa que no se ha logueado
if (!isset($_SESSION['user_id'])) {
    // Lo mandamos directo al login
    header("Location: login.php");
    exit();
}
?>