
<div class="sidebar">
    <div class="sidebar-header">
        <h3><a href="/" style="text-decoration: none; color : white"><img src="/public/Assets/logo.png"> INMASY</a></h3>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <?php
            $usuario = $_SESSION['usuario_INMASY'];

            // Dashboard     
            if ($usuario['rol'] == 1) {
                echo ' <li class="nav-item">';
                echo ' <a href="/registros/index" class="nav-link">';
                echo ' <i class="fas fa-chart-line"></i>';
                echo ' <span>Dashboard</span>';
                echo ' </a>';
                echo ' </li>';
            }

            // Pedidos
            if ($usuario['rol'] == 1 || $usuario['rol'] == 3) {
                echo ' <li class="nav-item">';
                echo ' <a href="/pedidos/index" class="nav-link">';
                echo ' <i class="fas fa-shopping-cart"></i>';
                echo ' <span>Pedidos</span>';
                echo ' </a>';
                echo ' </li>';
            }

            // Inventario con dropdown
            if ($usuario['rol'] == 1 || $usuario['rol'] == 2 || $usuario['rol'] == 3) {
                echo ' <li class="nav-item dropdown">';
                echo ' <a class="nav-link dropdown-toggle" id="inventario" href="#inventario" data-bs-toggle="dropdown" aria-expanded="false">';
                echo ' <i class="fas fa-warehouse"></i>';
                echo ' <span>Inventario</span>';
                echo ' </a>';
                echo ' <ul class="dropdown-menu">';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=cables&id=4">Cables</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=comunicaciones&id=5">Comunicaciones</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=gabinetes&id=6">Gabinetes</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=electronica&id=1">Equipo Electronico</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=reles&id=2">Reles</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=tarjetas&id=3">Tarjetas</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=baterias&id=8">Baterías</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=reconectador&id=9">Reconectador</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=seccionador&id=10">Seccionador</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=etiquetas&id=11">Etiquetas</a></li>';
                echo ' <li><a class="nav-link" href="/inventario/categoria?categoria=otros&id=7">Otros</a></li>';
                echo ' </ul>';
                echo ' </li>';
            }
         
         
            // Entradas
            if ($usuario['rol'] == 1 || $usuario['rol'] == 2) {
                echo ' <li class="nav-item">';
                echo ' <a href="/entrada/index" class="nav-link">';
                echo ' <i class="fas fa-arrow-circle-down"></i>';
                echo ' <span>Entradas</span>';
                echo ' </a>';
                echo ' </li>';
            }

            // Salidas
            if ($usuario['rol'] == 1) {
                echo ' <li class="nav-item">';
                echo ' <a href="/salidas/index" class="nav-link">';
                echo ' <i class="fas fa-arrow-circle-up"></i>';
                echo ' <span>Salidas</span>';
                echo ' </a>';
                echo ' </li>';
            }

            // Bitacora
            if ($usuario['rol'] == 1) {
                echo ' <li class="nav-item">';
                echo ' <a href="/bitacora/index" class="nav-link">';
                echo ' <i class="fa-solid fa-clock-rotate-left"></i>';
                echo ' <span>Bitácora</span>';
                echo ' </a>';
                echo ' </li>';
            }

            // Usuarios
            if ($usuario['rol'] == 1) {
                echo ' <li class="nav-item">';
                echo ' <a href="/usuarios/index" class="nav-link">';
                echo ' <i class="fa-solid fa-user-gear"></i>';
                echo ' <span>Usuarios</span>';
                echo ' </a>';
                echo ' </li>';
            }

            // Proveedores
            if ($usuario['rol'] == 1) {
                echo ' <li class="nav-item">';
                echo ' <a href="/proveedores/index" class="nav-link">';
                echo ' <i class="fa-solid fa-truck"></i>';
                echo ' <span>Proveedores</span>';
                echo ' </a>';
                echo ' </li>';
            }




            echo '        </ul>';
            echo '    </nav>';

            echo '    <div class="sidebar-footer">';
            echo '        <div class="user-info">';
            echo '            <div class="user-avatar">';
            echo '                <i class="fas fa-user"></i>';
            echo '            </div>';
            echo '            <div class="user-details">';
            echo '                <p class="user-name">' . htmlspecialchars($usuario['nombre_completo']) . '</p>';
            echo '                <p class="user-role">' . htmlspecialchars($usuario['rol_nombre']) . '</p>';
            echo '            </div>';
            ?>
</div>
</div>
</div>
<script src="/public/JS/sidebar.js"></script>
<div class="main-content">