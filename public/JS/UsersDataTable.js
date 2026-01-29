$(document).ready(function() {
    $('#proveedoresTable').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Buscar proveedores...",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ proveedores",
            infoEmpty: "Mostrando 0 a 0 de 0 proveedores",
            infoFiltered: "(filtrado de _MAX_ proveedores totales)",
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
            infoEmpty: "Mostrando 0 a 0 de 0 articulos",
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

$(document).ready(function() {
    $('#entrantesTable').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Buscar entrante...",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ articulos",
            infoEmpty: "Mostrando 0 a 0 de 0 entradas",
            infoFiltered: "(filtrado de _MAX_ entrantes totales)",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            emptyTable: "No hay datos disponibles"
        },
        pageLength: 10,
        order: [[3, 'desc']],
        searching: true,
        responsive: true
    });
});

$(document).ready(function() {
    $('#misPedidosTable').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Buscar pedido...",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ Pedidos",
            infoEmpty: "Mostrando 0 a 0 de 0 pedidos",
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

$(document).ready(function() {
    $('#listaPedidosTable').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Buscar pedido...",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ Pedidos",
            infoEmpty: "Mostrando 0 a 0 de 0 pedidos",
            infoFiltered: "(filtrado de _MAX_ pedidos totales)",
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

