<?php
include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'usuario' && $session->getSessionVariable('rol_usuario') != 'empleado') {
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



  <div class="row">

    <div class="col-12 d-flex align-items-center justify-content-center">

        <div class="text-center">

            <h1>¡Bienvenido Usuario!  <?=$session->getSessionVariable('nombre') . ' '. $session->getSessionVariable('apellidoPaterno')?></h1>

            <img src="assets/images/integracion.jpg" alt="imagen" class="img-fluid mx-auto d-block">
           
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

