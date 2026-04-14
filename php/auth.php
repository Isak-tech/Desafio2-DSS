<?php
// Script de autenticación de usuarios
// 1. Requerir la conexión y asegurar el inicio de sesión
require_once('../config/conexion.php');
session_start();

// 2. Verificar que se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_input = trim($_POST['usuario']);
    $pass_input = trim($_POST['contrasena']);

    try {
         
        // Buscamos al usuario por su nombre de usuario o correo.
       
        $sql = "SELECT id, nombre_completo, contrasena FROM usuarios WHERE usuario_correo = :user LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':user', $usuario_input);
        $stmt->execute();

        $usuario_db = $stmt->fetch();

        
         // usamos password_verify para validar contra el hash.
        
        if ($usuario_db && password_verify($pass_input, $usuario_db['contrasena'])) {
            
            //Credenciales correctas: Iniciar Sesión 
            $_SESSION['user_id'] = $usuario_db['id'];
            $_SESSION['nombre_completo'] = $usuario_db['nombre_completo']; // Requisito 
            $_SESSION['autenticado'] = "si"; // Usado por seguridad.php

            // Redirigir a la página de bienvenida 
            header("Location: ../home.php");
            exit();

        } else {
            // Credenciales incorrectas 
            header("Location: ../login.php?error=1");
            exit();
        }

    } catch (PDOException $e) {
        die("Error en el sistema de autenticación.");
    }
} else {
    header("Location: ../login.php");
    exit();
}