
<div class="main-content">
    <div class="content">
        <div class="col">
            <div class="row">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Gestión de Usuarios</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Suponiendo que $usuarios es un array de objetos Usuario pasado desde el controlador
                                foreach ($usuarios as $usuario) {
                                    echo "<tr>";
                                    echo "<td>{$usuario->id}</td>";
                                    echo "<td>{$usuario->nombre}</td>";
                                    echo "<td>{$usuario->rol->nombre}</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include __DIR__ . '/../components/Footer.php'; ?>

