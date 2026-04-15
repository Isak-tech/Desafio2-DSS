<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Control de Asistencia</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="card">
        <h2>¡Hola de nuevo!</h2>
        <p class="welcome-text">Bienvenido al Sistema de Control de Asistencia. Por favor, ingresa tus credenciales.</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">Usuario o contraseña incorrectos.</div>
        <?php endif; ?>

        <form action="php/auth.php" method="POST">
            <div class="form-group">
                <label>Usuario o Correo</label>
                <input type="text" name="usuario" required placeholder="Ingresa tu usuario">
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="contrasena" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn-primary">Iniciar Sesión</button>
        </form>
        
        <p style="margin-top: 1.5rem; font-size: 0.9rem;">
            ¿Eres nuevo? <a href="registro.php">Crea una cuenta aquí</a>
        </p>
    </div>
</body>
</html>