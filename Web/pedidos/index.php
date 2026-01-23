<div class="content">
    <div class="container-fluid">
        <div class="tabs">
            <div class="tab active" onclick="cambiarTab('misPedidos',this)">Mis Pedidos</div>
            <?php if ($_SESSION['usuario_INMASY']['rol'] == 1): ?>
                <div class="tab" onclick="cambiarTab('listaPedidos',this)">Lista de Pedidos</div>
            <?php endif; ?>
        </div>

        <div id="misPedidos" class=" table-responsive tab-content active">
            <table id="misPedidosTable" class="table table-hover align-middle ">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Encargado</th>
                        <th>Artículo</th>
                        <th>Serial</th>
                        <th>Modelo</th>
                        <th>Fecha</th>
                        <th>N° Orden</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidosUsuario as $pedido): ?>
                        <tr>
                            <?php
                                if ($pedido['estado'] == "PENDIENTE") {
                                    echo "<td><span class='badge bg-warning'>PENDIENTE</span></td>";
                                } elseif ($pedido['estado'] == "ACEPTADO") {
                                    echo "<td><span class='badge bg-success'>ACEPTADO</span></td>";
                                } else {
                                    echo "<td><span class='badge bg-danger'>DENEGADO</span></td>";
                                };

                                ?>
                            <td><?= htmlspecialchars($pedido['encargado']) ?></td>
                            <td><?= htmlspecialchars($pedido['nombre_articulo']) ?></td>
                            <td><?= htmlspecialchars($pedido['serial']) ?></td>
                            <td><?= htmlspecialchars($pedido['modelo']) ?></td>
                            <td><?php echo date_format($pedido['fecha'], "d/m/Y"); ?></td>
                            <td><?= htmlspecialchars($pedido['orden']) ?></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <!-- Contenido Tab: Lista de Pedidos -->
        <?php if ($_SESSION['usuario_INMASY']['rol'] == 1): ?>
            <div id="listaPedidos" class="table-responsive tab-content">
                <table id="listaPedidosTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Encargado</th>
                            <th>Cliente</th>
                            <th>Artículo</th>
                            <th>Serial</th>
                            <th>Modelo</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidosGenerales as $pedido): ?>
                            <tr>
                                <?php
                                if ($pedido['estado'] == "PENDIENTE") {
                                    echo "<td><span class='badge bg-warning'>PENDIENTE</span></td>";
                                } elseif ($pedido['estado'] == "ACEPTADO") {
                                    echo "<td><span class='badge bg-success'>ACEPTADO</span></td>";
                                } else {
                                    echo "<td><span class='badge bg-danger'>DENEGADO</span></td>";
                                };

                                ?>
                                <td><?php echo (isset($pedido['encargado'])) ?  htmlspecialchars($pedido['encargado']) : "SIN REVISAR"; ?></td>
                                <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['nombre_articulo']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['serial']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['modelo']); ?></td>
                                <td><?php echo date_format($pedido['fecha'], "d/m/Y"); ?></td>
                                <?php
                                echo "<td class='text-center'>
                                            <div class='btn-group btn-group-sm' role='group'>
                                               
                                                <button type='button' data-id=" . htmlspecialchars($pedido['id']) . " data-categoria='reconector' class='btn btn-outline-info' id='botonModal' title='Info' data-bs-toggle='modal' data-bs-target='#modalInfoArticulo'>
                                                    <i class='fa-regular fa-eye'></i>
                                                </button>";

                                if ($pedido['estado'] == "PENDIENTE") {
                                    echo "<button type='button' data-id=" . htmlspecialchars($pedido['id']) . " data-categoria='reconector' class='btn btn-outline-success' id='botonModal' title='Aceptar' data-bs-toggle='modal' data-bs-target='#modalAceptarPedido'>
                                                    <i class='fa-solid fa-check'></i>
                                                </button>";


                                    echo "            <button type='button' data-id=" . htmlspecialchars($pedido['id']) . " data-categoria='reconector' class='btn btn-outline-danger' id='botonDenegar' title='Denegar'>
                                                    <i class='fa-solid fa-x'></i>
                                                </button>
                
                                                
                                            </div>
                                          </td>";
                                    echo "</tr>";
                                };
                                ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            </div>
    </div>
    <?php include_once './Web/pedidos/aceptar.php' ?>
    <?php include_once './Web/pedidos/denegar.php' ?>


</div>