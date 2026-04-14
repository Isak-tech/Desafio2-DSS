<?php 
require_once('php/seguridad.php'); // Requisito: Bloquear acceso directo [cite: 46]
require_once('config/conexion.php'); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Asistencia</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div style="max-width: 600px; margin: auto; text-align: center; padding: 50px;">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_completo']); ?></h1>
        <p>Has ingresado como Estudiante.</p>

        <form method="POST">
            <button type="submit" name="marcar" style="padding: 20px; font-size: 18px; background-color: #28a745; color: white; border: none; cursor: pointer; border-radius: 10px;">
                MARCAR MI ASISTENCIA DE HOY
            </button>
        </form>

        <?php
        if (isset($_POST['marcar'])) {
            try {
                $uid = $_SESSION['user_id'];
                // Registramos la asistencia en la tabla correspondiente [cite: 41]
                $sql = "INSERT INTO asistencia (usuario_id) VALUES (?)";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([$uid]);
                echo "<h3 style='color: blue; margin-top: 20px;'>✅ Asistencia registrada correctamente.</h3>";
            } catch (PDOException $e) {
                echo "<p style='color: red;'>Error al registrar la asistencia.</p>";
            }
        }
        ?>
        <br><br>
        <a href="logout.php">Cerrar Sesión</a> </div>
</body>
</html>