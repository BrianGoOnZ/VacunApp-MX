<?php
session_start();    // Accedemos a la sesión actual
session_unset();    // Limpiamos todas las variables de sesión
session_destroy();  // Destruimos la sesión por completo

// Redirigimos al index que está una carpeta atrás
header("Location: ../index.php"); 
exit();
?>