<?php

include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'compras') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}
?>

<?php
$titulo_pagina = "index";
require_once 'layout/header_compras.php';
?>


<body class="d-flex flex-column min-vh-100">
<?php
$titulo_pagina = "Home";
require_once 'layout/menu_empleado.php';
?>


<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->


<div id="card-contenido2" class="container">
<div class="row mb-4">

<div class="col-lg-4 col-md-1 mb-2">
        <div class="card  compras-custom-card text-center mb-2 align-items-center justify-content-center"
            onclick="window.location.href='nuevas_ordenes_compras.php';" style="cursor: pointer;">
            <img src="assets/images/nuevasCompras.png" class="mt-2 mb-2" alt="Imagen2">
            <div class="card-body">
                <h5 class="card-title">Nuevos ordenes de compras</h5>
                <p><span id="numNuevasOrdenes"></span></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-1 mb-2">
        <div class="card  compras-custom-card  text-center mb-2 align-items-center justify-content-center"
            onclick="window.location.href='ordenes_compras.php';" style="cursor: pointer;">
            <img src="assets/images/compras2.png" class="mt-2 mb-2" alt="Imagen2">
            <div class="card-body">
                <h5 class="card-title">Ordenes de compras</h5>
               <p> <span id="numOrdenes"></span></p>
            </div>
        </div>
</div>
<div class="col-lg-4 col-md-1">
        <div class="card  compras-custom-card  text-center mb-2 align-items-center justify-content-center"
            onclick="window.location.href='proveedores.php';" style="cursor: pointer;">
            <img src="assets/images/listaProveedores2.png" class="mt-2 mb-2" alt="Imagen2">
            <div class="card-body">
                <h5 class="card-title">Proveedores</h5>
                <p> <span id="numProveedores"></span></p>
            </div>
        </div>
    </div>
</div>
</div>
</div> <!-- fin del contenido-->

<script src="assets/JS/getNumeroRegistros.js"></script>


<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

