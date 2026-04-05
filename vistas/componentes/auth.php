<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    // Si auth.php está en vistas/componentes/
    // y lo llamas desde vistas/vacunas.php
    // necesitas subir un nivel para llegar a la raíz donde está index.php
    header("Location: ../index.php?error=acceso_denegado");
    exit();
}
?>