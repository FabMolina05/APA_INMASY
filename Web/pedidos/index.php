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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidosUsuario as $pedido): ?>
                        <tr>
                            <?php
                            if ($pedido['estado'] == "PENDIENTE") {
                                echo "<td><span class='badge bg-warning'>PENDIENTE</span></td>";
                                echo "<td><span class='badge bg-warning'>SIN REVISAR</span></td>";
                            } elseif ($pedido['estado'] == "ACEPTADO") {
                                echo "<td><span class='badge bg-success'>ACEPTADO</span></td>";
                                echo "<td>" . $pedido['encargado'] . "</td>";
                            } elseif ($pedido['estado'] == "DEVUELTO") {
                                echo "<td><span class='badge bg-secondary'>DEVUELTO</span></td>";
                                echo "<td>" . $pedido['encargado'] . "</td>";
                            } else {
                                echo "<td><span class='badge bg-danger'>DENEGADO</span></td>";
                                echo "<td>" . $pedido['encargado'] . "</td>";
                            };


                            ?>

                            <td><?= htmlspecialchars($pedido['nombre_articulo']) ?></td>
                            <td><?= htmlspecialchars($pedido['serial']) ?></td>
                            <td><?= htmlspecialchars($pedido['modelo']) ?></td>
                            <td><?php echo date_format($pedido['fecha'], "d/m/Y"); ?></td>
                            <td><?php echo (isset($pedido['orden'])) ? htmlspecialchars($pedido['orden']) : "<span class='badge bg-danger'>N/A</span>" ?></td>

                            <td >
                                <div class='btn-group btn-group-sm' role='group'>
                                    <?php
                                    if ($pedido['estado'] == "PENDIENTE") {
                                        echo "
                                               
                                                <button type='button' data-id=" . htmlspecialchars($pedido['id']) . " class='btn btn-outline-warning' id='botonModal' title='Editar' data-bs-toggle='modal' data-bs-target='#modalEditarPedido'>
                                                    <i class='fa-solid fa-pen'></i>
                                                </button>
                                                
                                            
                                            ";
                                    }
                                    if ($pedido['estado'] == "ACEPTADO") {
                                        echo "
                                               
                                                <button type='button' data-id=" . htmlspecialchars($pedido['id']) . " class='btn btn-outline-warning' id='botonDevolver' title='Devolver'>
                                                   <i class='fa-solid fa-arrow-right-from-bracket'></i>
                                                </button>
                                                
                                            
                                            ";
                                    }

                                    echo "<button type='button' data-id=" . htmlspecialchars($pedido['id']) . " class='btn btn-outline-info' id='botonModal' title='Info' data-bs-toggle='modal' data-bs-target='#modalInfoPedido'>
                                            <i class='fa-regular fa-eye'></i>
                                </button>
                                             ";

                                    ?>
                                </div>
                            </td>
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
                            } elseif ($pedido['estado'] == "DEVUELTO") {
                                echo "<td><span class='badge bg-secondary'>DEVUELTO</span></td>";
                            } else {
                                echo "<td><span class='badge bg-danger'>DENEGADO</span></td>";
                            };

                                ?>
                                <td><?php echo (isset($pedido['encargado'])) ?  htmlspecialchars($pedido['encargado']) : "<span class='badge bg-warning'>SIN REVISAR</span>"; ?></td>
                                <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['nombre_articulo']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['serial']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['modelo']); ?></td>
                                <td><?php echo date_format($pedido['fecha'], "d/m/Y"); ?></td>
                                <?php
                                echo "<td class='text-center'>
                                            <div class='btn-group btn-group-sm' role='group'>
                                               
                                                <button type='button' data-id=" . htmlspecialchars($pedido['id']) . " class='btn btn-outline-info' id='botonModal' title='Info' data-bs-toggle='modal' data-bs-target='#modalInfoPedido'>
                                                    <i class='fa-regular fa-eye'></i>
                                                </button>";

                                if ($pedido['estado'] == "PENDIENTE") {
                                    echo "<button type='button' data-id=" . htmlspecialchars($pedido['id']) . "  class='btn btn-outline-success' id='botonModal' title='Aceptar' data-bs-toggle='modal' data-bs-target='#modalAceptarPedido'>
                                                    <i class='fa-solid fa-check'></i>
                                                </button>";


                                    echo "            <button type='button' data-id=" . htmlspecialchars($pedido['id']) . "  class='btn btn-outline-danger' id='botonDenegar' title='Denegar'>
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
    <?php include_once './Web/pedidos/editarPedido.php' ?>
    <?php include_once './Web/pedidos/info.php' ?>




</div>