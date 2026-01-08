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