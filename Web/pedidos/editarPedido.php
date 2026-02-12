<div class="modal fade" id="modalEditarPedido" tabindex="-1" aria-labelledby="Editar" aria-hidden="true">
    <div class="modal-dialog modal-mid">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Editar Pedido</h2>
                </div>
                <form method="POST" action="/pedidos/editarPedido">
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha requerida del articulo</label>
                        <input type="date" class="form-control date" id="fecha" name="fecha">
                    </div>
                    <div id="contenido-pedido">

                    </div>




                    <input type="hidden" id="id" name="id_pedido" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>