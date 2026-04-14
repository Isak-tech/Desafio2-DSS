<?php require_once('config/conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Control de Asistencia</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div style="max-width: 400px; margin: auto; padding: 20px;">
        <h2>Registro de Estudiante</h2>
        <form method="POST">
            <label>Nombre Completo:</label><br>
            <input type="text" name="nombre" required style="width: 100%; margin-bottom: 10px;"><br>

            <label>Correo Electrónico:</label><br>
            <input type="email" name="correo" required style="width: 100%; margin-bottom: 10px;"><br>

            <label>Contraseña:</label><br>
            <input type="password" name="contrasena" required style="width: 100%; margin-bottom: 10px;"><br>

            <button type="submit" name="registrar" style="width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer;">Registrar Cuenta</button>
        </form>

        <?php
        if (isset($_POST['registrar'])) {
            // Requisito: Cifrar la contraseña antes de guardar [cite: 20]
            $pass_cifrada = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
            
            try {
                // Requisito: Usar PDO y sentencias preparadas [cite: 22, 41]
                $sql = "INSERT INTO usuarios (nombre, correo, contraseña) VALUES (?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([$_POST['nombre'], $_POST['correo'], $pass_cifrada]);
                
                echo "<p style='color: green;'>¡Registro exitoso! <a href='login.php'>Inicia sesión</a></p>";
            } catch (PDOException $e) {
                echo "<p style='color: red;'>Error: El correo ya existe.</p>";
            }
        }
        ?>
    </div>
</body>
</html>