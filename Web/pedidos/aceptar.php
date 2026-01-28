<div class="modal fade" id="modalAceptarPedido" tabindex="-1" aria-labelledby="Editar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Aceptar Pedido</h2>
                </div>
                <form method="POST" action="/pedidos/aceptar" id="aceptarPedido">
                    
                    <div class="mb-3 mt-3 my-2">
                        <label for="num_orden" class="form-label">Número de orden</label>
                        <input type="text" class="form-control" id="num_orden" name="num_orden" required>
                    </div>
                   

                    <input type="hidden" id="ID" name="id" value="">
                    <?php echo '<input type="hidden" id="encargado" name="encargado" value="'.htmlspecialchars($_SESSION['usuario_INMASY']['ID_Usuario']).'">'; ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Aceptar Pedido</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>