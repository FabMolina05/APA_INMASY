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
                        <input type="number" step="0.01"  class="form-control" id="CAJA" name="CAJA"  required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="Nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="Marca" name="marca" >
                    </div>
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="Modelo" name="modelo" >
                    </div>
                    <div class="mb-3">
                        <label for="serial" class="form-label">Serial</label>
                        <input type="text" class="form-control" id="Serial" name="serial" >
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea type="text" class="form-control" id="Direccion" name="direccion" ></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="aidi" class="form-label">Codigo AIDI</label>
                        <input type="text" class="form-control" id="aidi" name="aidi">
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="Estado" name="estado" required>
                            <option value="NUEVO">NUEVO</option>
                            <option value="USADO">USADO</option>
                            <option value="REPARADO">REPARADO</option>
                            <option value="ROTO">ROTO</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="costo_unitario" class="form-label">Costo Unitario</label>
                        <input type="number" step="0.01" class="form-control" id="Costo" name="costo_unitario" >
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="Cantidad" name="cantidad" required>
                    </div>
                 
                    <div class="mb-3">
                        <label for="tension" class="form-label">Tension Nominal (kV)</label>
                        <input type="text" class="form-control" id="tension_nominal" name="tension_nominal" required>
                    </div>
                    <div class="mb-3">
                        <label for="corrienteNominal" class="form-label">Corriente Nominal (A)</label>
                        <input type="text" class="form-control" id="corriente_nominal" name="corriente_nominal" required>
                    </div>
                    <div class="mb-3">
                        <label for="corte" class="form-label">Corte Bajo Carga</label>
                        <select class="form-control" id="corte" name="corte" required>
                            <option value='1'>SI</option>
                            <option value='0'>NO</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="operacion" class="form-label">Tipo Operación</label>
                        <select class="form-control" id="operacion" name="operacion" required>
                            <option value='MANUAL'>MANUAL</option>
                            <option value='MOTORIZADO'>MOTORIZADO</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="instalacion" class="form-label">Instalación</label>
                        <select class="form-control" id="instalacion" name="instalacion" required>
                            <option value='POSTE'>POSTE</option>
                            <option value='LINEA AEREA'>LINEA AÉREA</option>
                        </select>
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
                    <input type="hidden" id="Categoria" name="categoria" value="seccionador">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>