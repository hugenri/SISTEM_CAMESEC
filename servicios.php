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



<div class="row justify-content-center align-items-center mt-4 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Servicios</h3>
        </div>
    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabla" class="table table-striped table-sm">
                        </table>
                        <div class="text-center">
                       <h4 id="NoData"></h4> <!-- mensaje si no hay datos que mostrar -->
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





</div> <!-- fin del contenido-->

<script  src="assets/JS/verificarServicios.js"></script>


<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

