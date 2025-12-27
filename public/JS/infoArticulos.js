$('#modalInfoArticulo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var categoria = button.data('categoria');

    $.ajax({
        type: "GET",
        url: "/inventario/obtenerArticuloPorId",
        data: { id: id, categoria: categoria },
        success: function (response) {
            
        },
        error: function (error) {
            alert("Error: " + error);
        }
    })


});