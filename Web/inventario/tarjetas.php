<div class="content">
    <div class="container-fluid">
        <!-- Card principal -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Inventario</h2>
                        <p class="text-muted small mb-0">Gestiona Tarjetas Electrónicas</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" onclick="location.href='/entrada/agregarArticulo?categoria=3'">
                            <i class="bi bi-plus-circle me-1"></i> Agregar artículo
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="inventarioTable" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID CAJA</th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Disponible</th>
                                <th>activo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($articulos != null && count($articulos) > 0) {
                                foreach ($articulos as $articulo) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($articulo['id_caja']) . "</td>";
                                    echo "<td>" . htmlspecialchars($articulo['nombre']) . "</td>";
                                    echo "<td>" . htmlspecialchars($articulo['marca']) . "</td>";
                                    echo "<td>" . htmlspecialchars($articulo['modelo']) . "</td>";
                                    if ($articulo['disponibilidad'] == 1) {
                                        echo "<td><span class='badge bg-danger'>Ocupado</span></td>";
                                    } else {
                                        echo "<td><span class='badge bg-success'>Libre</span></td>";
                                    };
                                    
                                    if ($_SESSION['usuario_INMASY']['rol'] == 1) {
                                        if ($articulo['activo'] == 0) {
                                            echo "<td><span class='badge bg-danger'>Inactivo</span></td>";
                                        } else {
                                            echo "<td><span class='badge bg-success'>Activo</span></td>";
                                        };
                                    }
                                    echo "<td class='text-center'>
                                            <div class='btn-group btn-group-sm' role='group'>
                                               
                                                <button type='button' data-id=" . htmlspecialchars($articulo['ID_Articulo']) . " data-categoria='tarjetas' class='btn btn-outline-info' id='botonModal' title='Info' data-bs-toggle='modal' data-bs-target='#modalInfoArticulo'>
                                                    <i class='fa-regular fa-eye'></i>
                                                </button>
                                                
                                                <button type='button' data-id=" . htmlspecialchars($articulo['ID_Articulo']) . " data-categoria='tarjetas' class='btn btn-outline-warning' id='botonModal' title='Editar' data-bs-toggle='modal' data-bs-target='#modalEditarArticulo'>
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

    <?php include_once './Web/inventario/info.php' ?>
    <?php include_once './Web/inventario/tarjetasEditar.php' ?>

</div>