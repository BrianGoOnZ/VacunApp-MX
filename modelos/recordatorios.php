<?php
class Recordatorio {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function crear($titulo, $descripcion, $fecha) {
        $sql = "INSERT INTO recordatorios (titulo, descripcion, fecha_recordatorio) VALUES (?, ?, ?)";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("sss", $titulo, $descripcion, $fecha);
            $res = $stmt->execute();
            $stmt->close();
            return $res;
        }
        return false;
    }

    public function listar() {
        $sql = "SELECT * FROM recordatorios ORDER BY fecha_recordatorio ASC";
        return mysqli_query($this->db, $sql);
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
}
?>