<?php
include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'cliente') {
    $site = $session->checkAndRedirect();
    header('location:' . $site);
}
?>

<?php
$titulo_pagina = "Home";
require_once 'layout/header_user.php';
?>

<body class="d-flex flex-column min-vh-100">
<?php
require_once 'layout/menu_user.php';
?>

<div id="div-contenido" class="container flex-grow-1"> <!-- el contenido en este div -->
    <div class="mt-5 mb-3">
    <h3>Completa tu compra</h3>
</div>
    <div class="row container-fluid mt-3">
        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
            <div id="info-venta">
                <h5>Datos del Cliente</h5>
                <p id="nombre" class="mb-0"></p>
                <p id="razonSocial" class="mb-0"></p>
                <hr>
                <div class="mb-5 mt-2">
                <h5>Productos de la compra</h5>
</div>
                <div id="productos"></div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 mt-3 border border-primary rounded p-3">
            <h5>Total a pagar</h5>
            <p id="total"></p>
            <hr>

            <h5>Opciones de Pago</h5>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="tarjeta" id="tarjeta">
                    <label class="form-check-label" for="tarjeta">
                        Tarjeta de Crédito/Débito
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="paypal" id="paypal">
                    <label class="form-check-label" for="paypal">
                        PayPal
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="transferencia" id="transferencia">
                    <label class="form-check-label" for="transferencia">
                        Transferencia Bancaria
                    </label>
                </div>
            </div>
            <button class="btn btn-primary mt-3 w-100" onclick="procesarPago()">Pagar</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/JS/pago.js"></script>

<script>
    responsive_topnav();
</script>

<!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>
</html>
