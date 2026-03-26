<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "abril123", "test");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VacunApp MX - Mis Vacunas</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* ESTILOS DIRECTOS PARA QUE NO FALLEN */
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }

        /* NAVBAR AZUL OSCURO (Como tu imagen 5) */
        .vapp-navbar-main {
            background-color: #000291 !important;
            padding: 10px 20px;
        }
        .navbar-brand { font-weight: bold; color: white !important; font-size: 24px; }
        .navbar-brand span { color: #00d4ff; }
        .nav-link { color: rgba(255,255,255,0.8) !important; margin: 0 10px; }
        .nav-link.active { color: white !important; border-bottom: 2px solid white; }

        /* TITULO */
        .bienvenida {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }

        /* BOTONES AZULES CON RELIEVE */
        .btn-iniciarsesion {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-weight: bold;
            box-shadow: 0 4px 0 #0056b3;
            transition: all 0.2s;
            width: 100%;
            margin-bottom: 15px;
        }
        .btn-iniciarsesion:active {
            transform: translateY(4px);
            box-shadow: 0 0 0;
        }

        /* TABLA ESTILO CARTILLA */
        .tabla-vapp {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 2px solid #666;
        }
        .tabla-vapp th {
            background-color: #7297c1 !important; /* Azul Acero */
            color: #222;
            padding: 12px;
            border: 1px solid #666;
            text-align: center;
            font-size: 12px;
        }
        .tabla-vapp td {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            height: 50px;
        }
        /* Columna lateral azul claro */
        .col-azul-claro {
            background-color: #94b8d7 !important;
            font-weight: bold;
            width: 180px;
        }

        /* MODAL ESTILO AZUL */
        .modal-vapp {
            border: 3px solid #000291;
            border-radius: 20px;
        }
        .modal-header { background-color: #000291; color: white; }
    </style>
</head>
<body>

    <header class="vapp-navbar-main">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">VacunApp <span>MX</span></a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="#" class="nav-link">Inicio</a></li>
                        <li class="nav-item"><a href="#" class="nav-link active">Vacunas</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Calendario</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <div class="bienvenida text-center">MIS VACUNAS</div>
        
        <div class="row">
            <!-- BOTONES -->
            <div class="col-md-3">
                <button class="btn-iniciarsesion" data-bs-toggle="modal" data-bs-target="#modalAgregarVacuna">+ Añadir vacuna</button>
                <button class="btn-iniciarsesion" data-bs-toggle="modal" data-bs-target="#modalRecordatorio">+ Recordatorio</button>
            </div>

            <!-- TABLA -->
            <div class="col-md-9">
                <div class="table-responsive shadow">
                    <table class="tabla-vapp">
                        <thead>
                            <tr>
                                <th class="col-azul-claro">Vacuna</th>
                                <th>ENFERMEDAD QUE PREVIENE</th>
                                <th>DOSIS</th>
                                <th>EDAD Y FRECUENCIA</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = $conexion->query("SELECT * FROM vacunas");
                            if($res && $res->num_rows > 0){
                                while($f = $res->fetch_assoc()){
                                    echo "<tr>
                                            <td class='col-azul-claro'>{$f['nombre_vacuna']}</td>
                                            <td>{$f['enfermedad']}</td>
                                            <td>{$f['dosis']}</td>
                                            <td>{$f['frecuencia']}</td>
                                            <td>{$f['fecha']}</td>
                                          </tr>";
                                }
                            } else {
                                // Filas vacías para mantener el diseño si no hay datos
                                for($i=0; $i<6; $i++){
                                    echo "<tr><td class='col-azul-claro'></td><td></td><td></td><td></td><td></td></tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL AGREGAR (Idéntico al tuyo) -->
    <div class="modal fade" id="modalAgregarVacuna" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content modal-vapp">
                <div class="modal-header">
                    <h5 class="modal-title">NUEVA VACUNA</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="guardar_vacuna.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre de la Vacuna:</label>
                            <input type="text" name="nombre_vacuna" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enfermedad:</label>
                            <input type="text" name="enfermedad" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Dosis:</label>
                                <input type="text" name="dosis" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Fecha:</label>
                                <input type="date" name="fecha" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn-iniciarsesion">Guardar Vacuna</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>