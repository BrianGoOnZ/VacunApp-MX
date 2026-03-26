<?php
class Vacuna {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    // CREATE: Guardar nueva vacuna
    public function crear($nombre, $enfermedad, $dosis, $frecuencia, $fecha) {
        $n = mysqli_real_escape_string($this->db, $nombre);
        $e = mysqli_real_escape_string($this->db, $enfermedad);
        $d = mysqli_real_escape_string($this->db, $dosis);
        $fr = mysqli_real_escape_string($this->db, $frecuencia);
        $fe = mysqli_real_escape_string($this->db, $fecha);

        $sql = "INSERT INTO vacunas (nombre_vacuna, enfermedad, dosis, frecuencia, fecha) 
                VALUES ('$n', '$e', '$d', '$fr', '$fe')";
        return mysqli_query($this->db, $sql);
    }

    // READ (Todos): Obtener todas las vacunas
    public function listar() {
        $sql = "SELECT * FROM vacunas ORDER BY fecha DESC";
        return mysqli_query($this->db, $sql);
    }

    // READ (Uno): Obtener datos de UNA vacuna específica por ID
    public function obtenerPorId($id) {
        $id_limpio = mysqli_real_escape_string($this->db, $id);
        $sql = "SELECT * FROM vacunas WHERE id = '$id_limpio' LIMIT 1";
        $resultado = mysqli_query($this->db, $sql);
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado);
        }
        return null; // Si no encuentra nada
    }

    // UPDATE: Actualizar datos de una vacuna existente
    public function actualizar($id, $nombre, $enfermedad, $dosis, $frecuencia, $fecha) {
        $id_limpio = mysqli_real_escape_string($this->db, $id);
        $n = mysqli_real_escape_string($this->db, $nombre);
        $e = mysqli_real_escape_string($this->db, $enfermedad);
        $d = mysqli_real_escape_string($this->db, $dosis);
        $fr = mysqli_real_escape_string($this->db, $frecuencia);
        $fe = mysqli_real_escape_string($this->db, $fecha);

        $sql = "UPDATE vacunas SET 
                nombre_vacuna = '$n', 
                enfermedad = '$e', 
                dosis = '$d', 
                frecuencia = '$fr', 
                fecha = '$fe' 
                WHERE id = '$id_limpio'";
        
        return mysqli_query($this->db, $sql);
    }

    // DELETE: Eliminar una vacuna por ID
    public function eliminar($id) {
        $id_limpio = mysqli_real_escape_string($this->db, $id);
        $sql = "DELETE FROM vacunas WHERE id = '$id_limpio'";
        return mysqli_query($this->db, $sql);
    }
}
?>