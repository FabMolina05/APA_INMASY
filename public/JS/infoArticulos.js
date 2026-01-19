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

            let keys = Object.keys(response);
            let html = `<div class="container-fluid p-0">
                         <div class="card border-0 shadow-sm mb-3">
        
        <div class="card-body">
            <div class="row g-${keys.length}">
            `;
            keys.forEach(key => {
                if (key !== "Activo" && key !== "ID") {

                    if (key === "Disponibilidad") {
                        let disponibilidad = response[key] === 1 ? 'Ocupado' : 'Libre';
                        html += `<div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <span class="text-muted me-2">${key}:</span>
                                    <span class="fw-semibold">${disponibilidad}</span>
                                </div>
                            </div>`;
                        return;
                    }
                    if (key === "Tecnico" && response[key] === null) {
                        html += `<div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <span class="text-muted me-2">${key}:</span>
                                    <span class="fw-semibold">Sin Ocupar</span>
                                </div>
                            </div>`;
                        return;
                    }
                    if (key === "atributos" && response[key] === null) {
                        return;
                    }
                    if (key === "atributos" && response[key] !== null) {
                        const atributos = JSON.parse(response[key]);
                        Object.keys(atributos).forEach(attrKey => {
                            if (atributos[attrKey] === null || atributos[attrKey] === '') {
                                atributos[attrKey] = 'N/A';
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
                        return;
                    }
                    if (key.includes("_")) {
                        split = key.split("_")
                        word = `${split[0]} ${split[1]}`
                        html += `<div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <span class="text-muted me-2">${word}:</span>
                                    <span class="fw-semibold">${response[key]}</span>
                                </div>
                            </div>`;
                        return;
                    }
                    html += `<div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <span class="text-muted me-2">${key}:</span>
                                    <span class="fw-semibold">${response[key]}</span>
                                </div>
                            </div>`;

                }

            });
            html += `</div>
        </div>
    </div>`
            $('#infoArticuloContenido').html(html);
        },
        error: function (error) {
            alert("Error: " + error);
        }
    })


});