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
    public function editar($id, $nombre, $fecha) {
        $id = mysqli_real_escape_string($this->db, $id);
        $n = mysqli_real_escape_string($this->db, $nombre);
        $f = mysqli_real_escape_string($this->db, $fecha);
        $sql = "UPDATE citas SET nombre_vacuna = '$n', fecha = '$f' WHERE id = $id";
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
    public function obtenerEventosCombinados() {
        $eventos = [];
        $resC = mysqli_query($this->db, "SELECT fecha, estado FROM citas");
        while($r = mysqli_fetch_assoc($resC)) { $eventos[$r['fecha']] = $r['estado']; }   
        $resR = mysqli_query($this->db, "SELECT fecha_recordatorio FROM recordatorios");
        while($r = mysqli_fetch_assoc($resR)) {
            $f = $r['fecha_recordatorio'];
            if(!isset($eventos[$f])) { $eventos[$f] = 'pendiente'; }
        }
        return $eventos;
    }
    public function listarTodoUnificado() {
        $sql = "
            (SELECT id, nombre_vacuna as titulo, fecha, estado, 'cita' as tipo FROM citas)
            UNION 
            (SELECT id, titulo, fecha_recordatorio as fecha, 'pendiente' as estado, 'rec' as tipo FROM recordatorios)
            ORDER BY fecha ASC";
        return mysqli_query($this->db, $sql);
    }
}
?>