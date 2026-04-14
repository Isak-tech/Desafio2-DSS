<?php
// Script de autenticación de usuarios 
// 1. Requerir la conexión y asegurar el inicio de sesión
require_once('../config/conexion.php');
session_start();

// 2. Verificar que se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiamos los datos de entrada
    $usuario_input = trim($_POST['usuario']);
    $pass_input = trim($_POST['contrasena']);

    try {
        /**
         * MEJORA: Buscamos al usuario por su correo O por su nombre.
         * Esto permite que el login funcione con ambos campos tal como pide el desafío.
         */
        $sql = "SELECT id, nombre, contraseña FROM usuarios WHERE correo = :user OR nombre = :user LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':user', $usuario_input);
        $stmt->execute();

        $usuario_db = $stmt->fetch();

        /**
         * 3. Verificar la contraseña usando password_verify()
         * Comparamos el texto plano ingresado contra el hash guardado en la BD.
         */
        if ($usuario_db && password_verify($pass_input, $usuario_db['contraseña'])) {
            
            // Credenciales correctas: Iniciamos las variables de sesión requeridas
            $_SESSION['user_id'] = $usuario_db['id'];
            $_SESSION['nombre_completo'] = $usuario_db['nombre']; // Se usará en home.php
            $_SESSION['autenticado'] = "si"; 

            // Redirigir a la página de bienvenida (home.php)
            header("Location: ../home.php");
            exit();

        } else {
            // Credenciales incorrectas: Redirigir al login con un mensaje de error
            header("Location: ../login.php?error=1");
            exit();
        }

    } catch (PDOException $e) {
        // Mensaje de error genérico para no dar pistas a atacantes
        die("Lo sentimos, ha ocurrido un error en el sistema de autenticación.");
    }
} else {
    // Si alguien intenta entrar al script sin enviar el formulario, lo mandamos al login
    header("Location: ../login.php");
    exit();
}
?>