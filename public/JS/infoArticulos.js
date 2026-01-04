$('#modalInfoArticulo').on('show.bs.modal', function (event) {
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
            let html = '';
            let keys = Object.keys(response);
            keys.forEach(key => {
                if (key !== "Activo" && key !== "ID") {

                    if (key === "Disponibilidad") {
                        let disponibilidad = response[key] === 1 ? 'Ocupado' : 'Libre';
                        html += '<p class="my-3 mx-3    "><strong>' + key + '</strong> :' + disponibilidad + '</p>';
                        return;
                    }
                    if (key === "Tecnico" && response[key] === null) {
                        html += '<p class="my-3 mx-3    "><strong>' + key + '</strong> : Sin ocupar</p>';
                        return;
                    }
                    if (key === "atributos") {
                        const atributos = JSON.parse(response[key]);
                        Object.keys(atributos).forEach(attrKey => {
                            html += '<p class="my-3 mx-3    "><strong>' + attrKey + '</strong> :' + atributos[attrKey] + '</p>';
                        });
                        return;
                    }
                    html += '<p class="my-3 mx-3    "><strong>' + key + '</strong> :' + response[key] + '</p>';

                }

            });

            $('#infoArticuloContenido').html(html);
        },
        error: function (error) {
            alert("Error: " + error);
        }
    })


});