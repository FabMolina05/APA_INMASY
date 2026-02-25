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
                        <h5 class="mt-4">Correos Electrónicos</h5>
                        <div id="correos-container">
                            <div class="correo-item border p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Nombre del Contacto</label>
                                        <input type="text" class="form-control" name="correos[0][nombre]">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" name="correos[0][correo]" required>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mb-3" id="agregar-correo">
                            <i class="fas fa-plus"></i> Agregar otro correo
                        </button>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono de la Empresa</label>
                            <input type="text" class="form-control" id="telefono" name="telefono">
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea type="text" class="form-control" id="direccion" name="direccion"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL de la página</label>
                            <input type="text" class="form-control" id="url" name="url">
                        </div>

                        <button type="submit" class="btn btn-primary mb-3 mt-3">Guardar Proveedor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/JS/agregarUsuario.js"></script>