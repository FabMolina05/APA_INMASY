<div class="modal fade" id="modalRehacerPedido" tabindex="-1" aria-labelledby="Editar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Editar Pedido</h2>
                </div>
                <form method="POST" action="/inventario/pedirArticulo" id="rehacer-pedido">
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha requerida del articulo</label>
                        <input type="date" class="form-control date" id="fecha" name="fecha">
                    </div>
                    <div id="contenido-pedido">

                    </div>


                    <?php echo '<input type="hidden" id="nombre_cliente" name="nombre_cliente" value="' . htmlspecialchars($_SESSION['usuario_INMASY']['nombre_completo']) . '">'; ?>
                    <input type="hidden" id="ID" name="id_articulo" value="">
                    <input type="hidden" id="cantidadActual" name="cantidadActual" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>