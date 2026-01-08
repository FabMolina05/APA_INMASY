function mostrarCategoria() {
    const categoria = document.getElementById("categoria").value;
    const contenidoCategoria = document.querySelector(".contenido-categoria");

    if (categoria === "1") {
        contenidoCategoria.innerHTML = `
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="Laptop">Laptop</option>
                    <option value="Desktop">Desktop</option>
                </select>
            </div>
        `;
    } else if (categoria === "2") {
        contenidoCategoria.innerHTML = `
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>

            </div>
        `;
    } else if (categoria === "4") {
        contenidoCategoria.innerHTML = `
        <div class="mb-3">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" step="0.01" class="form-control" id="peso" name="peso">
            </div>
        
        `;    
    }else if (categoria === "5") {
        contenidoCategoria.innerHTML = `
        <div class="mb-3">
                <label for="puertos" class="form-label">Puertos</label>
                <input type="number" step="1" min="1" class="form-control" id="puertos" name="puertos" required>
            </div>
        `;
    }else if (categoria === "7") {
        contenidoCategoria.innerHTML = `
        <div class="mb-3">
                <label for="descripcion1" class="form-label">Descripción Adicional</label>
                <input type="text" class="form-control" id="descripcion1" name="descripcion1" required>
        </div>
        <div class="mb-3">
                <label for="descripcion2" class="form-label">Descripción Adicional</label>
                <input type="text" class="form-control" id="descripcion2" name="descripcion2" required>
        </div>

        `;
    }else if (categoria === "8") {
        contenidoCategoria.innerHTML = `
        <div class="mb-3">
                <label for="corriente" class="form-label">Corriente (A)</label>
                <input type="number" step="0.01" class="form-control" id="corriente" name="corriente" required>
        </div>
        <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
        </div>
         `;
        
    }
    else {
        contenidoCategoria.innerHTML = "";
    }
}

window.addEventListener('DOMContentLoaded', mostrarCategoria);

$('#persona_compra').on('change', function () {
    const seleccion = $(this).val();
    const otro = document.querySelector('.otra_persona');
    if (seleccion === 'otros') {
        otro.innerHTML = `
         <label for="otra_persona" class="form-label">Especifique otra persona</label>
                        <input type="text" class="form-control" id="otra_persona" name="otra_persona" required>
        `;
    } else {
        otro.innerHTML = '';
    }
});



$('#almacenamiento').on('change', function () {
    const seleccion = $(this).val();
    const numCatalogoDiv = document.querySelector('.num_catalogo');
    if (seleccion === 'bodega') {
        numCatalogoDiv.innerHTML = `
         <label for="num_catalogo" class="form-label">Número de Catálogo</label>
                        <input type="text" class="form-control" id="num_catalogo" name="num_catalogo" required>
        `;
    } else {
        numCatalogoDiv.innerHTML = '';
    }
});
    
