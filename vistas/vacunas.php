<?php
session_start();
$conn = new mysqli('localhost', 'root', 'abril123', 'test');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VacunApp MX - Mis Vacunas</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; margin: 0; }
        
        /* NAVBAR SUPERIOR AZUL */
        .navbar-vacunapp {
            background-color: #000291;
            color: white;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .navbar-vacunapp .logo { font-size: 24px; font-weight: bold; }
        .navbar-vacunapp .menu a { color: white; margin: 0 15px; text-decoration: none; font-weight: 500; }
        .navbar-vacunapp .user-icon { font-size: 28px; border: 2px solid white; border-radius: 50%; padding: 5px; }

        /* CONTENEDOR DE LA PANTALLA */
        .main-content {
            display: flex;
            padding: 40px;
            gap: 40px;
            justify-content: center;
        }

        /* COLUMNA IZQUIERDA: BOTONES AZULES */
        .side-menu { width: 220px; }
        .btn-vapp {
            background-color: #007bff;
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-weight: bold;
            text-align: left;
            font-size: 15px;
            box-shadow: 0 4px 0 #0056b3; /* Efecto 3D de tu imagen */
            transition: 0.2s;
        }
        .btn-vapp:active { transform: translateY(3px); box-shadow: 0 1px 0 #0056b3; }

        /* COLUMNA DERECHA: TABLA DE COLORES */
        .table-container { flex-grow: 1; max-width: 900px; background: white; border-radius: 8px; overflow: hidden; }
        .v-table { width: 100%; border-collapse: collapse; }
        .v-table th {
            background-color: #7297c1; /* Azul acero del prototipo */
            color: #333;
            padding: 15px;
            text-align: center;
            border: 1px solid #666;
            font-size: 11px;
            text-transform: uppercase;
        }
        .v-table td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
            height: 50px;
            background-color: #fff;
        }
        /* La primera columna */
        .col-vacuna { background-color: #94b8d7 !important; font-weight: bold; width: 150px; }

        /* MODAL PERSONALIZADO */
        .v-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 15px;
            border: 3px solid #000291;
            z-index: 2000;
            width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

<div class="navbar-vacunapp">
    <div class="logo">VacunApp MX</div>
    <div class="menu">
        <a href="home.php">Inicio</a>
        <a href="vacunas.php">Vacunas</a>
        <a href="calendario.php">Calendario</a>
        <a href="centros.php">Escanear</a>
    </div>
    <div class="user-icon"><i class="glyphicon glyphicon-user"></i></div>
</div>

<div class="main-content">
    <!-- BOTONES LATERALES -->
    <div class="side-menu">
        <button class="btn-vapp" onclick="abrirModal('modalVacuna')">
            + Añadir vacuna
        </button>
        <button class="btn-vapp" onclick="abrirModal('modalCita')">
            + Recordatorio
        </button>
    </div>

    <!-- TABLA DE VACUNAS -->
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
            <tbody id="vacunasTableBody">
                <!-- Se llena con AJAX -->
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL PARA RECORDATORIO (AQUÍ ESTÁ LA UNIÓN) -->
<div id="modalCita" class="v-modal">
    <h3 style="color:#000291">Nuevo Recordatorio</h3>
    <form action="../php/guardar_cita.php" method="POST">
        <label>¿Para quién es?</label>
        <select name="id_usuario" class="form-control" required>
            <?php
            $res = $conn->query("SELECT id_usuario, username FROM usuarios");
            while($u = $res->fetch_assoc()){
                echo "<option value='{$u['id_usuario']}'>{$u['username']}</option>";
            }
            ?>
        </select><br>

        <label>¿Qué vacuna toca?</label>
        <select name="id_vacuna" class="form-control" required>
            <?php
            $resV = $conn->query("SELECT id, nombre_vacuna FROM vacunas");
            while($v = $resV->fetch_assoc()){
                echo "<option value='{$v['id']}'>{$v['nombre_vacuna']}</option>";
            }
            ?>
        </select><br>

        <label>Fecha programada:</label>
        <input type="date" name="fecha_cita" class="form-control" required><br>

        <button type="submit" class="btn btn-primary btn-block">Crear Cita</button>
        <button type="button" onclick="cerrarModal('modalCita')" class="btn btn-link btn-block">Cancelar</button>
    </form>
</div>

<!-- MODAL PARA AÑADIR VACUNA (CATÁLOGO) -->
<div id="modalVacuna" class="v-modal">
    <h3 style="color:#000291">Añadir al Catálogo</h3>
    <form action="../php/guardar_vacuna.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre de Vacuna" class="form-control" required><br>
        <input type="text" name="enfermedad" placeholder="Enfermedad" class="form-control"><br>
        <input type="text" name="dosis" placeholder="Dosis" class="form-control"><br>
        <input type="date" name="fecha" class="form-control"><br>
        <button type="submit" class="btn btn-success btn-block">Guardar Vacuna</button>
        <button type="button" onclick="cerrarModal('modalVacuna')" class="btn btn-link btn-block">Cerrar</button>
    </form>
</div>

<script>
    function cargarTabla() {
        $.ajax({
            url: '../php/cargar_vacunas.php',
            type: 'GET',
            success: function(data) {
                $('#vacunasTableBody').html(data);
            }
        });
    }

    $(document).ready(function() {
        cargarTabla();
    });

    function abrirModal(id) { document.getElementById(id).style.display = 'block'; }
    function cerrarModal(id) { document.getElementById(id).style.display = 'none'; }
</script>

</body>
</html>
