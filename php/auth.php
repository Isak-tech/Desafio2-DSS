<?php
require_once('../config/conexion.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_input = trim($_POST['usuario']);
    $pass_input = trim($_POST['contrasena']);

    try {
        // Buscamos al usuario por correo O por nombre (usuario)
        $sql = "SELECT id, nombre, password FROM usuarios WHERE correo = :correo OR nombre = :nombre LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':correo', $usuario_input);
        $stmt->bindParam(':nombre', $usuario_input);
        $stmt->execute();

        $usuario_db = $stmt->fetch();

        // Validamos la contraseña usando password_verify
        if ($usuario_db && password_verify($pass_input, $usuario_db['password'])) {
            
            $_SESSION['user_id'] = $usuario_db['id'];
            $_SESSION['nombre_completo'] = $usuario_db['nombre']; 
            $_SESSION['autenticado'] = "si"; 

            header("Location: ../home.php");
            exit();

        } else {
            // Error de credenciales
            header("Location: ../login.php?error=1");
            exit();
        }

    } catch (PDOException $e) {
        // En desarrollo puedes usar die($e->getMessage()); para ver el error real
        die("Error en el sistema de autenticación: " . $e->getMessage());
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>