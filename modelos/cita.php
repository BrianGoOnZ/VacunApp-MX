<?php
class Cita {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function crear($nombre, $fecha, $es_recordatorio) {
        $n = mysqli_real_escape_string($this->db, $nombre);
        $f = mysqli_real_escape_string($this->db, $fecha);
        $t = $es_recordatorio ? 1 : 0;
        $sql = "INSERT INTO citas (nombre_vacuna, fecha, es_recordatorio, estado) VALUES ('$n', '$f', '$t', 'pendiente')";
        return mysqli_query($this->db, $sql);
    }

    public function eliminar($id) {
        $id = mysqli_real_escape_string($this->db, $id);
        return mysqli_query($this->db, "DELETE FROM citas WHERE id = $id");
    }

    public function actualizarEstado($id, $estado) {
        $id = mysqli_real_escape_string($this->db, $id);
        $e = mysqli_real_escape_string($this->db, $estado);
        return mysqli_query($this->db, "UPDATE citas SET estado = '$e' WHERE id = $id");
    }

    public function listar() {
        return mysqli_query($this->db, "SELECT * FROM citas ORDER BY fecha ASC");
    }

    public function obtenerEventos() {
        $res = mysqli_query($this->db, "SELECT fecha, estado FROM citas");
        $eventos = [];
        while($r = mysqli_fetch_assoc($res)) { $eventos[$r['fecha']] = $r['estado']; }
        return $eventos;
    }
}