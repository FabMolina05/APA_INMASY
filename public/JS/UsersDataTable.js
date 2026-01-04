$(document).ready(function() {
    $('#usuariosTable').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Buscar usuarios...",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ usuarios",
            infoEmpty: "Mostrando 0 a 0 de 0 usuarios",
            infoFiltered: "(filtrado de _MAX_ usuarios totales)",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            emptyTable: "No hay datos disponibles"
        },
        pageLength: 10,
        order: [[0, 'asc']],
        searching: true,
        responsive: true
    });
});
$(document).ready(function() {
    $('#inventarioTable').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Buscar articulo...",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ articulos",
            infoEmpty: "Mostrando 0 a 0 de 0 usuarios",
            infoFiltered: "(filtrado de _MAX_ articulos totales)",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            emptyTable: "No hay datos disponibles"
        },
        pageLength: 10,
        order: [[0, 'asc']],
        searching: true,
        responsive: true
    });
});

