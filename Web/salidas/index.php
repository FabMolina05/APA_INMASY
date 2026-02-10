<div class="content">
    <div class="container-fluid">
        <!-- Card principal -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Salidas</h2>
                        <p class="text-muted small mb-0">Gestiona los artículos desechos</p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="salidasTable" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="truncate-cell">Motivo</th>
                                <th>Salida</th>
                                <th>Nombre</th>
                                <th>Serial</th>
                                <th>Categoria</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($salidas != null && count($salidas) > 0) {
                                foreach ($salidas as $salida) {

                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($salida['motivo']) . "</td>";
                                    echo "<td>" . date_format($salida['salida'], "d/m/Y") . "</td>";
                                    echo "<td>" . htmlspecialchars($salida['nombre']) . "</td>";
                                    echo "<td>" . htmlspecialchars(empty($salida['serial']) ? "N/A" : $salida['serial']) . "</td>";
                                    echo "<td>" . htmlspecialchars($salida['categoria']) . "</td>";

                                    echo "<td class='text-center'>
                                            <div class='btn-group btn-group-sm' role='group'>
                                               
                                                <button type='button' data-id=" . htmlspecialchars($salida['id']) . " data-categoria='otros' class='btn btn-outline-info' id='botonModal' title='Informacion' data-bs-toggle='modal' data-bs-target='#modalInfoSalida' >
                                                    <i class='fa-regular fa-eye'></i>
                                                </button>
                                      
                
                                            </div>
                                          </td>
                                         </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include_once './Web/salidas/info.php' ?>

</div>

