<div class="content">
    <div class="container-fluid">
        <!-- Card principal -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Proveedores</h2>
                        <p class="text-muted small mb-0">Gestiona los proveedores del sistema</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" onclick="location.href='/proveedores/agregar'">
                            <i class="bi bi-plus-circle me-1"></i> Agregar Proveedores
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="proveedoresTable" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>telefono</th>
                                <th>Dirección</th>
                                <th>Activo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($proveedores) && count($proveedores) > 0) {
                                foreach ($proveedores as $proveedor) {
                                    echo "<tr>";
                                    echo (isset($proveedor['nombre'])) ? "<td>" . htmlspecialchars($proveedor['nombre']) . "</td>" : "<td><span class='badge bg-danger text-white'>N/A</span></td>";
                                    echo (isset($proveedor['telefono'])) ? "<td>" . htmlspecialchars($proveedor['telefono']) . "</td>" : "<td><span class='badge bg-danger text-white'>N/A</span></td>";
                                    echo (isset($proveedor['direccion'])) ? "<td>" . htmlspecialchars($proveedor['direccion']) . "</td>" : "<td><span class='badge bg-danger text-white'>N/A</span></td>";

                                    echo ($proveedor['activo'] == 1) ?  "<td><span class='badge bg-success text-white'>Activo</span></td>" : "<td><span class='badge bg-danger text-white'>Inactivo</span></td>";

                                    echo "<td class='text-center'>
                                            <div class='btn-group btn-group-sm' role='group'>
                                                <button type='button' data-id=" . htmlspecialchars($proveedor['ID_Proveedor']) . " class='btn btn-outline-info' id='botonInfo' title='Info' data-bs-toggle='modal' data-bs-target='#modalInfoProveedor'>
                                                    <i class='fa-regular fa-eye'></i>
                                                </button>
                                                <button type='button' data-id=" . htmlspecialchars($proveedor['ID_Proveedor']) . " class='btn btn-outline-warning' id='botonModal' title='Editar' data-bs-toggle='modal' data-bs-target='#modalEditarProveedores'>
                                                    <i class='fa-solid fa-pen'></i>
                                                </button>
                                                <button type='button' data-id=" . htmlspecialchars($proveedor['ID_Proveedor']) . " class='btn btn-outline-danger btn-desactivar-proveedor'  title='Sacar'>
                                                    <i class='fa-solid fa-trash'></i>
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
    <?php include_once './Web/proveedores/info.php' ?>

    <?php include_once './Web/proveedores/editar.php' ?>


</div>