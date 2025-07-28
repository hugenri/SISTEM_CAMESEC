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
$titulo_pagina = "Home";
require_once 'layout/menu_user1.php';
?>


<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

<div class="row mt-3">
    <div class="col-lg-12 col-md-12 mt-1">
        <a href="mis_compras.php" class="btn btn-primary">
            <i class="fas fa-shopping-cart"></i>Ver mis Compras realizadas
        </a>
    </div>
</div>


<div class="row mt-2" id="cotizaciones-container" style="display: none;"> <!-- Contenedor oculto por defecto -->
    <div class="col-12 d-flex justify-content-end align-items-center"> <!-- Alineación a la derecha -->
    <a id="notificacion " href="aviso_cotizacion.php" class="text-decoration-none  cursor-pointer"> <!-- Agrega el enlace aquí -->
        <div class="card contenedor-notificacion">
            <div class="card-body card-body-notificacion" id="dropdown-card">
                <span style="display: inline;">
                    <h6 class="card-title" style="display: inline;">Cotizaciones por aprobar</h6>
                    <img src="assets/images/ctz2.png" class="" alt="Imagen de cliente" style="display: inline;">
                    <span id="notification-count"></span>
                </span>

            </div>
        </div>
</a>
    </div>
</div>

    <!-- ########################## -->
   
    <div class="row mt-3">
        <!-- Card para compra de productos -->
        <div class="col-lg-6 col-md-6 mt-3">
            <div class="card text-center" onclick="window.location.href='carrito.php';" style="cursor: pointer;">
                <img src="assets/images/imagen_productos.png" class="card-img-top mx-auto" alt="Imagen de productos">
                <div class="card-body">
                    <h5 class="card-title">Compra de Productos</h5>
                    <p class="card-text">Aquí puedes comprar los productos que necesitas.</p>
                </div>
            </div>
        </div>
        <!-- Card para servicios -->
        <div class="col-lg-6 col-md-6 mt-3">
            <div class="card text-center" onclick="window.location.href='solicitudServicio.php';" style="cursor: pointer;">
                <img src="assets/images/imagen_servicios.png" class="card-img-top mx-auto" alt="Imagen de servicios">
                <div class="card-body">
                    <h5 class="card-title">Servicios</h5>
                    <p class="card-text">Aquí puedes solicitar una cotización de los servicios</p>
                </div>
            </div>
        </div>
    </div>
</div>







</div> <!-- fin del contenido-->

<script  src="assets/JS/getNumeroCotizaciones.js"></script>


<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

