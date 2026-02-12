<div class="content">
    <div class="container-fluid">
        <!-- Card principal -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Bitacora</h2>
                        <p class="text-muted small mb-0">Gestiona los movimientos realizados en el sistema</p>
                    </div>
                    
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="bitacoraTable" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Usuario</th>
                                <th> Categoria</th>
                                <th>Descripcion</th>
                                <th>Fecha</th>
                                <th>Accion</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($bitacoras != null && count($bitacoras) > 0) {
                                foreach ($bitacoras as $bitacora) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($bitacora['usuario']) . "</td>";
                                    echo "<td>" . htmlspecialchars($bitacora['categoria']) . "</td>";
                                    echo "<td>" . htmlspecialchars($bitacora['descripcion']) . "</td>";
                                    echo "<td>" . date_format($bitacora['fecha'], "d/m/Y H:i:s ") . "</td>";
                                    echo "<td>" . htmlspecialchars($bitacora['accion']) . "</td>";
                                    if ($bitacora['estado'] == "SUCCESS") {
                                        echo "<td><span class='badge bg-success'>SUCCESS</span></td>";
                                    } else if ($bitacora['estado'] == "ERROR") {
                                        echo "<td><span class='badge bg-danger'>ERROR</span></td>";
                                    }
                                  
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


</div>