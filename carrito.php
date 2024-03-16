

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

<div id="carritoContainer" class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 text-end">
            <a href="#" data-bs-toggle="modal" onclick="displayCartItems()" class="text-decoration-none">
                <i class="fas fa-shopping-cart fs-3"></i>
                <span id="cartItemCount" class="badge bg-danger"></span>
            </a>
        </div>
    </div>
</div>

<!-- mostrar los productos al usuario-->
<div id="CartContainer" class="container mt-5">
<div class="row mt-5">
        <h1>Carrito de Compras</h1>
        <div id="cart-items" class="row">
            <!-- Aquí se mostrarán los productos del carrito -->
        </div>
    </div>
	  </div>
<div id="compraContainer" class="container mt-5" style="display:none;">
  <div class="row">
  <div class="col-lg-12 col-md-12">
    <div id="compraContent">
      <p>contenido del contenedor</p>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                            <h4>Resumen de la compra</h5>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="clearCartBtn">Vaciar Carrito</button>
                <button type="button" class="btn btn-primary" id="checkoutBtn">Realizar Compra</button>
            </div>
        </div>
    </div>
</div>




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

