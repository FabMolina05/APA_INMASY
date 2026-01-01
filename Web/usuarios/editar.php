<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="Editar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Editar Usuario</h2>
                </div>
                <form method="POST" action="/usuarios/actualizar">
                    <div class="mb-3 mt-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="" disabled selected>Seleccione un rol</option>
                            <?php
                            if ($roles != null && count($roles) > 0) {
                                foreach ($roles as $rol) {
                                    echo "<option value='" . htmlspecialchars($rol['ID_Rol']) . "'>" . htmlspecialchars($rol['nombre']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        <input type="hidden" id="ID_Usuario" name="ID_Usuario" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>