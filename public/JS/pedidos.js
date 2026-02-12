function cambiarTab(tabId, element) {
    // Ocultar todos los contenidos
    $('.tab-content').removeClass('active');

    // Desactivar todos los tabs
    $('.tab').removeClass('active');

    // Activar el tab seleccionado
    $('#' + tabId).addClass('active');

    $(element).addClass('active');

}

$(document).ready(function () {
    $('#aceptarPedido').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            url: '/pedidos/aceptar', // tu endpoint
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if(response.success){
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Se acepto el pedido correctamente'
                }).then(() => {
                    location.reload();
                });
            }else{
                 Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                }).then(() => {
                    location.reload();
                });
            }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema al enviar el formulario'
                }).then(() => {
                    location.reload();
                });
            }
        });
    });
});

$(document).on('click','.btn-rechazo' ,function () {
    var id = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Escriba el motivo del rechazo',
        input: 'text',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, denegar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {
            var descripcion = result.value;

            $.ajax({
                url: '/pedidos/denegar',
                type: 'POST',
                data: {
                    id: id,
                    descripcion: descripcion
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Se denegó el pedido correctamente'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseText || 'Ocurrió un problema al procesar la solicitud'
                    }).then(() => {
                        location.reload();
                    });

                }
            });
        }
    });
});

$('#botonDevolver').on('click', function () {
    var id = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Desea devolver el articulo al inventario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/pedidos/devolver',
                type: 'POST',
                data: {
                    id: id,
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Se denegó el pedido correctamente'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseText || 'Ocurrió un problema al procesar la solicitud'
                    }).then(() => {
                        location.reload();
                    });

                }
            });
        }
    });
});

$(document).ready(function () {
    $('#modalEditarPedido form').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            url: '/pedidos/editarPedido',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Se acepto el pedido correctamente'
                    }).then(() => {
                        location.reload();
                    });
                    return;
                }


                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                }).then(() => {
                    location.reload();
                });

                
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema al enviar el formulario'
                }).then(() => {
                    location.reload();
                });
            }
        });
    });
});

$('#modalInfoPedido').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');

    $.ajax({
        type: "GET",
        url: "/pedidos/detalle",
        dataType: 'json',
        data: { id: id },
        success: function (response) {
            data = response.data;
            let html = ` <div class="container-fluid p-0">
                            <!-- Datos de Adquisición -->
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Datos del Pedido</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">Estado:</span>
                                                <span class="fw-semibold">${data.estado ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">Cliente:</span>
                                                <span class="fw-semibold">${data.cliente ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">Encargado:</span>
                                                <span class="fw-semibold">${data.encargado ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">Fecha:</span>
                                                <span class="fw-semibold">${data.fecha.date.split(" ")[0] ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">N° Orden:</span>
                                                <span class="badge bg-secondary fs-6">${data.orden ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                        ${(data.direccion) ? `<div class="col-md-12">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted  me-2">Dirección:</span>
                                                <span class="fw-semibold" style="word-wrap: break-word; word-break: break-word;">${data.direccion ?? 'N/A'}</span>
                                            </div>
                                        </div>`: `<div class="col-md-12">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted  me-2">Cantidad Solicitada:</span>
                                                <span class="fw-semibold" style="word-wrap: break-word; word-break: break-word;">${data.cantidad ?? 'N/A'}</span>
                                            </div>
                                        </div>`}
                                         
                                        ${(data.estado == "DENEGADO") ? `<div class="col-md-12">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted  me-2">Motivo de Rechazo:</span>
                                                <span class="fw-semibold" style="word-wrap: break-word; word-break: break-word;">${data.descripcion ?? 'N/A'}</span>
                                            </div>
                                        </div>`: ""}
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Datos del articulo</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">N° Artículo:</span>
                                                <span class="badge bg-secondary fs-6">${data.num_articulo ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">Nombre:</span>
                                                <span class="fw-semibold">${data.nombre_articulo ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">Serial:</span>
                                                <span class="fw-semibold">${data.serial ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">Modelo:</span>
                                                <span class="fw-semibold">${data.modelo ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <span class="text-muted me-2">Cantidad Actual:</span>
                                                <span class="badge bg-secondary fs-6">${data.cantidadActual ?? 'N/A'}</span>
                                            </div>
                                        </div>


                        `;

            const atributos = JSON.parse(data['atributos_especificos']);
            Object.keys(atributos).forEach(attrKey => {
                if (atributos[attrKey] === null || atributos[attrKey] === '') {
                    atributos[attrKey] = 'N/A';
                }

                if (attrKey == "corte") {
                    atributos[attrKey] = (atributos[attrKey] == 1) ? "SI" : "NO";
                }
                word = attrKey;
                if (attrKey.includes("_")) {
                    split = attrKey.split("_")
                    word = `${split[0]} ${split[1]}`
                }
                html += `<div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <span class="text-muted me-2">${word}:</span>
                                            <span class="fw-semibold">${atributos[attrKey]}</span>
                                        </div>
                                    </div>`;
            });
            html += "</div></div></div></div>"
            $('#infoPedidoContenido').html(html);


        },
        error: function (xhr) {
            let html = xhr.responseText;
            $('#infoPedidoContenido').html(html);

        }
    });
});
