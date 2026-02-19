$('#modalInfoEntrada').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');

    $.ajax({
        type: "GET",
        url: "/entrada/obtenerEntradaPorId",
        dataType: 'json',
        data: { id: id },
        success: function (response) {
            data = response.data;
            let html = ` <div class="container-fluid p-0">
    <!-- Datos de Adquisición -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Datos de Adquisición</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Factura:</span>
                        <span class="fw-semibold">${data.factura ?? 'N/A'}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Encargado:</span>
                        <span class="fw-semibold">${data.encargado}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Tipo de Pago:</span>
                        <span class="fw-semibold">${data.tipo_pago ?? 'N/A'}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Número de Fondo:</span>
                        <span class="fw-semibold">${data.num_fondo ?? 'N/A'}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Cantidad:</span>
                        <span class="badge bg-secondary fs-6">${data.cantidadAdquisicion ?? 'N/A'}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-flex align-items-start">
                        <span class="text-muted  me-2">Garantía:</span>
                        <span class="fw-semibold" style="word-wrap: break-word; word-break: break-word;">${data.garantia ?? 'N/A'}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Proveedor -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-building me-2"></i>Proveedor</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-secondary me-2">Proveedor:</span>
                        <span class="fw-semibold">${data.proveedor ?? 'N/A'}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Teléfono:</span>
                        <span class="fw-semibold">${data.tel_proveedor ?? 'N/A'}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Artículo -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Información del Artículo</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Almacenamiento:</span>
                        <span class="fw-semibold">${data.almacenamiento}</span>
                    </div>
                </div>
                ${data.num_catalogo ? `
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">N° de Catálogo:</span>
                        <span class="fw-semibold">${data.num_catalogo ?? 'N/A'}</span>
                    </div>
                </div>
                ` : ''}
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Nombre:</span>
                        <span class="fw-semibold" style="word-wrap: break-word; word-break: break-word;">${data.nombre_articulo}</span>
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
                        <span class="text-muted me-2">Categoria:</span>
                        <span class="fw-semibold">${data.categoria ?? 'N/A'}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Número de Artículo:</span>
                        <span class="badge bg-secondary fs-6">${data.num_articulo ?? 'N/A'}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-muted me-2">Cantidad:</span> 
                        <span class="badge bg-secondary fs-6">${data.cantidad ?? 'N/A'}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`;





            $('#infoEntradaContenido').html(html);
        },
        error: function (error) {
            alert("Error: " + error);
        }
    })


});

$('#modalFechaEntrada').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');

    $('#btnAgregar').val(id);


})

function agregarFecha() {
    var id = $('#btnAgregar').val();

    $.ajax({
        type: "GET",
        url: "/entrada/establecerFecha",
        dataType: 'json',
        data: { id: id },
        success: function (response) {
            console.log(response)
            if (response.success) {
                Swal.fire({
                    title: 'Exito!!',
                    icon: 'success',
                    timer: 4000,
                    showConfirmButton: false,
                }).then(()=>{
                    location.reload();
                })
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'No se pudo agregar la fecha',
                    icon: 'error',
                    timer: 6000
                }).then(()=>{
                    
                        location.reload();
                    
                })
            }
        },
        error: function (error) {
            alert("Error: " + error.responseText);
        }


    });
}