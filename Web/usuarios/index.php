

<div class="content">
    <div class="container-fluid">
        <!-- Card principal -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Usuarios</h2>
                        <p class="text-muted small mb-0">Gestiona los usuarios del sistema</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" onclick="location.href='/usuarios/agregar'">
                            <i class="bi bi-plus-circle me-1"></i> Agregar Usuario
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table id="usuariosTable" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="35%">Nombre</th>
                                <th width="27%">Rol</th>
                                <th width="22%">Estado</th>
                                <th width="16%" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($usuarios != null && count($usuarios) > 0) {
                                foreach ($usuarios as $usuario) {
                                    echo "<tr>";
                                    echo "<td><strong>" . htmlspecialchars($usuario['nombre_completo']) . "</strong></td>";
                                    echo "<td><span class='badge bg-info text-dark'>" . htmlspecialchars($usuario['rol']) . "</span></td>";
                                    if($usuario['estado'] == 0){
                                        echo "<td><span class='badge bg-danger'>Inactivo</span></td>";
                                    } else {
                                    echo "<td><span class='badge bg-success'>Activo</span></td>";
                                    };
                                    echo "<td class='text-center'>
                                            <div class='btn-group btn-group-sm' role='group'>
                                               
                                                <button type='button' data-id=". htmlspecialchars($usuario['ID_Usuario'])." class='btn btn-outline-warning' id='botonModal' title='Editar' data-bs-toggle='modal' data-bs-target='#modalEditarUsuario'>
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

<?php include_once './Web/usuarios/editar.php' ?>

</div>

