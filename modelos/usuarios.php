<?php
class Usuario {
    private $conexion;
    private $tabla = "usuarios"; // Asegúrate que tu tabla se llame así
    public function __construct($db) {
        $this->conexion = $db;
    }
    public function existeCorreo($email) {
        // Preparamos la consulta (Seguridad ante todo)
        $query = "SELECT id_usuario FROM " . $this->tabla . " WHERE correo = ?"; 
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) {
            return true;
        }
        return false;
    }
    public function obtenerPerfil($usuario) {
        $query = "SELECT * FROM " . $this->tabla . " WHERE usuario = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();      
        return $resultado->fetch_assoc(); // Retorna el array con nombre, foto, curp, etc.
    }
    public function actualizarDatos($id, $nombre, $usuario, $ap, $am, $curp, $fnac) {
        $query = "UPDATE " . $this->tabla . " SET nombre=?, usuario=?, apellido_pat=?, apellido_mat=?, curp=?, fecha_nac=? WHERE id_usuario=?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("ssssssi", $nombre, $usuario, $ap, $am, $curp, $fnac, $id);
        return $stmt->execute();
    }
}
?>