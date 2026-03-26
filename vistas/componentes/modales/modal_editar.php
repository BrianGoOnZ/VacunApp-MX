<div class="modal fade modal-vapp" id="modalEditarVacuna" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ACTUALIZAR DATOS DE LA VACUNA</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="../controladores/vacunas_controller.php" method="POST">
                    <input type="hidden" name="accion" value="actualizar">
                    <input type="hidden" name="id" id="editar-id">
                    
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Vacuna</label>
                        <input type="text" name="vacuna" id="editar-nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Enfermedad</label>
                        <input type="text" name="enfermedad" id="editar-enfermedad" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Dosis</label>
                            <input type="text" name="dosis" id="editar-dosis" class="form-control">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Frecuencia</label>
                            <input type="text" name="frecuencia" id="editar-frecuencia" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Aplicación</label>
                        <input type="date" name="fecha" id="editar-fecha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn-iniciarsesion w-100 mt-3">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>