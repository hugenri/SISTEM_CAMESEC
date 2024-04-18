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



<div id="div-contenido" class="container-fluid flex-grow-1">
    <div class="row">
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



<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

