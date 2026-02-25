let correoIndex = 1;

document.getElementById('agregar-correo').addEventListener('click', function () {
    const container = document.getElementById('correos-container');
    const nuevoCorreo = `
        <div class="correo-item border p-3 mb-3">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Nombre del Contacto</label>
                    <input type="text" class="form-control" name="correos[${correoIndex}][nombre]">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="correos[${correoIndex}][correo]" required>
                </div>
                <div class="col-md-1">
                   
                    <button type="button" class="btn btn-sm btn-danger mt-2 eliminar-correo">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', nuevoCorreo);
    correoIndex++;
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('eliminar-correo') || e.target.closest('.eliminar-correo')) {
        const correoItem = e.target.closest('.correo-item');
        if (document.querySelectorAll('.correo-item').length > 1) {
            correoItem.remove();
        } else {
            alert('Debe haber al menos un correo');
        }
    }
});

