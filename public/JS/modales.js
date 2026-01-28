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

    $(this).find('#ID').val(id);

});

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
        data: { id: id},
        success: function (response) {
            response = response.data;
            let keys = Object.keys(response);
            keys.forEach(key => {

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
