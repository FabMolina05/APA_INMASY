<div class="content">
    <div class="container-fluid">
        <!-- Card principal -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Entrada de Artículos</h2>
                        <p class="text-muted small mb-0">Gestiona los entrantes</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" onclick="location.href='/entrada/agregarArticulo'">
                            <i class="bi bi-plus-circle me-1"></i> Agregar artículo
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="entrantesTable" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>N° Factura</th>
                                <th>Proveedor</th>
                                <th>Fecha Entrega</th>
                                <th>Fecha Entrada</th>

                                <th>Almacenamiento</th>
                                <th>Encargado</th>
                                <th>Nombre Articulo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($entradas != null && count($entradas) > 0) {
                                foreach ($entradas as $entrada) {
                                    echo "<tr>";
                                    echo "<td>" . (isset($entrada['factura']) ? htmlspecialchars($entrada['factura']) : "N/A") . "</td>";
                                    echo "<td>" . (isset($entrada['proveedor']) ? htmlspecialchars($entrada['proveedor']) : "N/A") . "</td>";
                                    if (isset($entrada['fecha_entrega'])) {
                                        echo "<td>" . date_format($entrada['fecha_entrega'], "d/m/Y") . "</td>";
                                    } else {
                                        echo "<td>" . "N/A" . "</td>";
                                    };
                                    if (isset($entrada['fecha_entrada'])) {
                                        echo "<td>" . date_format($entrada['fecha_entrada'], "d/m/Y") . "</td>";
                                    } else {
                                        echo "<td>" . "<span class='badge bg-danger'>No entregado</span>" . "</td>";
                                    };


                                    echo "<td>" . htmlspecialchars($entrada['almacenamiento']) . "</td>";
                                    echo "<td>" . htmlspecialchars($entrada['encargado']) . "</td>";
                                    echo "<td>" . htmlspecialchars($entrada['nombre_articulo']) . "</td>";
                                    echo "<td class='text-center'>
                                            <div class='btn-group btn-group-sm' role='group'>
                                               
                                                <button type='button' data-id=" . htmlspecialchars($entrada['id']) . "  class='btn btn-outline-info' id='botonModal' title='Informacion' data-bs-toggle='modal' data-bs-target='#modalInfoEntrada'>
                                                    <i class='fa-regular fa-eye'></i>
                                                </button>";
                                    if (!isset($entrada['fecha_entrada'])) {
                                        echo "<button type='button' data-id=" . htmlspecialchars($entrada['id']) . "  class='btn btn-outline-success' id='botonModal' title='Poner fecha' data-bs-toggle='modal' data-bs-target='#modalFechaEntrada'>
                                                    <i class='fa-regular fa-calendar'></i>
                                                </button>";
                                    };

                                    echo "
                                                <button type='button' data-id=" . htmlspecialchars($entrada['id']) . " class='btn btn-outline-warning' id='botonModal' title='Editar' data-bs-toggle='modal' data-bs-target='#modalEditarEntrante'>
                                                    <i class='fa-solid fa-pen'></i>
                                                </button>
                
                                                
                                            </div>
                                          </td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFechaEntrada" tabindex="-1" aria-labelledby="agregar fecha" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <div class="modal-title text-white">
                        <h2>Agregar fecha</h2>
                    </div>
                </div>
                <div class="modal-body">
                    <p>Desea agregar la fecha actual a la fecha de entreda del articulo?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnAgregar" value="" onclick="agregarFecha()">Agregar </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include_once './Web/entrada/info.php' ?>
        <?php include_once './Web/entrada/editar.php' ?>



</div>