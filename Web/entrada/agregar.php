<div class="content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0">Entrada de Artículos</h2>
                        <p class="text-muted small mb-0">Agregar Artículo</p>
                    </div>

                </div>
            </div>
            <div class="card-body">

                <form method="POST" action="/entrada/agregarArticulo">
                    <h3 class="mb-3">Información de la adquisicion</h3>
                    <div class="mb-3">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <select class="form-select" id="proveedor" name="proveedor" required>
                            <option value="">Seleccione un proveedor</option>
                            <?php
                            foreach ($proveedores as $proveedor) {
                                echo "<option value=" . htmlspecialchars($proveedor['id']) . ">" . htmlspecialchars($proveedor['nombre']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_adquisicion" class="form-label">Fecha de Adquisición</label>
                        <input type="date" class="form-control date" id="fecha_adquisicion" name="fecha_adquisicion" required>
                    </div>
                    <div class="mb-3">
                        <label for="factura" class="form-label">Número de Factura</label>
                        <input type="text" class="form-control" id="factura" name="factura" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_pago" class="form-label">Tipo de Pago</label>
                        <input type="text" class="form-control" id="tipo_pago" name="tipo_pago" required>
                    </div>

                    <div class="mb-3">
                        <label for="numero_fondo" class="form-label">Número de Fondo</label>
                        <input type="text" class="form-control" id="numero_fondo" name="numero_fondo" required>
                    </div>
                    <div class="mb-3">
                        <label for="garantia" class="form-label">Garantía</label>
                        <textarea type="text" class="form-control" id="garantia" name="garantia" required></textarea>
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
                    <h3 class="mb-3 mt-4">Información del artículo</h3>
                    <div class="mb-3">
                        <label for="caja" class="form-label">Número de caja</label>
                        <input type="text" class="form-control" id="caja" name="caja" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required>
                    </div>
                    <div class="mb-3">
                        <label for="serial" class="form-label">Serial</label>
                        <input type="text" class="form-control" id="serial" name="serial" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea type="text" class="form-control" id="direccion" name="direccion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="NUEVO">NUEVO</option>
                            <option value="USADO">USADO</option>
                            <option value="REPARADO">REPARADO</option>
                            <option value="ROTO">ROTO</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="mb-3">
                        <label for="costo_unitario" class="form-label">Costo Unitario</label>
                        <input type="number" step="0.01" class="form-control" id="costo_unitario" name="costo_unitario" required>
                    </div>

                    <h3 class="mb-3 mt-4">Categoría</h3>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria" onchange="mostrarCategoria()">
                            <?php if($categoriaSeleccionada !== null): ?>
                            <option >Seleccione una categoria</option>
                            <?php else: ?>
                            <option selected>Seleccione una categoria</option>
                            <?php
                            endif;

                            foreach ($categorias as $categoria) {
                                $selected = ($categoriaSeleccionada == $categoria['id']) ? "selected" : "";
                                echo "<option value='" . htmlspecialchars($categoria['id']) . "' $selected>" . htmlspecialchars($categoria['nombre']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="contenido-categoria">

                    </div>

                    <h3 class="mb-3 mt-4">Almacenamiento</h3>
                    <div class="mb-3">
                        <label for="almacenamiento" class="form-label">Almacenamiento</label>
                        <select class="form-select" id="almacenamiento" name="almacenamiento" required>
                            <option value="inventario">Inventario</option>
                            <option value="bodega">Bodega</option>
                        </select>
                    </div>
                    <div class="num_catalogo">
                    </div>
                    <button type="submit" class="btn btn-primary mb-3 mt-3">Agregar Artículo</button>
                </form>
            </div>
        </div>
    </div>
</div>