<?php
class Recordatorio {
    private $db;
    public function __construct($conexion) {
        $this->db = $conexion;
    }
    public function crear($id_usuario, $titulo, $descripcion, $fecha) {
        // Escapamos los datos para evitar errores por caracteres especiales
        $t = mysqli_real_escape_string($this->db, $titulo);
        $d = mysqli_real_escape_string($this->db, $descripcion);
        $f = mysqli_real_escape_string($this->db, $fecha);

        // IMPORTANTE: Verifica que la columna en tu BD se llame id_usuario
        $sql = "INSERT INTO recordatorios (id_usuario, titulo, descripcion, fecha_recordatorio) 
                VALUES ('$id_usuario', '$t', '$d', '$f')";
                
        return mysqli_query($this->db, $sql);
    }

    public function listarPorUsuario($id_usuario) {
        // Usamos 'AS' para que aunque en la BD se llame diferente, PHP vea 'titulo'
        // REVISA: Si en tu tabla es 'nombre', cámbialo abajo
        $sql = "SELECT id, titulo, descripcion, fecha_recordatorio 
                FROM recordatorios 
                WHERE id_usuario = ? 
                ORDER BY fecha_recordatorio ASC";
                
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            return $stmt->get_result();
        }
        return false;
    }

    public function eliminar($id) {
        $sql = "DELETE FROM recordatorios WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id);
            $res = $stmt->execute();
            $stmt->close();
            return $res;
        }
        return false;
    }
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM recordatorios WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_assoc();
        }
        return null;
    }
    public function actualizar($id, $titulo, $descripcion, $fecha) {
        $sql = "UPDATE recordatorios SET titulo = ?, descripcion = ?, fecha_recordatorio = ? WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("sssi", $titulo, $descripcion, $fecha, $id);
            $res = $stmt->execute();
            $stmt->close();
            return $res;
        }
        return false;
    }
}
?>