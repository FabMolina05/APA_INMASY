<?php $page = 'dashboard';?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="mb-0">Dashboard</h2>
            <p class="text-muted">Resumen general del sistema</p>
        </div>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Inventario</p>
                            <h2 class="stat-number text-primary mb-0" id='totalInventario'>-</h2>
                        </div>
                        <div class="stat-icon text-primary">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Entradas</p>
                            <h2 class="stat-number text-success mb-0" id='totalEntradas'>-</h2>
                        </div>
                        <div class="stat-icon text-success">
                            <i class="fas fa-arrow-circle-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Salidas</p>
                            <h2 class="stat-number text-danger mb-0" id='totalSalidas'>-</h2>
                        </div>
                        <div class="stat-icon text-danger">
                            <i class="fas fa-arrow-circle-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Usuarios</p>
                            <h2 class="stat-number text-info mb-0" id='totalUsuarios'>-</h2>
                            <small class="text-muted">Activos en el sistema</small>
                        </div>
                        <div class="stat-icon text-info">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Pedidos</p>
                            <h2 class="stat-number text-warning mb-0" id='totalPedidos'>-</h2>
                            <small class="text-warning" id='totalPendiente'>-</small>
                        </div>
                        <div class="stat-icon text-warning">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Proveedores</p>
                            <h2 class="stat-number text-secondary mb-0" id='totalProveedores'>-</h2>
                            <small class="text-muted">Proveedores activos</small>
                        </div>
                        <div class="stat-icon text-secondary">
                            <i class="fas fa-truck"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-chart-line text-primary"></i> Total de Capital</h5>
                    <p class="text-muted small mb-0">Valor total del inventario</p>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <h2 class="text-success mb-0" id='totalCapital'></h2>
                            <p class="text-muted mb-0">Capital total invertido</p>
                        </div>

                    </div>
                    <div class="chart-container">
                        <canvas id="capitalChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-0"><i class="fas fa-chart-line text-primary"></i> Total de Artículos Por Categoría</h5>
                                <p class="text-muted small mb-0">Total del inventario</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-3 mx-1">

                        <div class="col-md-6">

                            <h2 class="text-success mb-0" id='totalCategoria'></h2>
                            <p class="text-muted mb-0" id='textCategoria'>-</p>

                        </div>

                    </div>
                    <div class="chart-container">
                        <canvas id="categoriaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

