<?php
require_once '../database/db.php';
require_once '../modelos/usuarios.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $usuarioModel = new Usuario($conexion);
    if ($usuarioModel->existeCorreo($email)) {
        header("Location: ../vistas/recuperar.php?status=enviado");
    } else {
        header("Location: ../vistas/recuperar.php?status=no_encontrado");
    }
    exit();
}