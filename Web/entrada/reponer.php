<div class="content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Reponer stock de Artículos</h2>
                        <p class="text-muted small mb-0">Reponer stock</p>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="/entrada/agregarArticulo">
                    <h3 class="mb-3">Información de la adquisicion</h3>
                    <button
                        id="btnAdquisicion"
                        type="buttons"
                        class="btn btn-success mb-3"
                        data-bs-toggle="collapse"
                        data-bs-target="#adquisicionCollapse">
                        <i class="fa-solid fa-plus"></i>
                        Agregar Adquisición
                    </button>
                    <input type="hidden" id="adquisicionAgregada" name="adquisicionAgregada" value="false">
                    <div class="collapse" id="adquisicionCollapse">
                        <div class="mb-3">
                            <label for="proveedor" class="form-label">Proveedor</label>
                            <select class="form-select" id="proveedor" name="proveedor">
                                <option value="">Seleccione un proveedor</option>
                                <?php
                                foreach ($proveedores as $proveedor) {
                                    echo "<option value=" . htmlspecialchars($proveedor['id']) . ">" . htmlspecialchars($proveedor['nombre']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_adquisicion" class="form-label">Fecha de Entrega</label>
                            <input type="date" class="form-control date" id="fecha_adquisicion" name="fecha_adquisicion">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="fecha_entrada" name="fecha_entrada">
                                <label class="form-check-label" for="fecha_entrada">
                                    Se entrega el mismo día?
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="factura" class="form-label">Número de Factura</label>
                            <input type="text" class="form-control" id="factura" name="factura" maxlength="50">
                        </div>
                        <div class="mb-3">
                            <label for="tipo_pago" class="form-label">Tipo de Pago</label>
                            <input type="text" class="form-control" id="tipo_pago" name="tipo_pago">
                        </div>

                        <div class="mb-3">
                            <label for="numero_fondo" class="form-label">Número de Fondo</label>
                            <input type="text" class="form-control" id="numero_fondo" name="numero_fondo">
                        </div>
                        <div class="mb-3">
                            <label for="garantia" class="form-label">Garantía</label>
                            <textarea type="text" class="form-control" id="garantia" name="garantia" maxlength="100"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="persona_compra" class="form-label">Responsable de la Adquisición</label>
                            <select class="form-select" id="persona_compra" name="persona_compra" required>
                                <option disabled selected hidden>Seleccione una persona</option>
                                <option value="otros">Otros</option>
                                <?php
                                foreach ($usuarios as $usuario) {
                                    echo "<option value='" . htmlspecialchars($usuario['nombre_completo']) . "'>" . htmlspecialchars($usuario['nombre_completo']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="otra_persona">

                        </div>

                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria" onchange="cargarTabla()" required>
                            <option disabled selected hidden>Seleccione una categoria</option>

                            <?php


                            foreach ($categorias as $categoria) {
                                echo "<option value='" . htmlspecialchars($categoria['id']) . "' >" . htmlspecialchars($categoria['nombre']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="card-body my-4">
                        <div class="table-responsive">
                            <table id="reponerTable" class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>N° Articulo</th>
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Serial</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php include_once './Web/entrada/modal.php' ?>
                </form>

            </div>
        </div>
    </div>
</div>