<?php
//CONFIGURACION DE LA BASE DE DATOS CON PDO

//parametros de conexion a la base de datos
$host = "localhost";
$dbname = "asistencia_db";
$username = "root";
$password = "";

//INSTANCIA PDO(PHP Data Objects)
try {
    //data source name
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    //se crea la conexion 
    $conexion = new PDO($dsn, $username, $password);
    
    // ATTR_ERRMODE: Configura cómo PDO reporta los errores.
    // PDO::ERRMODE_EXCEPTION lanza excepciones que podemos capturar en el catch.
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // ATTR_DEFAULT_FETCH_MODE: Configura cómo se devuelven los resultados.
    // FETCH_ASSOC devuelve los datos como un array asociativo (nombre_columna => valor).
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // ATTR_EMULATE_PREPARES: Desactiva la emulación para usar sentencias preparadas reales
    // de MySQL, lo que aumenta la seguridad contra Inyección SQL[cite: 1055].
    $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 

} catch (PDOException $e) {
    // Si ocurre un error, se captura la excepción y se muestra un mensaje amigable
    die("Lo sentimos, ha ocurrido un problema con la conexión al sistema.");
}
?>
 

