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

<div class="row mb-3 mt-3">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div class="text-center">
                  
        </div>
        <div>
</div>
<div id="containerNotificacionSolicitudes" class="col-md-4" style="display: none;">
      <div class="card card-notificacion">
        
        <div class="card-body card-body-notificacion" id="dropdown-card">
        <span style="display: inline;">
    <h6 class="card-title me-2" style="display: inline;">Solicitudes para cotización</h6>
    <img src="assets/images/ctz.png" class="me-2" alt="Imagen de cliente" style="display: inline;">
    <span id="notification-count"></span>
</span>

          <!-- Dropdown oculto -->
          <ul class="dropdown-menu" id="notification-menu">
            
          </ul>
        </div>
      </div>
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
                    <img src="assets/images/cotizacion.png" class="card-img-top mt-1" alt="Imagen de cliente">
                    <div class="card-body">
                        <h5 class="card-title">Cotizaciones</h5>
                         <span id="numCotizaciones"></span></p>
                        <a href="vercotizaciones.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>
          
        </div>

<div class="row">

            
            <div class="col-lg-2 col-md-6">
                <div class="card custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/compra.png" class="card-img-top mt-1" alt="Imagen de cliente">
                    <div class="card-body">
                        <h5 class="card-title">Compras</h5>
                         <span id="numOrdenesCompra"></span></p>
                        <a href="ver_ordenes_compras.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="card custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/facturas.png" class="card-img-top mt-1" alt="Imagen de cliente">
                    <div class="card-body">
                        <h5 class="card-title">Facturas</h5>
                         <span id="numFacturas"></span></p>
                        <a href="facturas.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <div class="card custom-card text-center mb-2 align-items-center justify-content-center">
                    <img src="assets/images/sales.png" class="card-img-top mt-1" alt="Imagen de cliente">
                    <div class="card-body">
                        <h5 class="card-title">Ventas</h5>
                         <span id="numVentas"></span></p>
                        <a href="ver_ventas.php" class="btn">Ver más</a>
                    </div>
                </div>
            </div>

			</div>

</div> <!-- fin del contenido-->
<script  src="assets/JS/getCounts.js"></script>
<script  src="assets/JS/notificacionesCotizacion.js"></script>

<script>

 document.addEventListener("DOMContentLoaded", function () {
 getCounts(); // Llama a la función cuando la página esté cargada
 notificaciorSolicitidesCotizacion();
 setInterval(getCounts, 60000);
 setInterval(notificaciorSolicitidesCotizacion, 50000);
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

