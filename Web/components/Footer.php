</div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="/public/JS/UsersDataTable.js"></script>
<script src="/public/JS/modales.js"></script>
<script src="/public/JS/infoArticulos.js"></script>
<script src="/public/JS/infoEntradas.js"></script>
<script src="/public/JS/infoSalidas.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>

<script src="/public/JS/pedidos.js"></script>

<?php
$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');
$request = str_replace('/index.php', '', $request);
$request = $request ?: '/';


if (str_contains($request, 'registros')) {
    echo '<script src="/public/JS/registros.js"></script>';
} elseif (str_contains($request, 'entrada')) {
    echo '<script src="/public/JS/entradas.js"></script>';
}
?>



</html>