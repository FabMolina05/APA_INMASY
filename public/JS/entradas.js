function mostrarCategoria() {
    const categoria = document.getElementById("categoria").value;
    const contenidoCategoria = document.querySelector(".contenido-categoria");

    if (categoria === "1") {
        contenidoCategoria.innerHTML = `
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipoElectronica" name="tipoElectronica" required>
            </div>
        `;
    } else if (categoria === "2") {
        contenidoCategoria.innerHTML = `
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Rele</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="Circuito de Distribución">Circuito de Distribución</option>
                    <option value="Transformador">Transformador</option>
                    <option value="Trifásico">Trifásico</option>
                </select>
            </div>
             <div class="mb-3">
                <label for="vdc" class="form-label">Rango de VDC</label>
                <input type="text" class="form-control" id="vdc" name="vdc" required>
            </div>
             <div class="mb-3">
                <label for="vac" class="form-label">Rango de VAC</label>
                <input type="text" class="form-control" id="vac" name="vac" >
            </div>
            <div class="mb-3">
                <label for="aidi" class="form-label">Codigo AIDI</label>
                <input type="text" class="form-control" id="aidi" name="aidi" >
            </div>
        `;
    } else if (categoria === "4") {
        contenidoCategoria.innerHTML = `
        <div class="mb-3">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" step="0.01" class="form-control" id="peso" name="peso">
            </div>
        
        `;
    } else if (categoria === "5") {
        contenidoCategoria.innerHTML = `
        <div class="mb-3">
                <label for="puertos" class="form-label">Puertos</label>
                <input type="number" step="1" min="1" class="form-control" id="puertos" name="puertos" required>
            </div>
        `;
    } else if (categoria === "7") {
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
    } else if (categoria === "8") {
        contenidoCategoria.innerHTML = `
        <div class="mb-3">
                <label for="corriente" class="form-label">Corriente (A)</label>
                <input type="number" step="0.01" class="form-control" id="corriente" name="corriente" required>
        </div>
        <div class="mb-3">
                <label for="numero" class="form-label">Número de batería</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
        </div>
         `;

    } else if (categoria === "9") {
        contenidoCategoria.innerHTML = `
        <div class="mb-3">
                <label for="tension" class="form-label">Tension Nominal (kV)</label>
                <input type="text"  class="form-control" id="tension" name="tension" required>
        </div>
        <div class="mb-3">
                <label for="corrienteNominal" class="form-label">Corriente Nominal (A)</label>
                <input type="text" class="form-control" id="corrienteNominal" name="corrienteNominal" required>
        </div>
        <div class="mb-3">
                <label for="control" class="form-label">Tipo de control</label>
                <select class="form-control" id="control" name="control" required>
                    <option value='LOCAL'>LOCAL</option>
                    <option value='REMOTO'>REMOTO</option>
                </select>
        </div>
        <div class="mb-3">
                <label for="protocolo" class="form-label">Protocolo de comunicación</label>
                <select class="form-control" id="protocolo" name="protocolo" required>
                    <option value='DNP3'>DNP3</option>
                    <option value='IEC101/104'>IEC101/104</option>
                    <option value='IEC61850'>IEC 61850</option>
                    <option value='otro'>OTRO</option>
                </select>
        </div>
        <div class='mb-3'>
            <div class="otro_protocolo">
            </div>
        </div>
        <div class="mb-3">
                <label for="montaje" class="form-label">Montaje</label>
                <select class="form-control" id="montaje" name="montaje" required>
                    <option value='POSTE'>POSTE</option>
                    <option value='SUBESTACIÓN'>SUBESTACIÓN</option>
                </select>
        </div>
        <div class="mb-3">
                <label for="aidi" class="form-label">Codigo AIDI</label>
                <input type="text" class="form-control" id="aidi" name="aidi">
            </div>
         `;

    } else if (categoria === "10") {
        contenidoCategoria.innerHTML = `
       <div class="mb-3">
                <label for="tension" class="form-label">Tension Nominal (kV)</label>
                <input type="text"  class="form-control" id="tension" name="tension" required>
        </div>
        <div class="mb-3">
                <label for="corrienteNominal" class="form-label">Corriente Nominal (A)</label>
                <input type="text" class="form-control" id="corrienteNominal" name="corrienteNominal" required>
        </div>
        <div class="mb-3">
                <label for="operacion" class="form-label">Tipo Operación</label>
                <select class="form-control" id="operacion" name="operacion" required>
                    <option value='MANUAL'>MANUAL</option>
                    <option value='MOTORIZADO'>MOTORIZADO</option>
                </select>
        </div>
        <div class="mb-3">
                <label for="corte" class="form-label">Capacidad de corte bajo carga</label>
                <select class="form-control" id="corte" name="corte" required>
                    <option value='1'>SI</option>
                    <option value='0'>NO</option>
                </select>
        </div>
        <div class="mb-3">
                <label for="instalacion" class="form-label">Tipo instalación</label>
                <select class="form-control" id="instalacion" name="instalacion" required>
                    <option value='LINEA AEREA'>LINEA AÉREA</option>
                    <option value='POSTE'>POSTE</option>
                </select>
        </div>
        <div class="mb-3">
                <label for="aidi" class="form-label">Codigo AIDI</label>
                <input type="text" class="form-control" id="aidi" name="aidi" >
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


$(document).on('change', '#protocolo', function () {
    const seleccion = $(this).val();
    const otro = document.querySelector('.otro_protocolo');
    if (seleccion === 'otro') {
        otro.innerHTML = `
            <label for= "otro_protocolo" class= "form-label"> Especifique el protocolo</label>
                <input type="text" class="form-control" id="otro_protocolo" name="otro_protocolo" >
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

$('#btnAdquisicion').on('click', function () {

    var btn = $(this);
    var expanded = btn.attr('aria-expanded')
    var agregado = $('#adquisicionAgregada')

    if (expanded == "true") {
        btn.html('<i class="fa-solid fa-minus"></i> Quitar Adquisición')
        btn.removeClass("btn-success");
        btn.addClass('btn-danger');
        agregado.val("true")

        $('#adquisicionCollapse')
            .find('input[type="text"],input[type="number"], select, textarea')
            .prop('required', true)





    } else {
        btn.html('<i class="fa-solid fa-plus"></i> Agregar Adquisición')
        btn.removeClass('btn-danger');
        btn.addClass('btn-success');
        agregado.val("false")
        $('#adquisicionCollapse').on('hidden.bs.collapse', function () {

            // Resetear inputs, selects y textareas
            $(this).find('input, select, textarea').val('').prop('required', false);

            // Resetear selects con opción disabled/hidden
            $(this).find('select').prop('selectedIndex', 0).prop('required', false);

            // Si hay checkboxes o radios (por si acaso)
            $(this).find('input[type="checkbox"], input[type="radio"]').prop('checked', false).prop('required', false);

            // Limpiar contenido dinámico
            $(this).find('.otra_persona').empty().prop('required', false);

        });
    }
});


$(document).ready(function () {
    $('#formEditarEntrante').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            url: '/entrada/actualizar',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success === false) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.data || 'Ocurrió un error al procesar la solicitud.'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Se acepto el pedido correctamente'
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseText || 'Ocurrió un error al procesar la solicitud.'
                }).then(() => {
                    location.reload();
                });
            }
        });
    });
});





