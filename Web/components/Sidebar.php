<?php 

$usuario = $_SESSION['usuario_INMASY'];


?>
<div class="sidebar">
    <div class="sidebar-header">
        <h3><a href="/" style="text-decoration: none; color : white"><img src="/public/Assets/logo.png"> INMASY</a></h3>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <?php if($usuario['rol']==1):?>
            <li class="nav-item">
                <a href="#dashboard" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php endif ?>
            <?php if($usuario['rol']==1):?>
            <li class="nav-item">
                <a href="#pedidos" class="nav-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pedidos</span>
                </a>
            </li>
            <?php endif ?>
            <?php if($usuario['rol']==1 or $usuario['rol']==2 or $usuario['rol']==3 ):?>
            <li class="nav-item">
                <a href="#inventario" class="nav-link">
                    <i class="fas fa-warehouse"></i>
                    <span>Inventario</span>
                </a>
            </li>
            <?php endif ?>
            <?php if($usuario['rol']==1):?>
            <li class="nav-item">
                <a href="#entradas" class="nav-link">
                    <i class="fas fa-arrow-circle-down"></i>
                    <span>Entradas</span>
                </a>
            </li>
            <?php endif ?>
            <?php if($usuario['rol']==1):?>
            <li class="nav-item">
                <a href="#salidas" class="nav-link">
                    <i class="fas fa-arrow-circle-up"></i>
                    <span>Salidas</span>
                </a>
            </li>
            <?php endif ?>
            <?php if($usuario['rol']==1):?>
            <li class="nav-item">
                <a href="#Registros" class="nav-link">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Registros</span>
                </a>
            </li>
            <?php endif ?>
            <?php if($usuario['rol']==1):?>
            <li class="nav-item">
                <a href="/usuarios/index" class="nav-link">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <?php endif ?>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-details">
                <p class="user-name"><?php echo htmlspecialchars($usuario['nombre_completo']) ?></p>
                <p class="user-role"><?php echo htmlspecialchars($usuario['rol_nombre']) ?></p>
            </div>
        </div>
    </div>
</div>
<script src="/public/JS/sidebar.js"></script>
<div class="main-content">