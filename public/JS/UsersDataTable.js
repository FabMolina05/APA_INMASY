$(document).ready(function() {
    $('#usuariosTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        pageLength: 10,
        order: [[0, 'desc']], 
        
    });
});