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
$titulo_pagina = "Solicitudes de cotizacion";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

    <div class="row justify-content-center align-items-center mt-2 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Solicitudes de cotizacion</h3>
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
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tabla')">

                        </div>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabla" class="table table-striped table-sm">
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
<div id="popup" class="divPopup">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-md-11">
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Cotizar Servico</h4>
        <button id="closeButton" class="close-button"
        onclick='document.getElementById("popup").style.display = "none";'>
        <img src="assets/images/cerrar.png" alt="Cerrar">
        </button>
        </div>
        <div class="card-body">
        <form id="form">
    <input type="hidden" id="id" name="id">

    <div class="row mb-3">
        <div class="col-lg-9 col-md-9 table-responsive">
        <div class="row mb-3">
        <div class="col-md-4">
            <p id="nombreCliente"></p>
        </div>
    </div>

    <div class="mb-3">
        <h6>Agregar productos</h6>
    </div>
        
            <!-- Agregar Nueva Fila de Producto -->
<!-- Botón para abrir el modal -->
<button type="button" class="btn btn-primary" id="btnAbrirModal">Agregar producto</button>

        </div>
        

        <!-- Columna para los totales -->
        <div class="col-lg-3 col-md-3 col-sm-12 ml-5">
            <!-- Totales -->
            <div class="mt-4">
                <h4>Totales</h4>
                <p>Subtotal: $<span class="invoice-sub-total">0.00</span></p>
                <p>Descuento: $<span class="invoice-discount">0.00</span></p>
                <p>IVA: $<span class="invoice-vat">0.00</span></p>
                <p>Total: $<span class="invoice-total">0.00</span></p>
            </div>
            <!-- Botón Crear Factura -->
            <button type="button" class="btn btn-primary mt-3" id="create-invoice">Crear cotización</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                <select id="selectProductos" name="invoice_product[]" class="form-control invoice_product" required>
                            <!-- Opciones-->
                           </select>
                    <div class="form-group col-md-12">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="" min="1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary mt-3" id="btCargarProducto">Aceptar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!-- Agrega aquí el botón de guardar o cualquier otro -->
            </div>
        </div>
    </div>
</div>
<!--  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script  src="assets/JS/cargar_solicitud_cotizaciones.js"></script>
<script  src="assets/JS/filtrar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    responsive_topnav();
</script>


<script>
    // Selecciona el botón para abrir el modal
    let btnAbrirModal = document.getElementById('btnAbrirModal');
    let btCargarProducto = document.getElementById('btCargarProducto');
    // Selecciona el modal
    var modalProducto = document.getElementById('ModalProducto');

    // Agrega un listener al botón para abrir el modal
btnAbrirModal.addEventListener('click', function() {
 
abrirModal('ModalProducto');


    });
    
btCargarProducto.addEventListener('click', function() {  
// Ejemplo de uso para cerrar el modal
agregar_Alista_producto();
cerrarModal('ModalProducto');


});
    // Cierra el modal si se hace clic fuera de él
    modalProducto.addEventListener('click', function(event) {
        if (event.target === modalProducto) {
            modalProducto.classList.remove('show');
            modalProducto.style.display = 'none';
            modalProducto.setAttribute('aria-modal', 'false');
            modalProducto.setAttribute('aria-hidden', 'true');
        }
    });
    // Función para abrir el modal
function abrirModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.classList.add('show');
    modal.style.display = 'block';
    modal.setAttribute('aria-modal', 'true');
    modal.setAttribute('aria-hidden', 'false');
    cargarProductos(); // Llama a cualquier función necesaria al abrir el modal
}

// Función para cerrar el modal
function cerrarModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.classList.remove('show');
    modal.style.display = 'none';
    modal.setAttribute('aria-modal', 'false');
    modal.setAttribute('aria-hidden', 'true');
    // Puedes realizar otras acciones necesarias al cerrar el modal aquí
}

// Función para cerrar el modal si se hace clic fuera de él
function cerrarModalClickExterno(modalId) {
    var modal = document.getElementById(modalId);
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            cerrarModal(modalId);
        }
    });
}


</script>


<!-- Pie de página -->
<?php
require_once 'layout/footer2.php';
?>

</body>
</html>
