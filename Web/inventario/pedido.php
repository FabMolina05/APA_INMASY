<div class="modal fade" id="modalPedirArticulo" tabindex="-1" aria-labelledby="Pedir" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Pedir Artículo</h2>
                </div>
                <form method="POST" action="/inventario/pedirArticulo">
                    <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha requerida del articulo</label>
                            <input type="date" class="form-control date" id="fecha" name="fecha">
                        </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea type="text" class="form-control" id="direccion" name="direccion"></textarea>
                    </div>
                   
                    
                    <?php echo '<input type="hidden" id="nombre_cliente" name="nombre_cliente" value="'.htmlspecialchars($_SESSION['usuario_INMASY']['nombre_completo']).'">'; ?>
                    <input type="hidden" id="ID" name="id_articulo" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Pedir</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>