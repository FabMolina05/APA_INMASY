$('#modalEditarUsuario').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var modal = $(this);
    modal.find('#ID_Usuario').val(id);
});

$('#modalEditarArticulo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var categoria = button.data('categoria');

    $.ajax({
        type: "GET",
        url: "/inventario/obtenerArticuloPorId",
        dataType: 'json',
        data: { id: id, categoria: categoria },
        success: function (response) {
            response = response.data;
            let keys = Object.keys(response);
            keys.forEach(key => {


                if (key === 'atributos' && response[key] !== null) {
                    const atributos = JSON.parse(response[key]);
                    Object.keys(atributos).forEach(attrKey => {
                        const attrElement = $('#modalEditarArticulo').find(`#${attrKey}`);
                        if (attrElement.length > 0) {
                            attrElement.val(atributos[attrKey]);
                        }
                    });
                    return;
                }

                const elemento = $('#modalEditarArticulo').find(`#${key}`);

                if (elemento.length > 0) {
                    elemento.val(response[key]);
                }


            });
            $('#modalEditarArticulo').modal('show');

        },
        error: function (error) {
            alert("Error: " + error);
        }
    })

});

$('#modalEditarEntrante').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');

    $.ajax({
        type: "GET",
        url: "/entrada/obtenerEntradaPorId",
        dataType: 'json',
        data: { id: id },
        success: function (response) {
            entrada = response.data;

            let keys = Object.keys(entrada);
            keys.forEach(key => {


                if (key === 'proveedor') {


                    $('#modalEditarEntrante').find(`#${key} option`).filter(function () {
                        return $(this).val() == entrada['id_proveedor'];
                    }).prop("selected", true);

                    return;
                }

                if (key === 'encargado') {


                    $('#modalEditarEntrante').find(`#persona_compra option`).filter(function () {
                        return $(this).val() == entrada['encargado'];
                    }).prop("selected", true);

                    return;
                }
                if (key === 'fecha_entrega') {

                    if (entrada[key] == null) {
                        $('#modalEditarEntrante').find(`#fecha_entrega `).val('');
                        return;
                    }
                    $('#modalEditarEntrante').find(`#fecha_adquisicion `).val(entrada[key].date.split(" ")[0])

                    return;
                }

                const elemento = $('#modalEditarEntrante').find(`#${key}`);

                if (elemento.length > 0) {
                    elemento.val(entrada[key]);
                }


            });
            $('#modalEditarEntrante').modal('show');

        },
        error: function (error) {
            alert("Error: " + error);
        }
    })

});

$('#modalPedirArticulo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var categoria = button.data('categoria');
    var cantActual = button.data('cantidad');


    $(this).find('#cantidadActual').val(cantActual);

    $(this).find('#ID').val(id);

    let html
    if (categoria == 'etiquetas' || categoria == 'cables') {

        html = `<div class="mb-3">
                            <label for="fecha" class="form-label">Fecha requerida del articulo</label>
                            <input type="date" class="form-control date" id="fecha" name="fecha" required>
                        </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad"></input>
                    </div>`
        $(this).find('#contenido-pedido').html(html);
    } else {
        html = `<div class="mb-3">
                            <label for="fecha" class="form-label">Fecha requerida del articulo</label>
                            <input type="date" class="form-control date" id="fecha" name="fecha" required>
                        </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea type="number" class="form-control" id="direccion" name="direccion"></textarea>
                    </div>`
        $(this).find('#contenido-pedido').html(html);

    }


});

$(document).ready(() => {
    $('#hacer-pedido').on('submit', function (e) {
        e.preventDefault();

        var element = $('#modalPedirArticulo').find('#cantidad')
        if (element.length > 0) {
            var cantPedido = element.val();
            var cantActual = $('#modalPedirArticulo').find('#cantidadActual').val();

            if (Number(cantPedido) > Number(cantActual)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'La cantidad solicitada excede la cantidad en inventario',
                    showCloseButton: true
                });

                return;
            }
        }

        $.ajax({
            url: '/inventario/pedirArticulo',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'El pedido se realizó correctamente'
                    }).then(() => {
                        location.assign('/pedidos/index')
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un problema al enviar el formulario'
                    })
                }

            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema al enviar el formulario'
                })
            }
        });




    })

})

$(document).ready(() => {
    $('#rehacer-pedido').on('submit', function (e) {
        e.preventDefault();

        var element = $('#modalPedirArticulo').find('#cantidad')
        if (element.length > 0) {
            var cantPedido = element.val();
            var cantActual = $('#modalPedirArticulo').find('#cantidadActual').val();

            if (Number(cantPedido) > Number(cantActual)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'La cantidad solicitada excede la cantidad en inventario',
                    showCloseButton: true
                });

                return;
            }
        }

        $.ajax({
            url: '/inventario/pedirArticulo',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'El pedido se realizó correctamente'
                    }).then(() => {
                        location.assign('/pedidos/index')
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un problema al enviar el formulario'
                    })
                }

            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema al enviar el formulario'
                })
            }
        });




    })

})




$('#modalAceptarPedido').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');

    $(this).find('#ID').val(id);



});



$('#modalEditarPedido').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');

    $.ajax({
        type: "GET",
        url: "/pedidos/detalle",
        dataType: 'json',
        data: { id: id },
        success: function (response) {
            response = response.data;
            let keys = Object.keys(response);
            keys.forEach(key => {

                if (key == 'direccion' && response[key]) {

                    let html = `<div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea type="number" class="form-control" id="direccion" name="direccion"></textarea>
                    </div>`

                    let element = $('#modalEditarPedido').find('#contenido-pedido')

                    if (element.length > 0) {
                        element.html(html)
                    }
                    element.find('#direccion').val(response[key])
                    return;
                }
                if (key == 'cantidad' && response[key]) {

                    let html = ` <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad"></input>
                    </div>`

                    let element = $('#modalEditarPedido').find('#contenido-pedido')

                    if (element.length > 0) {
                        element.html(html)
                    }
                    element.find('#cantidad').val(response[key])
                    return;
                }

                if (key === 'fecha') {


                    $('#modalEditarPedido').find(`#fecha`).val(response[key].date.split(" ")[0])

                    return;
                }


                const elemento = $('#modalEditarPedido').find(`#${key}`);

                if (elemento.length > 0) {
                    elemento.val(response[key]);
                }


            });
            $('#modalEditarArticulo').modal('show');

        },
        error: function (error) {
            alert("Error: " + error);
        }
    })

});


$('#modalRehacerPedido').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var cantActual = button.data('cantidad');


    $(this).find('#cantidadActual').val(cantActual);

    $(this).find('#ID').val(id);

    $.ajax({
        type: "GET",
        url: "/pedidos/detalle",
        dataType: 'json',
        data: { id: id },
        success: function (response) {
            response = response.data;
            let keys = Object.keys(response);
            keys.forEach(key => {

                if (key == 'direccion' && response[key]) {

                    let html = `<div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea type="number" class="form-control" id="direccion" name="direccion"></textarea>
                    </div>`

                    let element = $('#modalRehacerPedido').find('#contenido-pedido')

                    if (element.length > 0) {
                        element.html(html)
                    }
                    element.find('#direccion').val(response[key])
                    return;
                }
                if (key == 'cantidad' && response[key]) {

                    let html = ` <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad"></input>
                    </div>`

                    let element = $('#modalRehacerPedido').find('#contenido-pedido')

                    if (element.length > 0) {
                        element.html(html)
                    }
                    element.find('#cantidad').val(response[key])
                    return;
                }

                if (key === 'fecha') {


                    $('#modalRehacerPedido').find(`#fecha`).val(response[key].date.split(" ")[0])

                    return;
                }


                const elemento = $('#modalRehacerPedido').find(`#${key}`);

                if (elemento.length > 0) {
                    elemento.val(response[key]);
                }


            });
            $('#modalRehacerPedido').modal('show');

        },
        error: function (error) {
            alert("Error: " + error);
        }
    })

});

$(document).on('click', '.btn-sacar', function () {

    var id = $(this).data('id');


    Swal.fire({
        title: '¿Estás seguro de desechar este artículo?',
        text: 'Escriba el motivo de la salida',
        input: 'text',
        inputAttributes:{'maxLength':'100'},
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, desechar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {
            var descripcion = result.value;

            $.ajax({
                url: '/inventario/sacarArticulo',
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


$('#modalEditarProveedores').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var modal = $(this);
    modal.find('#ID').val(id);

    $.ajax({
        type: "GET",
        url: "/proveedores/obtenerProveedorPorId",
        dataType: 'json',
        data: { id: id },
        success: function (response) {
            response = response.data;
            let keys = Object.keys(response);
            keys.forEach(key => {
                const elemento = $('#modalEditarProveedores').find(`#${key}`);

                if (elemento.length > 0) {
                    elemento.val(response[key]);
                }
            });
            $('#modalEditarProveedores').modal('show');
        },
        error: function (error) {
            alert("Error: " + error);
        }
    })
}
);




function existeOpcion(valor, nombre) {
    let existe = false;
    $("#modalEditarEntrante").find(`#${nombre}`).each(function () {
        if ($(this).val() === valor && $(this).val() != "") {
            existe = true;
            return false;
        }
    });
    return existe;
}
