$('#modalInfoSalida').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');

    $.ajax({
        type: "GET",
        url: "/salidas/obtenerSalidaPorId",
        dataType: 'json',
        data: { id: id },
        success: function (response) {
            data = response.data;
            let html = ` <div class="container-fluid p-0">
   

    <!-- Salida -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-building me-2"></i>Salida</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <span class="text-secondary me-2">Fecha de salida:</span>
                        <span class="fw-semibold">${data.fecha_salida.date.split(" ")[0] ?? 'N/A'}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-flex align-items-start">
                         <span class="text-muted me-2">Motivo:</span>
                        <span class="fw-semibold" style="word-wrap: break-word; word-break: break-word;">${data.motivo}</span>
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





            $('#infoSalidaContenido').html(html);
        },
        error: function (error) {
            alert("Error: " + error);
        }
    })


});