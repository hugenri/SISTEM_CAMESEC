<?php

include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'empleado') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}
?>

<?php
$titulo_pagina = "index";
require_once 'layout/header_empleado.php';
?>


<body class="d-flex flex-column min-vh-100">
<?php
$titulo_pagina = "Home";
require_once 'layout/menu_empleado2.php';
?>



<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->
<div id="card-contenido" class="container">
<div class="row mb-4">

<div class="col-lg-6 col-md-6">
        <div class="card  custom-card text-center mb-2 align-items-center justify-content-center"
            onclick="window.location.href='nuevos_servicios.php';" style="cursor: pointer;">
            <img src="assets/images/nuevosServicios.png" class="card-img-top mt-1" alt="Imagen2">
            <div class="card-body">
                <h5 class="card-title">Nuevos servicios</h5>
                <span id="numServicios"></span></p>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="card  custom-card text-center mb-2 align-items-center justify-content-center"
            onclick="window.location.href='servicios.php';" style="cursor: pointer;">
            <img src="assets/images/servicio2.png" class="card-img-top mt-1" alt="Imagen2">
            <div class="card-body">
                <h5 class="card-title">Todos los servicios</h5>
                <span id="numNuevosServicios"></span></p>
            </div>
        </div>
    </div>
</div>

</div>
</div> <!-- fin del contenido-->

<script  src="assets/JS/entregas.js"></script>


<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

