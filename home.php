<?php 
require_once('php/seguridad.php'); 
require_once('config/conexion.php'); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Asistencia</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 0.9rem; }
        th, td { padding: 10px; border-bottom: 1px solid #eee; text-align: center; }
        th { background-color: #f8f9fc; color: #444; }
        .scroll-area { max-height: 200px; overflow-y: auto; margin-top: 10px; border: 1px solid #eee; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="card" style="max-width: 600px;">
        <h2>¡Bienvenido!</h2>
        <h3 style="color: var(--primary-color);"><?php echo htmlspecialchars($_SESSION['nombre_completo']); ?></h3>
        
        <?php
        $uid = $_SESSION['user_id']; 

        // LÓGICA PARA MARCAR ASISTENCIA
        if (isset($_POST['marcar'])) {
            try {
                $check_sql = "SELECT id FROM asistencia WHERE usuario_id = ? AND DATE(fecha_hora) = CURDATE()";
                $check_stmt = $conexion->prepare($check_sql); 
                $check_stmt->execute([$uid]);

                if ($check_stmt->fetch()) {
                    echo "<div class='alert alert-error'>⚠️ Ya registraste tu asistencia hoy.</div>";
                } else {
                    $sql = "INSERT INTO asistencia (usuario_id) VALUES (?)";
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute([$uid]);
                    echo "<div class='alert alert-success'>✅ Asistencia marcada con éxito.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-error'>Error al registrar asistencia.</div>";
            }
        }

        // LÓGICA PARA RECUPERAR EL HISTORIAL
        try {
            $historial_sql = "SELECT fecha_hora FROM asistencia WHERE usuario_id = ? ORDER BY fecha_hora DESC";
            $historial_stmt = $conexion->prepare($historial_sql);
            $historial_stmt->execute([$uid]);
            $asistencias = $historial_stmt->fetchAll(); // Recuperamos todos los registros
        } catch (PDOException $e) {
            $asistencias = [];
        }
        ?>

        <form method="POST" style="margin-top: 1rem;">
            <button type="submit" name="marcar" class="btn-success">
                ✨ MARCAR MI ASISTENCIA DE HOY
            </button>
        </form>

        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #eee;">

        <h4>Mi Historial de Asistencias</h4>
        <div class="scroll-area">
            <?php if (count($asistencias) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora de Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($asistencias as $fila): ?>
                            <?php 
                                // Formateamos la fecha para que se vea mejor
                                $fecha = date("d/m/Y", strtotime($fila['fecha_hora']));
                                $hora = date("H:i:s", strtotime($fila['fecha_hora']));
                            ?>
                            <tr>
                                <td><?php echo $fecha; ?></td>
                                <td><?php echo $hora; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color: #888; padding: 20px;">Aún no tienes asistencias registradas.</p>
            <?php endif; ?>
        </div>
        
        <br>
        <a href="logout.php" style="color: #999; font-size: 0.85rem;">Cerrar Sesión</a> 
    </div>
</body>
</html>
