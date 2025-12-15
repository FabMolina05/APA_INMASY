<div class="content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col mx-3">
                        <h2 class="mb-0">Agregar Usuario</h2>
                        <p class="text-muted small mb-0">Agregar usuarios del sistema</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-secondary" onclick="location.href='/usuarios/index'">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>

                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="/usuarios/guardar">
                    <div class="mb-3">
                        <label for="usuarioPADDE" class="form-label">Usuario PADDE</label>
                        <select class="form-select" id="usuarioPADDE" name="usuarioPADDE" onchange="actualizarNombre()" required>
                            <option value="" disabled selected>Seleccione un usuario</option>
                            <?php
                            if ($usuario != null && count($usuario) > 0) {
                                foreach ($usuario as $usuario_pd) {
                                    echo "<option value='" . htmlspecialchars($usuario_pd['num_empleado']) . "'>" . htmlspecialchars($usuario_pd['nombre_completo']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="" disabled selected>Seleccione un rol</option>
                            <?php
                            if ($roles != null && count($roles) > 0) {
                                foreach ($roles as $rol) {
                                    echo "<option value='" . htmlspecialchars($rol['ID_Rol']) . "'>" . htmlspecialchars($rol['nombre']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" id="nombreUsuarioPADDE" name="nombreUsuarioPADDE">
                    <button type="submit" class="btn btn-primary mb-3 mt-3">Guardar Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/public/JS/agregarUsuario.js"></script>