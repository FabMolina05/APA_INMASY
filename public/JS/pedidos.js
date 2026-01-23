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
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Se acepto el pedido correctamente'
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

$('#botonDenegar').on('click', function () {
    var id = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, denegar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/pedidos/denegar',
                type: 'POST',
                data: { id: id },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Se denegó el pedido correctamente'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un problema al procesar la solicitud'
                    });
                }
            });

        }
    });
});