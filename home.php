<?php 
/**
 * Página de Bienvenida y Control de Asistencia
 * Requisito: Bloquear acceso si no está autenticado 
 */
require_once('php/seguridad.php'); 
require_once('config/conexion.php'); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Asistencia - Estudiantes</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="card" style="max-width: 500px;">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_completo']); ?> 👋</h2>
        <p>Has ingresado al Sistema de Control de Asistencia.</p>

        <?php
        if (isset($_POST['marcar'])) {
            try {
                $uid = $_SESSION['user_id']; 

                // VALIDACIÓN DE DUPLICADOS: Evita múltiples registros el mismo día
                $check_sql = "SELECT id FROM asistencia WHERE usuario_id = ? AND DATE(fecha_hora) = CURDATE()";
                $check_stmt = $conexion->prepare($check_sql); 
                $check_stmt->execute([$uid]);

                if ($check_stmt->fetch()) {
                    echo "<div class='alert alert-error'>⚠️ Ya has registrado tu asistencia el día de hoy.</div>";
                } else {
                    // REGISTRO DE ASISTENCIA: Insertar nuevo registro [cite: 1080]
                    $sql = "INSERT INTO asistencia (usuario_id) VALUES (?)";
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute([$uid]);
                    echo "<div class='alert alert-success'>✅ Asistencia registrada correctamente.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-error'>Error al procesar la solicitud.</div>";
            }
        }
        ?>

        <form method="POST" style="margin-top: 2rem;">
            <button type="submit" name="marcar" class="btn-success">
                ✨ MARCAR MI ASISTENCIA DE HOY
            </button>
        </form>
        
        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #eee;">
        
        <a href="logout.php" style="color: #888;">Cerrar sesión de forma segura</a> 
    </div>
</body>
</html>