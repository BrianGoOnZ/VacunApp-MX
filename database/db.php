<?php
$host = "localhost"; 
$port = "3306";      
$user = "root";    
$pass = "";       
$db   = "vacunapp";
$conexion = mysqli_connect($host, $user, $pass, $db);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>