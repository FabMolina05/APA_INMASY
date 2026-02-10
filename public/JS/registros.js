$(window).on('load', function () {

    $.ajax({
        url: '/registros/totalCapital',
        type: 'GET',
        success: function (response) {
            const ctx = document.getElementById('capitalChart').getContext('2d');
            $('#totalCapital').append(new Intl.NumberFormat('es-CR', {
                style: 'currency',
                currency: 'CRC'
            }).format(response.data.TOTAL))
            setTimeout(() => {
                const capitalChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Capital Total'],
                        datasets: [{
                            label: 'Capital Invertido',
                            data: [response.data.TOTAL],
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgb(75, 192, 192)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart',
                            onComplete: function () {
                                console.log('Animación completada');
                            }
                        },
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return '₡' + context.parsed.y.toLocaleString('es-CR', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return '₡' + value.toLocaleString('es-CR');
                                    }
                                }
                            }
                        }
                    }
                });
            }, 300);
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un problema al cargar el dashboard'
            }).then(() => {
                location.assign('/');
            });
        }
    });
});

$(window).on('load', function () {


    $.ajax({
        url: '/registros/totalPorCategoria',
        type: 'GET',
        success: function (response) {
            const ctx = document.getElementById('categoriaChart').getContext('2d');
            $('#totalCategoria').html('-');
            $('#textCategoria').html('-');

            let keys = Object.keys(response.data);
            let data = []
            keys.forEach(key => {
                data.push(response.data[key])
            })
            const capitalChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: keys,
                    datasets: [{
                        label: 'Total por categoría',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgb(75, 192, 192)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart',
                        onComplete: function () {
                            console.log('Animación completada');
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },

                    },
                    scales: {
                        y: {
                            beginAtZero: true,

                        }
                    },
                    onClick: (event, activeElements) => {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const categoria = keys[index];
                            const total = data[index];

                            $('#totalCategoria').html(total);
                            $('#textCategoria').html(categoria);

                            const backgroundColors = keys.map((_, i) =>
                                i === index ? 'rgba(75, 192, 192, 0.9)' : 'rgba(75, 192, 192, 0.3)'
                            );


                            capitalChart.data.datasets[0].backgroundColor = backgroundColors;
                            capitalChart.update('active'); 
                        }
                    },
                    onHover: (event, activeElements) => {
                        event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                    }

                }
            });
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un problema al cargar el dashboard'
            }).then(() => {
                location.assign('/');
            });
        }
    });

});




$(document).ready(function () {

    $.ajax({
        url: '/registros/totalRegistros',
        type: 'GET',
        success: function (response) {
            var response = response.data
            $('#totalEntradas').html(response.Entrante)
            $('#totalSalidas').html(response.Salidas)
            $('#totalInventario').html(response.Inventario)
            $('#totalPedidos').html(response.Pedidos)
            $('#totalUsuarios').html(response.Usuarios)
            $('#totalProveedores').html(response.Proveedores)
            $('#totalPendiente').html(`<i class="fas fa-clock"></i> ${response.Pendiente} Pendientes`)

        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un problema al cargar el dashboard'
            }).then(() => {
                location.assign('/');
            });
        }
    });

});