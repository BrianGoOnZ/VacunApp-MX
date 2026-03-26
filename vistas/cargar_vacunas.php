<?php
    session_start();
    // Declaracion de variables para conexion
    $name = 'localhost';
    $user = 'root';
    $pass = 'abril123'; // Tu contraseña de XAMPP
    $db = 'test';       // Tu base de datos (asegúrate que la tabla vacunas esté aquí)
    
    // Ingreso a la base de datos
    $conn = new mysqli($name, $user, $pass, $nueva_vacunas);
    
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }

    // Consulta a la tabla de vacunas
    $sql = "SELECT * FROM vacunas";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            // Se generan las filas de la tabla de vacunas
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre_vacuna']}</td>
                <td>{$row['enfermedad']}</td>
                <td>{$row['dosis']}</td>
                <td>{$row['fecha']}</td>
                <td>
                    <button class='btn btn-warning btn-xs' onclick=\"mostrarEditar('{$row['id']}','{$row['nombre_vacuna']}','{$row['enfermedad']}','{$row['dosis']}', '{$row['fecha']}')\">Editar</button>
                    <button class='btn btn-danger btn-xs' onclick=\"mostrarEliminar('{$row['id']}')\">Eliminar</button>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='text-center'>No hay vacunas registradas</td></tr>";
    } 

    $conn->close();
?>