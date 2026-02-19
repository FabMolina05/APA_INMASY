<div class="content">
    <div class="container-fluid">
        <!-- Card principal -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Inventario</h2>
                        <p class="text-muted small mb-0">Gestiona Gabinetes</p>
                    </div>
                    <?php if ($_SESSION['usuario_INMASY']['rol'] == 1): ?>
                        <div class="col-auto">
                            <button class="btn btn-primary" onclick="location.href='/entrada/agregarArticulo?categoria=6'">
                                <i class="bi bi-plus-circle me-1"></i> Agregar artículo
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="inventarioTable" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>N° Artículo</th>
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
                                    if ($articulo['activo'] != 0 || $_SESSION['usuario_INMASY']['rol'] == 1) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($articulo['num_articulo']) . "</td>";
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
                                               
                                                <button type='button' data-id=" . htmlspecialchars($articulo['ID_Articulo']) . " data-categoria='gabinetes' class='btn btn-outline-info' id='botonModal' title='Info' data-bs-toggle='modal' data-bs-target='#modalInfoArticulo'>
                                                    <i class='fa-regular fa-eye'></i>
                                                </button>";
                                        if ($_SESSION['usuario_INMASY']['rol'] == 1 && $articulo['disponibilidad'] == 0) {
                                            echo "<button type='button' data-id=" . htmlspecialchars($articulo['ID_Inventario']) . " data-categoria='baterias' class='btn btn-outline-danger btn-sacar'  title='Sacar'>
                                                    <i class='fa-solid fa-trash'></i>
                                                </button>";
                                        }
                                        if ($articulo['disponibilidad'] == 0 && $articulo['activo'] != 0) {
                                            echo "<button type='button' data-id=" . htmlspecialchars($articulo['ID_Articulo']) . " data-categoria='gabinetes' class='btn btn-outline-success' id='botonModal' title='Pedir' data-bs-toggle='modal' data-bs-target='#modalPedirArticulo'>
                                                    <i class='fa-solid fa-basket-shopping'></i>
                                                </button>";
                                        }

                                        echo "            <button type='button' data-id=" . htmlspecialchars($articulo['ID_Articulo']) . " data-categoria='gabinetes' class='btn btn-outline-warning' id='botonModal' title='Editar' data-bs-toggle='modal' data-bs-target='#modalEditarArticulo'>
                                                    <i class='fa-solid fa-pen'></i>
                                                </button>
                
                                                
                                            </div>
                                          </td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include_once './Web/inventario/pedido.php' ?>

    <?php include_once './Web/inventario/info.php' ?>
    <?php include_once './Web/inventario/gabinetesEditar.php' ?>

</div>