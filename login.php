<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión - Control de Asistencia</title>
    <link rel="stylesheet" href="css/estilos.css"> </head>
<body>
    <h2>Iniciar Sesión</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;">Usuario o contraseña incorrectos. Intente de nuevo.</p>
    <?php endif; ?>

    <form action="php/auth.php" method="POST">
        <label for="usuario">Usuario o Correo:</label><br>
        <input type="text" name="usuario" id="usuario" required><br><br>

        <label for="contrasena">Contraseña:</label><br>
        <input type="password" name="contrasena" id="contrasena" required><br><br>

        <button type="submit">Ingresar</button>
    </form>
    
    <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
</body>
</html>