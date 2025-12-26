function actualizarNombre() {
    const select = document.getElementById('usuarioPADDE');
    const textoSeleccionado = select.options[select.selectedIndex].text;
    document.getElementById('nombreUsuarioPADDE').value = textoSeleccionado;
}