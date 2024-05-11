<?php
include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}
?>


<?php
$titulo_pagina = "Vuevas Facturas";
require_once 'layout/header_admin.php';
?>

<body class="d-flex flex-column min-vh-100">
    <?php
    require_once 'layout/menu_admin.php';
    ?>
    <div id="div-contenido" class="container-fluid flex-grow-1">

    <div id="card-contenido" class="container" style=" margin-top: 100px;">
<div class="row mb-4">

<div class="col-lg-6 col-md-6">
        <div class="card  text-center mb-2 align-items-center justify-content-center"
            onclick="window.location.href='nuevas_facturas.php';" style="cursor: pointer;">
            <img src="assets/images/nuevasFacturas.png" class="mt-1" alt="Imagen2">
            <div class="card-body">
                <h5 class="card-title">Nuevos Facturas</h5>
                <span id="numNuevasFacturas"></span></p>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="card  text-center mb-2 align-items-center justify-content-center"
            onclick="window.location.href='ver_facturas.php';" style="cursor: pointer;">
            <img src="assets/images/facturas.png" class="mt-1" alt="Imagen2">
            <div class="card-body">
                <h5 class="card-title">Facturas</h5>
                <span id="numFacturas"></span></p>
            </div>
        </div>
    </div>
</div>

</div>
        
</div>   <!-- #########-->
    <script  src="assets/JS/get_numero_facturas.js"></script>
    
    <script>
        responsive_topnav();
    </script>
    <!-- Pie de página -->
    <?php
    require_once 'layout/footer2.php';
    ?>
</body>
</html>
