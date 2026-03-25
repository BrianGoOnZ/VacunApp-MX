<?php
include '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolectamos los datos del formulario
    $nombre = $_POST['nombre'];
    $ap_pat = $_POST['apellido_pat'];
    $ap_mat = $_POST['apellido_mat'];
    $fecha_nac = $_POST['fecha_nac'];
    $curp = $_POST['curp'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password']; // En el futuro usaremos password_hash()

    // Manejo de la foto de perfil
    $foto_nombre = "default.png";
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $ruta_destino = "../img-medios-VApp/usuarios/";
        // Creamos la carpeta si no existe
        if (!file_exists($ruta_destino)) { mkdir($ruta_destino, 0777, true); }
        
        $foto_nombre = time() . "_" . $_FILES['foto_perfil']['name'];
        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $ruta_destino . $foto_nombre);
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO usuarios (nombre, apellido_pat, apellido_mat, curp, fecha_nac, usuario, password, foto_profil) 
            VALUES ('$nombre', '$ap_pat', '$ap_mat', '$curp', '$fecha_nac', '$usuario', '$password', '$foto_nombre')";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('¡Registro exitoso! Ya puedes iniciar sesión.'); window.location.href='../vistas/login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>