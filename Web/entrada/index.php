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
                                    echo "<td>" . (isset($entrada['factura'])?htmlspecialchars($entrada['factura']):"N/A") . "</td>";
                                    echo "<td>" . (isset($entrada['proveedor'])?htmlspecialchars($entrada['proveedor']):"N/A") . "</td>";
                                    echo "<td>" . date_format($entrada['fecha'], "d/m/Y") . "</td>";
                                    echo "<td>" . htmlspecialchars($entrada['almacenamiento']). "</td>";
                                    echo "<td>" . htmlspecialchars($entrada['encargado']) . "</td>";
                                    echo "<td>" . htmlspecialchars($entrada['nombre_articulo']) . "</td>";
                                    echo "<td class='text-center'>
                                            <div class='btn-group btn-group-sm' role='group'>
                                               
                                                <button type='button' data-id=" . htmlspecialchars($entrada['id']) . " data-categoria='reles' class='btn btn-outline-info' id='botonModal' title='Info' data-bs-toggle='modal' data-bs-target='#modalInfoEntrada'>
                                                    <i class='fa-regular fa-eye'></i>
                                                </button>
                                                
                                                <button type='button' data-id=" . htmlspecialchars($entrada['id']) . " data-categoria='reles' class='btn btn-outline-warning' id='botonModal' title='Editar' data-bs-toggle='modal' data-bs-target='#modalEditarEntrada'>
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

    <?php include_once './Web/entrada/info.php' ?>
    

</div>