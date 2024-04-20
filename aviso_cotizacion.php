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
        <div id="cotizacionesContainer" class="row mb-2 mt-2">
            <!-- Aquí se mostrarán los avisos de las cotizaciones -->
        </div>
    </div>
</div>

<!-- popup -->
<div id="popup" class="divPopup">
<div id="div-cotizacion" class="container">
<!-- Botón de cerrar -->
        <div class="d-flex justify-content-end mt-3">
        <img id="closeButton" class="close-button" src="assets/images/cerrar.png" alt="Cerrar" onclick='document.getElementById("popup").style.display = "none";' style="cursor: pointer;">

        </div>
	<div class="row">
	<div class="col-lg-12 col-md-12 mb-3">
    <h5>Datos del Cliente</h5>
    <div class="row">
        <div class="col-md-6">
            <p id="nombre" class="mb-0"><strong>Nombre:</strong> Nombre del cliente aquí</p>
        </div>
        <div class="col-md-6">
            <p id="razonSocial" class="mb-0"><strong>Razón Social:</strong> Razón social del cliente aquí</p>
        </div>
    </div>
	<hr style="margin-top: 10px; margin-bottom: 10px;">
</div>

			<div class="col-lg-8 col-md-8">
			<div class="row">
				<div class="col-md-12">
				<h5>Datos de la Cotización</h5>
				     <p id="fecha"><strong>Fecha:</strong></p>
                    <p id="servicio"><strong>Servicio:</strong></p>
                    <p id="observaciones"><strong>Observaciones:</strong></p>
                    <p id="descripcion"><strong>Descripción:</strong></p>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-12">
				<h5>Datos del Producto</h5>
                    <div  id="ItemsContent">
     <!--  agregará dinámicamente aquí los productos -->
     </div>
				</div>
				
			</div>
		</div>
		<div class="col-lg-4 col-md-4" style="border: 1px solid black; padding: 10px;">
			<div class="row">
				<div class="col-lg-12 col-md-12">
				<h5>Costo del servicio</h5>
				 <p id="costoInstalacion"><strong>Costo de Instalación:</strong></p>
                <p id="subtotal"><strong>Subtotal:</strong></p>
                <p id="descuento"><strong>Descuento:</strong></p>
                <p id="iva"><strong>IVA:</strong></p>
                <p id="total"><strong>Total:</strong></p>
				<!-- Línea divisoria -->
				<hr style="margin-top: 10px; margin-bottom: 10px;">
				<div class="col-md-12">
    <h5>Acciones de Cotización</h5>
    <div id="accionesCotizacion" class="d-flex justify-content-start">
    <button type="button" class="btn btn-primary btn-sm rounded me-3" onclick="getEstatus(event, idCotizacion, 'aceptada')">Aceptar cotización</button>
    <button type="button" class="btn btn-primary btn-sm rounded" onclick="getEstatus(event, idCotizacion, 'rechasada')">Rechazar cotización</button>
</div>


</div>

				</div>
				
			</div>
		</div>
	</div>
</div>


</div><!-- fin popup -->

</div> <!-- fin de div id="div-contenido" -->




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script  src="assets/JS/mostrar_cotizacion.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>





<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

