<?php
class Vacuna {
    private $db;
    public function __construct($conexion) {
        $this->db = $conexion;
    }
    public function crear($id_usuario, $nombre, $enfermedad, $dosis, $frecuencia, $fecha) {
        $sql = "INSERT INTO vacunas (id_usuario, nombre_vacuna, enfermedad, dosis, frecuencia, fecha) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $this->db->prepare($sql)) {
            // "i" es para Integer (el ID), las 5 "s" son para los Strings
            $stmt->bind_param("isssss", $id_usuario, $nombre, $enfermedad, $dosis, $frecuencia, $fecha);
            $res = $stmt->execute();
            $stmt->close();
            return $res;
        }
        return false;
    }

    // En modelos/Vacuna.php
    public function listarPorUsuario($id_usuario) {
    // Usamos prepare para seguridad
        $sql = "SELECT * FROM vacunas WHERE id_usuario = ? ORDER BY fecha DESC";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            return $stmt->get_result(); // Esto devuelve el set de resultados para el while
            }
        return false;
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