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
$titulo_pagina = "Ver proveedores";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

<div class="row justify-content-center align-items-center mt-2 mb-3">
   <div class="col-lg-12 col-md-6 col-sm-12 text-center">
<h3 id="titulo" class="mb-3">Asignación de categoría a Proveedores</h3>
            
        </div>
    </div>

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12">
<div class="card">
    <div class="card-header">
                    <h4>Proveedores</h4>
       </div>
        <div class="card-body">
    <div class="table-responsive">
<table id="tablaProveedor" class="table table-striped table-sm">
</table>
</div>
</div>
</div>
</div>
</div>
<div class="row justify-content-center">
<div class="col-lg-12 col-md-12 col-sm-12">
<div class="justify-content-center">
<h4 id="NoData"></h4> <!-- mensaje si no hay datos que mostrar -->
</div> 
</div>
</div> 
</div>
</div>


</div> <!-- fin del contenido-->

<script languaje= "javascript" src="assets/JS/categoriaproveedor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            getProveedores(); // Llama a la función cuando la página esté cargada
        });
    </script>
<script>
responsive_topnav();
</script>

 <!-- Pie de página -->
 
 <?php
require_once 'layout/footer2.php';
?>

</body>
</html>
