<?php
session_start();
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', 'abril123', 'test');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VacunApp MX</title>
    
    <!-- Forzamos la carga de Bootstrap desde internet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
    
    <style>
        /* Estilos incrustados directamente para que no fallen */
        body { 
            background-color: #f0f2f5 !important; 
            font-family: 'Segoe UI', Arial, sans-serif !important; 
            margin: 0;
        }

        /* BARRA SUPERIOR AZUL */
        .header-azul {
            background-color: #000291;
            color: white;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-azul a { color: white; text-decoration: none; margin-left: 20px; font-weight: bold; }

        /* CONTENEDOR PRINCIPAL */
        .contenedor-flex {
            display: flex;
            padding: 50px;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
        }

        /* BOTONES LATERALES */
        .col-botones { width: 250px; }

        .btn-azul-vapp {
            background-color: #007bff;
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 12px;
            font-weight: bold;
            text-align: left;
            box-shadow: 0 5px 0 #0056b3; /* El relieve de tu diseño */
            font-size: 16px;
        }

        /* TABLA ESTILO PROTOTIPO */
        .col-tabla { flex-grow: 1; max-width: 900px; }

        .tabla-vacunapp {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .tabla-vacunapp th {
            background-color: #7297c1; /* Azul acero */
            color: #333;
            padding: 15px;
            border: 1px solid #444;
            text-align: center;
            font-size: 12px;
            text-transform: uppercase;
        }

        .tabla-vacunapp td {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
        }

        .celda-azul { 
            background-color: #94b8d7 !important; 
            font-weight: bold; 
            width: 180px; 
        }

        /* MODALES */
        .modal-emergente {
            display: none;
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border: 4px solid #000291;
            border-radius: 20px;
            z-index: 1000;
            width: 400px;
        }
    </style>
</head>
<body>

<div class="header-azul">
    <div style="font-size: 26px; font-weight: bold;">VacunApp MX</div>
    <div>
        <a href="#">Inicio</a>
        <a href="#">Vacunas</a>
        <a href="#">Calendario</a>
        <i class="glyphicon glyphicon-user" style="font-size: 25px; margin-left: 20px;"></i>
    </div>
</div>

<div class="contenedor-flex">
    <!-- LADO IZQUIERDO -->
    <div class="col-botones">
        <button class="btn-azul-vapp" onclick="abrir('m1')">+ Añadir vacuna</button>
        <button class="btn-azul-vapp" onclick="abrir('m2')">+ Recordatorio</button>
    </div>

    <!-- LADO DERECHO -->
    <div class="col-tabla">
        <h2 style="text-align: center; margin-bottom: 30px; color: #444;">