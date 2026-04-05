<?php
class Cita {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    // 1. CREAR CITA (Corregido con id_usuario)
    public function crear($id_usuario, $nombre, $fecha, $es_rec) {
        $n = mysqli_real_escape_string($this->db, $nombre);
        $f = mysqli_real_escape_string($this->db, $fecha);
        $sql = "INSERT INTO citas (id_usuario, nombre_vacuna, fecha, es_recordatorio, estado) 
                VALUES ('$id_usuario', '$n', '$f', '$es_rec', 'pendiente')";
        return mysqli_query($this->db, $sql);
    }

    // 2. OBTENER EVENTOS (La que te marcaba el error)
    public function obtenerEventosCombinadosPorUsuario($id_usuario) {
        $eventos = [];
        // Filtramos citas por usuario
        $resC = mysqli_query($this->db, "SELECT fecha, estado FROM citas WHERE id_usuario = '$id_usuario'");
        while($r = mysqli_fetch_assoc($resC)) { 
            $eventos[$r['fecha']] = $r['estado']; 
        }   
        
        // Filtramos recordatorios por usuario
        $resR = mysqli_query($this->db, "SELECT fecha_recordatorio FROM recordatorios WHERE id_usuario = '$id_usuario'");
        while($r = mysqli_fetch_assoc($resR)) {
            $f = $r['fecha_recordatorio'];
            if(!isset($eventos[$f])) { $eventos[$f] = 'pendiente'; }
        }
        return $eventos;
    }

    // 3. LISTAR UNIFICADO (La de la lista lateral)
    public function listarTodoUnificadoPorUsuario($id_usuario) {
        $sql = "
            (SELECT id, nombre_vacuna as titulo, fecha, estado, 'cita' as tipo FROM citas WHERE id_usuario = '$id_usuario')
            UNION 
            (SELECT id, titulo, fecha_recordatorio as fecha, 'pendiente' as estado, 'rec' as tipo FROM recordatorios WHERE id_usuario = '$id_usuario')
            ORDER BY fecha ASC";
        return mysqli_query($this->db, $sql);
    }

    // 4. MÉTODOS DE GESTIÓN (Editar, Eliminar, Estado)
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

    public function listarNotificacionesActivas($id_usuario) {
        $id = mysqli_real_escape_string($this->db, $id_usuario);
        
        // Usamos UNION para juntar las dos tablas en una sola lista
        $sql = "(SELECT id, nombre_vacuna as titulo, fecha, 'cita' as tipo 
                FROM citas 
                WHERE id_usuario = '$id' AND aviso_leido = 0)
                UNION
                (SELECT id, titulo, fecha_recordatorio as fecha, 'recordatorio' as tipo 
                FROM recordatorios 
                WHERE id_usuario = '$id' AND aviso_leido = 0)
                ORDER BY fecha ASC";
                
        return mysqli_query($this->db, $sql);
    }
}
?>