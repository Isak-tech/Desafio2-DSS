<?php require_once('config/conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Control de Asistencia</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="card">
        <h2>Únete a nosotros</h2>
        <p class="welcome-text">Regístrate para comenzar a llevar el control de tu asistencia diaria.</p>
        
        <?php
        if (isset($_POST['registrar'])) {
            $nombre = trim($_POST['nombre']);
            $correo = trim($_POST['correo']);
            $pass_cifrada = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Cifrado obligatorio [cite: 1034]
            
            try {
                // Asegúrate de que los nombres de las columnas coincidan con tu DB
                $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)";
                $stmt = $conexion->prepare($sql); // Uso de PDO [cite: 1036]
                $stmt->execute([$nombre, $correo, $pass_cifrada]);
                
                echo "<div class='alert alert-success'>¡Registro exitoso! <a href='login.php'>Inicia sesión ahora</a></div>";
            } catch (PDOException $e) {
                echo "<div class='alert alert-error'>El correo o usuario ya está registrado.</div>";
            }
        }
        ?>

        <form method="POST">
            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" required placeholder="Tu nombre y apellido">
            </div>
            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="correo" required placeholder="correo@ejemplo.com">
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="contrasena" required placeholder="Crea una clave segura">
            </div>
            <button type="submit" name="registrar" class="btn-primary">Registrarme</button>
        </form>

        <p style="margin-top: 1.5rem; font-size: 0.9rem;">
            ¿Ya tienes cuenta? <a href="login.php">Ingresa aquí</a>
        </p>
    </div>
</body>
</html>