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
        // Buscamos al usuario por su correo (según tu tabla SQL)
        // Ajustamos los nombres de las columnas: correo y contraseña
        $sql = "SELECT id, nombre, contraseña FROM usuarios WHERE correo = :user LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':user', $usuario_input);
        $stmt->execute();

        $usuario_db = $stmt->fetch();

        // 3. Verificar la contraseña usando password_verify() [cite: 28, 44]
        // Se usa la columna 'contraseña' de tu base de datos
        if ($usuario_db && password_verify($pass_input, $usuario_db['contraseña'])) {
            
            // Credenciales correctas: Iniciar Sesión 
            $_SESSION['user_id'] = $usuario_db['id'];
            $_SESSION['nombre_completo'] = $usuario_db['nombre']; // Requisito: Guardar nombre en sesión [cite: 31]
            $_SESSION['autenticado'] = "si"; 

            // Redirigir a la página de bienvenida (home.php) [cite: 32]
            header("Location: ../home.php");
            exit();

        } else {
            // Credenciales incorrectas: Redirigir al login con error [cite: 34]
            header("Location: ../login.php?error=1");
            exit();
        }

    } catch (PDOException $e) {
        // Mensaje de error mínimo para seguridad [cite: 42]
        die("Lo sentimos, ha ocurrido un error en el sistema de autenticación.");
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>