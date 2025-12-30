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
            keys.forEach(key =>{
                html += '<p class="my-3"><strong>'+key+'</strong> :'+response[key]+'</p>';
            });

            $('#infoArticuloContenido').html(html);
        },
        error: function (error) {
            alert("Error: " + error);
        }
    })


});