<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD_VacunApp</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Un poco de estilo para que los modales no se vean tan simples */
        .modal-custom { position: fixed; top: 20%; left: 30%; background: white; border: 2px solid #000291; padding: 20px; z-index: 1000; width: 400px; box-shadow: 0px 0px 10px rgba(0,0,0,0.5); }
    </style>
</head>
<body>
<div class="container">
    <h1>Administrador de Vacunas - VacunApp MX</h1>
    <button class="btn btn-primary" onclick="mostrarModal('modalAgregarVacuna')">Agregar nueva vacuna</button>
    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vacuna</th>
                <th>Enfermedad</th>
                <th>Dosis</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="vacunasTableBody">
            <!-- Aquí se cargarán las vacunas vía AJAX -->
        </tbody>
    </table>
</div>

<!-- MODAL EDITAR -->
<div id="modalEditar" class="modal-custom" style="display:none;">
    <h3>Editar Vacuna</h3>
    ID: <span id="idEditar"></span><br><br>
    Vacuna: <input type="text" id="nombreEditar" class="form-control"><br>
    Enfermedad: <input type="text" id="enfermedadEditar" class="form-control"><br>
    Dosis: <input type="text" id="dosisEditar" class="form-control"><br>
    Fecha: <input type="date" id="fechaEditar" class="form-control"><br>

    <button class="btn btn-success" onclick="guardarEdicion()">Guardar Cambios</button>
    <button class="btn btn-danger" onclick="cerrarModal('modalEditar')">Cancelar</button>
</div>

<!-- MODAL ELIMINAR -->
<div id="modalEliminar" class="modal-custom" style="display:none;">
    <h3>Confirmar eliminación</h3>
    <p>¿Estás seguro de que deseas eliminar esta vacuna? ID: <span id="idEliminar"></span></p>
    <button class="btn btn-danger" onclick="eliminarVacuna()">Eliminar</button>
    <button class="btn btn-default" onclick="cerrarModal('modalEliminar')">Cancelar</button>
</div>

<!-- MODAL AGREGAR -->
<div id="modalAgregarVacuna" class="modal-custom" style="display:none;">
    <h3>Agregar Vacuna</h3>
    <form action="guardar_vacuna.php" method="post">
        <input type="text" name="nombre" placeholder="Nombre Vacuna" class="form-control" required><br>
        <input type="text" name="enfermedad" placeholder="Enfermedad" class="form-control"><br>
        <input type="text" name="dosis" placeholder="Dosis (Ej. 1ra)" class="form-control"><br>
        <input type="date" name="fecha" class="form-control"><br>
        <button type="submit" class="btn btn-primary">Añadir</button>
        <button type="button" class="btn btn-default" onclick="cerrarModal('modalAgregarVacuna')">Cerrar</button>
    </form>
</div>

<script>
function actualizarLista(){
    $.ajax({
        url: 'cargar_vacunas.php',
        type: 'GET',
        success: function(response){
            $('#vacunasTableBody').html(response);
        }
    });
}

$(document).ready(function(){
    actualizarLista();
});

function mostrarModal(id){ document.getElementById(id).style.display = 'block'; }
function cerrarModal(id){ document.getElementById(id).style.display = 'none'; }

function mostrarEditar(id, nombre, enfermedad, dosis, fecha){
    document.getElementById('idEditar').innerText = id;
    document.getElementById('nombreEditar').value = nombre;
    document.getElementById('enfermedadEditar').value = enfermedad;
    document.getElementById('dosisEditar').value = dosis;
    document.getElementById('fechaEditar').value = fecha;
    mostrarModal('modalEditar');
}

function mostrarEliminar(id){
    document.getElementById('idEliminar').innerText = id;
    mostrarModal('modalEliminar');
}

function guardarEdicion(){
    var id = document.getElementById('idEditar').innerText;
    var nombre = document.getElementById('nombreEditar').value;
    var enfermedad = document.getElementById('enfermedadEditar').value;
    var dosis = document.getElementById('dosisEditar').value;
    var fecha = document.getElementById('fechaEditar').value;

    $.ajax({
        type: 'POST',
        url: 'editar_vacuna.php',
        data: {id, nombre, enfermedad, dosis, fecha},
        success: function(response){
            alert(response);
            cerrarModal('modalEditar');
            actualizarLista();
        }
    });
}

function eliminarVacuna(){
    var id = document.getElementById('idEliminar').innerText;
    $.ajax({
        type: 'POST',
        url: 'eliminar_vacuna.php',
        data: {id_vacuna: id},
        success: function(response){
            alert(response);
            cerrarModal('modalEliminar');
            actualizarLista();
        }
    });
}
</script>
</body>
</html>
