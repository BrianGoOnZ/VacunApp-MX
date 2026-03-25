<?php
// Usamos tu IP local para que tus compañeras también puedan conectar
$host = "localhost"; // O tu IP 192.168.1.XX si vas a compartir
$port = "3306";      // Puerto de MySQL (normalmente 3306)
$user = "root";      // O el usuario 'equipo_vapp' que creaste
$pass = "";          // Tu contraseña de MySQL
$db   = "vacunapp";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>