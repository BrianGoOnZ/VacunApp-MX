<div class="modal fade" id="modalEditarVacuna" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Modificar Vacuna Registrada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>          
            <form action="../controladores/vacunas_controller.php" method="POST">
                <div class="modal-body">                 
                    <input type="hidden" name="id" id="edit_vac_id">
                    <input type="hidden" name="accion" value="actualizar"> <div class="mb-3">
                        <label class="form-label">Nombre de la Vacuna</label>
                        <input type="text" name="vacuna" id="edit_vac_nombre" class="form-control" required>
                    </div>              
                    <div class="mb-3">
                        <label class="form-label">Enfermedad que previene</label>
                        <input type="text" name="enfermedad" id="edit_vac_enfermedad" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dosis (ej: 10ml)</label>
                            <input type="text" name="dosis" id="edit_vac_dosis" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Frecuencia</label>
                            <input type="text" name="frecuencia" id="edit_vac_frecuencia" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Aplicación</label>
                        <input type="date" name="fecha" id="edit_vac_fecha" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #000291; border-radius: 8px;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>