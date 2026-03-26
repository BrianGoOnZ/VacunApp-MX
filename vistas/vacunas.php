<?php
// 1. CONEXIÓN A LA BASE DE DATOS
$host = "localhost";
$user = "root";
$pass = "abril123"; // Tu contraseña de XAMPP
$db   = "test";

$conn = new mysqli($host, $user, $pass, $db);

// Verificamos si hay error de conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VacunApp MX - Mis Vacunas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <style>
        /* CONFIGURACIÓN DE COLORES DE TU DISEÑO */
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; margin: 0; }

        /* NAVBAR AZUL OSCURO */
        .header-vapp {
            background-color: #000291; /* El azul fuerte de tu imagen */
            color: white;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-vapp a { color: white; margin: 0 15px; text-decoration: none; font-weight: 500; }

        /* CONTENEDOR DE BOTONES Y TABLA */
        .main-wrapper {
            display: flex;
            padding: 40px;
            gap: 40px;
            justify-content: center;
        }

        /* BOTONES CON RELIEVE */
        .side-menu { width: 220px; }
        .btn-vapp {
            background-color: #007bff;
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 12px;
            font-weight: bold;
            text-align: left;
            box-shadow: 0 5px 0 #0056b3; /* Sombra para el efecto 3D */
            transition: 0.1s;
        }
        .btn-vapp:active { transform: translateY(3px); box-shadow: 0 2px 0 #0056b3; }

        /* TABLA TIPO CARTILLA */
        .table-container { flex-grow: 1; max-width: 900px; background: white; border-radius: 5px; overflow: hidden; }
        .v-table { width: 100%; border-collapse: collapse; border: 1px solid #666; }
        
        .v-table th {
            background-color: #7297c1; /* Azul acero del encabezado */
            color: #333;
            padding: 15px;
            text-align: center;
            border: 1px solid #666;
            font-size: 11px;
            text-transform: uppercase;
        }

        .v-table td { border: 1px solid #ccc; padding: 12px; text-align: center; height: 55px; }

        /* COLUMNA LATERAL AZUL CLARO */
        .col-vacuna { 
            background-color: #94b8d7 !important; 
            font-weight: bold; 
            width: 160px; 
            border-right: 2px solid #666 !important;
        }

        /* MODAL PERSONALIZADO */
        .v-modal {
            display: none;
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border: 3px solid #000291;
            border-radius: 15px;
            z-index: 2000;
            width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

<!-- BARRA SUPERIOR -->
<div class="header-vapp">
    <div style="font-size: 24px; font-weight: bold;">VacunApp MX</div>
    <div>
        <a href="#">Inicio</a>
        <a href="#">Vacunas</a>
        <a href="#">Calendario</a>
        <a href="#">Escanear</a>
    </div>
    <div style="font-size: 28px;"><i class="glyphicon glyphicon-user"></i></div>
</div>

<h2 style="text-align: center; margin-top: 30px; color: #444;">MIS VACUNAS</h2>

<div class="main-wrapper">
    <!-- BOTONES IZQUIERDA -->
    <div class="side-menu">
        <button class="btn-vapp" onclick="abrir('m1')">+ Añadir vacuna</button>
        <button class="btn-vapp" onclick="abrir('m2')">+ Recordatorio</button>
    </div>

    <!-- TABLA DERECHA -->
    <div class="table-container">
        <table class="v-table">
            <thead>
                <tr>
                    <th class="col-vacuna">Vacuna</th>
                    <th>Enfermedad que previene</th>
                    <th>Dosis</th>
                    <th>Edad y Frecuencia</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // CONSULTA PARA TRAER LOS DATOS
                $sql = "SELECT * FROM vacunas";
                $res = $conn->query($sql);

                if ($res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='col-vacuna'>" . $row['nombre_vacuna'] . "</td>";
                        echo "<td>" . $row['enfermedad'] . "</td>";
                        echo "<td>" . $row['dosis'] . "</td>";
                        echo "<td>" . $row['frecuencia'] . "</td>";
                        echo "<td>" . $row['fecha'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Filas vacías para que no se vea pelón si no hay datos
                    for($i=0; $i<5; $i++) {
                        echo "<tr><td class='col-vacuna'></td><td></td><td></td><td></td><td></td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- FORMULARIO PARA AÑADIR (MODAL) -->
<div id="m1" class="v-modal">
    <h3 style="color:#000291; margin-top:0;">Nueva Vacuna</h3>
    <form action="../php/guardar_vacuna.php" method="POST">
        <input type="text" name="nombre" class="form-control" placeholder="Nombre de la Vacuna" required><br>
        <input type="text" name="enfermedad" class="form-control" placeholder="Enfermedad"><br>
        <input type="text" name="dosis" class="form-control" placeholder="Dosis"><br>
        <input type="date" name="fecha" class="form-control"><br>
        <button type="submit" class="btn btn-primary btn-block">Guardar en Base de Datos</button>
        <button type="button" class="btn btn-link btn-block" onclick="cerrar('m1')">Cancelar</button>
    </form>
</div>

<script>
    function abrir(id) { document.getElementById(id).style.display = 'block'; }
    function cerrar(id) { document.getElementById(id).style.display = 'none'; }
</script>

</body>
</html>