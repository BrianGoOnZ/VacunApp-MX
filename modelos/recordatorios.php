<?php
class Recordatorio {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function listar() {
        // Verifica que tu tabla en MySQL se llame 'recordatorios'
        $sql = "SELECT * FROM recordatorios ORDER BY fecha_recordatorio ASC";
        return mysqli_query($this->db, $sql);
    }

    public function eliminar($id) {
        $id_limpio = mysqli_real_escape_string($this->db, $id);
        $sql = "DELETE FROM recordatorios WHERE id = '$id_limpio'";
        return mysqli_query($this->db, $sql);
    }
}
?>