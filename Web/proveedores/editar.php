<div class="modal fade" id="modalEditarProveedores" tabindex="-1" aria-labelledby="Editar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Editar proveedores</h2>
                </div>
                <form method="POST" action="/proveedores/actualizar">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" >
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" >
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea type="text" class="form-control" id="direccion" name="direccion" ></textarea>
                    </div>
                    <input type="hidden" id="ID" name="ID_Proveedor" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>