<?php
//Cerrar la sesion del usuario

// Reanudamos la sesión actual para poder manipularla.
// Sin session_start(), el servidor no sabría qué sesión queremos cerrar.
session_start(); 

// Limpiar todas las variables de sesión.
// Aunque session_destroy() borra el archivo en el servidor, 
// esta línea asegura que la matriz $_SESSION quede vacía en el script actual.
$_SESSION = array(); 

// Esta función elimina la información del usuario del almacenamiento del servidor.
session_destroy(); 

/**
 * Una vez cerrada la sesión, enviamos al usuario de vuelta al formulario de login.
 * Se usa una ruta relativa para volver a la raíz del proyecto.
 */
header("Location: login.php"); 

// finalizamos el script por seguridad.
exit();
?>