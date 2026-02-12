<div class="content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col mx-3">
                        <h2 class="mb-0">Agregar Proveedor</h2>
                        <p class="text-muted small mb-0">Agregar proveedores del sistema</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-secondary" onclick="location.href='/proveedores/index'">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>

                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="/proveedores/agregarProveedor">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Proveedor</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea type="text" class="form-control" id="direccion" name="direccion"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mb-3 mt-3">Guardar Proveedor</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/public/JS/agregarUsuario.js"></script>
