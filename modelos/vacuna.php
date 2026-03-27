<?php
class Vacuna {
    private $db;
    public function __construct($conexion) {
        $this->db = $conexion;
    }
    public function crear($nombre, $enfermedad, $dosis, $frecuencia, $fecha) {
        $sql = "INSERT INTO vacunas (nombre_vacuna, enfermedad, dosis, frecuencia, fecha) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("sssss", $nombre, $enfermedad, $dosis, $frecuencia, $fecha);
            $res = $stmt->execute();
            $stmt->close();
            return $res;
        }
        return false;
    }
    public function listar() {
        $sql = "SELECT * FROM vacunas ORDER BY fecha DESC";
        return mysqli_query($this->db, $sql);
    }
    public function actualizar($id, $nombre, $enfermedad, $dosis, $frecuencia, $fecha) {
        $sql = "UPDATE vacunas SET nombre_vacuna = ?, enfermedad = ?, dosis = ?, frecuencia = ?, fecha = ? WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("sssssi", $nombre, $enfermedad, $dosis, $frecuencia, $fecha, $id);
            $res = $stmt->execute();
            $stmt->close();
            return $res;
        }
        return false;
    }
    public function eliminar($id) {
        $sql = "DELETE FROM vacunas WHERE id = ?";
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