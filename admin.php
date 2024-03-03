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
$titulo_pagina = "Administrador";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin1.php';
?>



<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

  <div class="row mb-3">

    <div class="col-12 d-flex align-items-center justify-content-center">

        <div class="text-center">

            <h3>!Bienvenido Administrador! <?=$session->getSessionVariable('nombre') . ' '. $session->getSessionVariable('apellidoPaterno')?></h3>           

          </div>

    </div>

</div>



<div class="row">

            <div class="col-lg-2 col-md-6">
                <div class="card custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/users.png" class="card-img-top mt-1" alt="Imagen de cliente">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                         <span id="numUsuarios"></span></p>
                        <a href="listausuarios.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <div class="card  custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/clientes.png" class="card-img-top mt-1" alt="Imagen de proveedor">
                    <div class="card-body">
                        <h5 class="card-title">Clientes</h5>
                        <span id="numClientes"></span></p>
                        <a href="verclientes.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <div class="card custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/proveedores.png" class="card-img-top mt-1" alt="Imagen de proveedor">
                    <div class="card-body">
                        <h5 class="card-title">Proveedores</h5>
                        <span id="numProveedores"></span></p>
                        <a href="verproveedores.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
        <div class="card  custom-card text-center mb-2 align-items-center justify-content-center">
          <img src="assets/images/cam.png" class="card-img-top mt-1" alt="Imagen de proveedor">
          <div class="card-body">
        <h5 class="card-title">Productos</h5>
        <span id="numProductos"></span></p>
        <a href="verproductos.php" class="btn">Ver más</a>
    </div>
    </div>
    </div>
	<div class="col-lg-2 col-md-6">
                <div class="card custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/servicio.png" class="card-img-top mt-1" alt="Imagen de proveedor">
                    <div class="card-body">
                        <h5 class="card-title">Servicios</h5>
                        <span id="numServicios"></span></p>
                        <a href="verservicios.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="card custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/requisicion.png" class="card-img-top mt-1" alt="Imagen de cliente">
                    <div class="card-body">
                        <h5 class="card-title">Requisiciones</h5>
                         <span id="numRequisiciones"></span></p>
                        <a href="ver_requisiciones.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>

        </div>

<div class="row">

            <div class="col-lg-2 col-md-6">
                <div class="card custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/cotizacion.png" class="card-img-top mt-1" alt="Imagen de cliente">
                    <div class="card-body">
                        <h5 class="card-title">Cotizaciones</h5>
                         <span id="numCotizaciones"></span></p>
                        <a href="vercotizaciones.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="card custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/compra.png" class="card-img-top mt-1" alt="Imagen de cliente">
                    <div class="card-body">
                        <h5 class="card-title">Compras</h5>
                         <span id="numOrdenesCompra"></span></p>
                        <a href="vercompras.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>
			</div>

</div> <!-- fin del contenido-->
<script languaje= "javascript" src="assets/JS/getCounts.js"></script>

<script>

 document.addEventListener("DOMContentLoaded", function () {
 getCounts(); // Llama a la función cuando la página esté cargada
 setInterval(getCounts, 30000);
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

