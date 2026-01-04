<div class="modal fade" id="modalEditarArticulo" tabindex="-1" aria-labelledby="Editar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Editar Artículo</h2>
                </div>
                <form method="POST" action="/inventario/actualizar">
                    <div class="mb-3">
                        <label for="id_caja" class="form-label">ID Caja</label>
                        <input type="text" class="form-control" id="CAJA" name="CAJA" disabled required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="Nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="Marca" name="marca" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="Modelo" name="modelo" required>
                    </div>
                    <div class="mb-3">
                        <label for="serial" class="form-label">Serial</label>
                        <input type="text" class="form-control" id="Serial" name="serial" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="Estado" name="estado" required>
                            <option value="NUEVO">NUEVO</option>
                            <option value="USADO">USADO</option>
                            <option value="REPARADO">REPARADO</option>
                            <option value="ROTO">ROTO</option>
                        </select>
                    <div class="mb-3">
                        <label for="costo_unitario" class="form-label">Costo Unitario</label>
                        <input type="number" step="0.01" class="form-control" id="Costo" name="costo_unitario" required>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="Cantidad" name="cantidad" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="Direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" required>
                    </div>
                    <div class="mb-3">
                        <label for="tecnico" class="form-label">Técnico</label>
                        <input type="text" class="form-control" id="Tecnico" name="tecnico" required disabled>
                    </div>
                    <div class="mb-3">
                        <label for="disponibilidad" class="form-label">Disponibilidad</label>
                        <select class="form-select" id="Disponibilidad" name="disponibilidad" required disabled>
                            <option value="1">Ocupado</option>
                            <option value="0">Libre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="activo" class="form-label">Activo</label>
                        <select class="form-select" id="Activo" name="activo" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>


                    <input type="hidden" id="ID" name="ID_Articulo" value="">
                    <input type="hidden" id="Categoria" name="categoria" value="reles">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>