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
$titulo_pagina = "Mis Compras";
require_once 'layout/header_user.php';
?>

<body class="d-flex flex-column min-vh-100">
<?php
require_once 'layout/menu_user.php';
?>

<div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido en este div -->
<div class="container">
    <h1 class="mb-3 mt-3">Mis compras de  productos</h1>
    <div class="row row-cols-1 row-cols-md-2 g-4" id="comprasContainer">
      <!-- Aquí se mostrarán las tarjetas de las solicitudes -->
    </div>
  </div>




</div><!-- fin contenido en este div -->
 
<!-- modal popup orden compra -->
<div id="modalPopup" class="divPopup container-fluid flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-md-11">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="text-center mb-0">Información de compra</h4>
                    <img src="assets/images/cerrar.png" alt="Cerrar" onclick="cerrarModal(event)">
                </div>
                <div class="card-body">
                    <div class="container">
                        <!-- Aquí  añadir más contenido si es necesario -->
                        <h4>Mi compra</h4>

<div class="row">
<div class="col-md-6  mt-2">

<h5 id="venta-id"></h5>
  <p id="fecha-venta"></p>
  <h4>Produtos de su compra</h4>

   <!-- Aquí agregaré una lista de productos -->
<div id="productos-lista"></div>
  </div>
  <div class="col-md-6  border-danger">
  <h5 >Detalles de Envío</h5>
  <p id="direccion-envio"></p>
  <hr>
  <h5 >Entrega</h5>
  <p id="fecha-entrega" class="mb-0"></p>
  <p  id="estado-entrega"></p>
  <hr>
  <h5>Total de la Compra</h5>
<p id="total-venta" class="mb-0"></p>
<p id="iva" class="mb-0"></p>
<p id="total-iva"></p>
<hr>

  <h5 class="card-title mt-2">Detalles de Pago</h5>
  <p  id="fecha-pago" class="mb-0"></p>
  <p id="metodo-pago" class="mb-0"></p>
  <p id="estado-pago"></p>
  </div>
  </div>
  </div>

                    </div><!--####-->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/JS/miscompras.js"></script>

<script>
    responsive_topnav();
</script>

<!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>
</html>
