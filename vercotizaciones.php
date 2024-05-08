<?php
include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
    $site = $session->checkAndRedirect();
    header('location:' . $site);
}
?>

<?php
$titulo_pagina = "Ver cotizaciones";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

    <div class="row justify-content-center align-items-center mt-2 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Lista de cotizaciones</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                <div class="row justify-content-between align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-6 mt-1 mb-1">
                        <div class="input-group">
                            <label for="searchInput" class="input-group-text">Filtro de búsqueda:</label>
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaCotizaciones')">

                        </div>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaCotizaciones" class="table table-striped table-sm">
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

<!-- popup -->
<div id="modalPopup" class="divPopup">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-md-11">
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Cotizar Servicio</h4>
        <button id="closeButton" class="close-button"
        onclick="cerrarPopup()">
        <img src="assets/images/cerrar.png" alt="Cerrar">
        </button>
        </div>
        <div class="card-body">
        <form id="formCotizacion">
    <input type="hidden" id="idSolicitudCotizacion" name="idSolicitudCotizacion">
    <input type="hidden" id="idCotizacion" name="idCotizacion">
    <input type="hidden" id="idCliente" name="idCliente">
    <div class="row mb-3">
        <div class="col-lg-9 col-md-9">
    <div class="row mb-3">
        <div class="col-lg-6 col-md-6 mb-2">
        <p id="nombreCliente"></p>
        </div>
        
        <div class="col-lg-6 col-md-6">
            <label for="fecha" class="form-label">Fecha:</label>
            <input type="date" id="fecha" name="fecha" class="form-control" required>
        </div>   
    </div>
    <div class="row mb-3">
        <div class=" col-lg-6 col-md-6 mb-2">
            <label for="costoInstalacion" class="form-label">Costo de Instalación:</label>
            <input type="number" id="costoInstalacion" name="costoInstalacion" placeholder="$" class="form-control" step="1" min="1" required>            <div class="invalid-feedback">Por favor ingresa un costo de instalación válido.</div>
        </div>

        <div class="col-lg-6  col-md-6">
            <label for="descuento" class="form-label">Descuento:</label>
            <input type="number" id="descuento" name="descuento" placeholder="% porcentaje" class="form-control" step="1" min="1" max="100">            <div class="invalid-feedback">Por favor ingresa un valor de descuento válido.</div>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea type="text" class="form-control" rows="3" id="descripcion" name="descripcion" placeholder="Descripción de la cotización" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="8" maxlength="100" required></textarea>
            <div class="invalid-feedback">La descripción debe tener entre 8 y 150 letras y solo puede contener letras y espacios.</div>
        </div>
        <div class="col-md-6">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea type="text" class="form-control" rows="3" id="observaciones" name="observaciones" placeholder="Observaciones de la cotización" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="8" maxlength="100" required></textarea>
            <div class="invalid-feedback">Las observaciones deben tener entre 8 y 100 letras y solo pueden contener letras y espacios.</div>
        </div>
    </div>



    <div class="mb-3">
        <h6>Agregar productos</h6>
    </div>
   
      <div class="row" id="cart-items">
      <div class="col-lg-12 col-md-12">
      <div class="modal-body" id="ItemsContent">
     <!-- Contenido del modal se agregará dinámicamente aquí -->
     </div>
     </div>
</div>
            <!-- Agregar Nueva Fila de Producto -->
<!-- Botón para abrir el modal -->
<button type="button" class="btn btn-primary mt-2 mb-2" id="btnAbrirModal">Agregar producto</button>

        </div>
        

        <!-- Columna para los totales -->
<div class="col-lg-3 col-md-3 col-sm-12 ml-5" style="border: 1px solid black; padding: 10px;">
    <!-- Totales -->
    <div class="mt-4">
    <h4>Cantidades de la cotización</h4>
       <p id="costo-instalacion">Instalación: $<span id="costoInstalacion" class="invoice-instalacion">0.00</span></p>
        <p id="porcentaje-descuento">Descuento: %<span class="invoice-porcentajeDescuento">0</span></p>
        <p id="Productos">Productos $<span class="invoice-prroductos">0.00</span></p>
        <h4>Totales</h4>
        <p id="subTotal">Subtotal: $<span class="invoice-sub-total">0.00</span></p>
        <p id="totaldescuento">Descuento: $<span class="invoice-discount">0.00</span></p>
        <p id="iva">IVA: $<span class="invoice-vat">0.00</span></p>
        <p id="total-iva">Total: $<span class="invoice-total">0.00</span></p>
    </div>
    <!-- Línea divisoria -->
    <hr style="margin-top: 10px; margin-bottom: 10px;">
    <!-- Botón Crear Factura -->
    <button type="button" class="btn btn-primary mt-3" id="create-invoice" onclick="actualizarCotizacion(event)">Actualizar cotización</button>
</div>
 </div>
</form>

    </div>
    </div>
   </div>
    </div>
    </div>
    
    </div>
</div> <!-- fin del contenido-->

<div class="modal fade" id="ModalProducto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Producto</h5>
                
            </div>
            <div class="modal-body">
                <div class="form-row">
                <select id="selectProductos" name="invoice_product" class="form-control invoice_product" required>
                            <!-- Opciones-->
                           </select>
                    <div class="form-group col-md-12">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="" min="1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btCargarProducto">Aceptar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModal('ModalProducto')">Cerrar</button>
            <!-- Agrega aquí el botón de guardar o cualquier otro -->
        </div>
        </div>
    </div>
</div>
<script  src="assets/JS/form_validation.js"></script>
<script  src="assets/JS/ver_cotizaciones.js"></script>
<script  src="assets/JS/actualizar_cotizacion.js"></script>
<script  src="assets/JS/filtrar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        getCotizaciones(); // Llama a la función cuando la página esté cargada
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
