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
require_once 'layout/menu_user.php';
?>

<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

<!-- mostrar los productos al usuario-->
<div id="CartContainer" class="container mt-3">
<div class="row mt-3">
    <div class="col-lg-12 col-md-12 mt-3">
        <div class="d-flex w-100">
            <input id="searchInput" class="form-control offset-md-2 me-6 w-50" type="search" name="searchInput" placeholder="Buscar producto" aria-label="Search">
            <button class="btn btn-outline-success" onclick="getProductos()"><i class="fas fa-search"></i></button>
            <a href="#" id="cartLink" onclick="displayCartItems()" class="text-decoration-none ms-auto me-4">
    <i class="fas fa-shopping-cart fs-3"></i><span id="cartItemCount" class="badge bg-danger"></span>
</a>

        </div>
    </div>
</div>
    
<div class="row mt-5">
        <h3 class=" mb-4">Productos</h3>
        <div id="cart-items" class="row">
            <!-- Aquí se mostrarán los productos del carrito -->
        </div>
    </div>
	  </div>

 
<div id="modal-compra" class="divPopup">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-md-11">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="text-center mb-0">Datos de la compra</h4>
                        <img src="assets/images/cerrar.png" onclick="cerrarModal(event, 'modal-compra')" alt="Cerrar">
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-6">
                                <h4>Resumen de su compra</h4>
                                <hr class="my-4">
                                <div class="divPopupBody" id="modalContent">
                                    <!-- Aquí van los contenidos dinámicos -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>     

<div id="modalPopup" class="divPopup">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-md-11">
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Datos de la compra</h4>
        
        <img src="assets/images/cerrar.png" onclick="cerrarModal(event, 'modalPopup')" alt="Cerrar">
        </div>
        <div class="card-body">
        <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6">
        <h4>Productos en el carrito</h4>
        <hr class="my-4">
       
        <div class="divPopupBody" id="cartModalContent">
            <!-- Contenido del modal se agregará dinámicamente aquí -->
        </div>
        
    </div>
        <div class="col-lg-6 col-md-6">    
            <h4>Resumen de la compra</h4>
            <h5>Total: <span id="total"></span></h5>
            <h5>IVA: <span id="iva"></span></h5>
            <hr class="my-4">
            <h5>Total con IVA: <span id="total-iva"></span></h5>
            <h6>Envio: Domicilio</h6>
            <hr class="my-4">
            <div class="d-grid gap-2">
            <button type="button" class="btn btn-info btn-sm rounded-pill" id="closePopupFooterBtn" onclick="cerrarModal(event, 'modalPopup')">Continuar comprando</button>
            <button type="button" class="btn btn-danger btn-sm rounded-pill" id="clearCartBtn">Vaciar Carrito</button>
            <button type="button" class="btn btn-primary btn-sm rounded-pill" id="checkoutBtn">Realizar Compra</button>
        </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>



</div> <!-- fin div -->
<!-- Modal para mostrar los detalles del producto -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- Cambié de modal-dialog-centered a modal-lg -->
  <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Detalles del Producto</h5>
                <button type="button" class="btn btn-danger rounded-pill btn-sm" data-bs-dismiss="modal">Cerrar</button>
				</div>
            <div class="modal-body" id="productModalContent">
                <!-- Contenido del modal se agregará dinámicamente aquí -->
            </div>
		</div>
    </div>
</div>



<!-- Nuevo modal para el carrito -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Carrito de Compras</h5>
                <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-dismiss="modal">Cerrar</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row" id="cart-items">
                        <div class="modal-body" id="cartModalContent">
                            <!-- Contenido del modal se agregará dinámicamente aquí -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h4>Resumen de la compra</h4> <!-- Cerraste mal la etiqueta, debe ser h4 -->
                            <h5>Total: <span id="total"></span></h5>
                            <h5>IVA: <span id="iva"></span></h5>
                            <hr class="my-4">
                            <h5>Total con IVA: <span id="total-iva"></span></h5>
                            <h6>Envio: Domicilio</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger btn-sm rounded-pill" id="clearCartBtn">Vaciar Carrito</button>
                <button type="button" class="btn btn-primary btn-sm rounded-pill" id="checkoutBtn">Realizar Compra</button>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script  src="assets/JS/ventaProductos.js"></script>
<script  src="assets/JS/ventaProductos2.js"></script>




<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

