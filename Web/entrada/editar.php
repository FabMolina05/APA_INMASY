<div class="modal fade" id="modalEditarEntrante" tabindex="-1" aria-labelledby="Editar" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Editar Adquisición</h2>
                </div>
                <form method="POST" action="/entrada/actualizar">
                    <div class="mb-3">
                            <label for="fecha_adquisicion" class="form-label">Fecha de Entrega</label>
                            <input type="date" class="form-control date" id="fecha_adquisicion" name="fecha_adquisicion">
                        </div>
                    <div class="mb-3">
                            <label for="proveedor" class="form-label">Proveedor</label>
                            <select class="form-select" id="proveedor" name="proveedor">
                                <option value="">Seleccione un proveedor</option>
                                <?php
                                foreach ($proveedores as $proveedor) {
                                    echo "<option value=" . htmlspecialchars($proveedor['id']) . ">" . htmlspecialchars($proveedor['nombre']) . "</option>";
                                }
                                ?>
                            </select>
                    </div>
                   <div class="mb-3">
                            <label for="factura" class="form-label">Número de Factura</label>
                            <input type="text" class="form-control" id="factura" name="factura">
                        </div>
                        <div class="mb-3">
                            <label for="tipo_pago" class="form-label">Tipo de Pago</label>
                            <input type="text" class="form-control" id="tipo_pago" name="tipo_pago">
                        </div>

                        <div class="mb-3">
                            <label for="numero_fondo" class="form-label">Número de Fondo</label>
                            <input type="text" class="form-control" id="num_fondo" name="numero_fondo">
                        </div>
                        <div class="mb-3">
                            <label for="garantia" class="form-label">Garantía</label>
                            <textarea type="text" class="form-control" id="garantia" name="garantia"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="persona_compra" class="form-label">Responsable de la Adquisición</label>
                            <select class="form-select" id="persona_compra" name="persona_compra" required>
                                <option disabled selected hidden>Seleccione una persona</option>
                                <option value="otros">Otros</option>
                                <?php
                                foreach ($usuarios as $usuario) {
                                    echo "<option value='" . htmlspecialchars($usuario['nombre_completo']) . "'>" . htmlspecialchars($usuario['nombre_completo']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="otra_persona">

                        </div>
                        <input type="hidden" id="id_entrante" name="id_entrante" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>