<div class="content">
    <div class="col">
        <div class="row mb-3">
            <h2>Gestión de Usuarios</h2>
        </div>
        <div class="row row-cols-2 mb-3">
            <div class="col">
                <button class="btn btn-primary mb-3" onclick="location.href='/usuarios/agregar'">Agregar</button>
            </div>
            <div class="col text-end">
                <button class="btn btn-secondary mb-3" onclick="location.href='/usuarios/exportar'">Desactivar</button>

            </div>
        </div>
        <div class="row mb-3">
            <table id="usuariosTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($usuarios != null && count($usuarios) > 0) {
                        foreach ($usuarios as $usuario) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($usuario->id) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario->nombre) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario->rol->nombre) . "</td>";
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