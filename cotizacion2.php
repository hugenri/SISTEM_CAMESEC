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
require_once 'layout/menu_user.php';
?>

<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->
<div class="container mt-5">
<div class="row">
        <h3 class=" mb-4">Avisos de Cotizaciones</h3>
        <div id="cotizacionesContainer" class="row">
            <!-- Aquí se mostrarán los avisos de las cotizaciones -->
        </div>
    </div>
</div>

</div> <!-- fin de div id="div-contenido" -->




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script  src="assets/JS/mostrar_cotizacion.js"></script>




<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

