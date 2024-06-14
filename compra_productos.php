<?php

include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'compras') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}
?>

<?php
$titulo_pagina = "Nuevas Ordenes de Compras";
require_once 'layout/header_compras.php';
?>


<body class="d-flex flex-column min-vh-100">
<?php
$titulo_pagina = "Home";
require_once 'layout/menu_compras.php';
?>


<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

<div class="row justify-content-center align-items-center mt-2 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Lista de nuevas  compras</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 col-md-4">
                        <div class="input-group">
                            <label for="searchInput" class="input-group-text">Filtro de búsqueda:</label>
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaOrdenesCompra')">
                        </div>
                    </div>
                    
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaOrdenesCompra" class="table table-striped table-sm">
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
<!-- modal popup orden conpra -->
<div id="modalPopup" class="divPopup container-fluid flex-grow-1">
<div class="row justify-content-center">
        <div class="col-lg-11 col-md-11">
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Orden de compra</h4>
    
        <img src="assets/images/cerrar.png" alt="Cerrar"  onclick='document.getElementById("modalPopup").style.display = "none";'>
        </div>
        <div class="card-body">
        
<div class="container">
  <h2 class="text-center">Detalles de la Orden de Compra</h2>
  <hr class="border-danger my-4 mt-1">
  <div class="row mb-3">
    <div class="col">
      <label for="cliente" class="form-label">Cliente:</label>
      <p id="cliente">Nombre del cliente aquí</p>
    </div>
    <div class="col">
      <label for="email_cliente" class="form-label">Email del Cliente:</label>
      <p id="email_cliente">Email del cliente aquí</p>
    </div>
    <div class="col">
      <label for="telefono_cliente" class="form-label">Teléfono del Cliente:</label>
      <p id="telefono_cliente">Teléfono del cliente aquí</p>
    </div>
  </div>

  <div class="row mb-1">
    <div class="col">
      <label for="servicio" class="form-label">Servicio Ofrecido:</label>
      <p id="servicio">Nombre del servicio aquí</p>
    </div>
  </div>
  <hr class="border-danger my-4">
  <div class="row mb-2">
    <div class="col">
      <h5>Productos para la compra</h5>
    </div>
  </div>
  <div class="table-responsive mb-3">
    <table id="tablaOrdenCompra" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio Unitario</th>
          <th>Cantidad</th>
          <th>Proveedor</th>
          <th>Email del Proveedor</th>
          <th>Teléfono del Proveedor</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td id="nombre_producto"></td>
          <td id="descripcion_producto"></td>
          <td id="precio_unitario"></td>
          <td id="cantidad_comprar"></td>
          <td id="nombre_proveedor"></td>
          <td id="email_proveedor"></td>
          <td id="telefono_proveedor"></td>
        </tr>
        <!-- Puedes agregar más filas para cada producto -->
      </tbody>
    </table>
  </div>
  <hr class="border-danger my-4">

  <div class="row mt-3 mb-3" justify-content-between mt-4>
        <div class="col-lg-6">
       
            <button type="button" onclick="cerrarModal(event)" class="btn btn-danger mb-3 w-100 rounded-5">Cerrar</button>
        </div>
        
        <div class="col-lg-6">
       
			    <button type="button" id="finalizarBtn" onclick="cambiarEstado(event, this.dataset.idVenta)"
			   class="btn btn-primary w-100 rounded-5">Finalizada</button>
                </div>
       </div>

    </div>

</div>
</div>
</div>
</div>
</div>

</div> <!-- fin del contenido-->

<script src="assets/JS/compra_productos.js"></script>
<script  src="assets/JS/filtrar.js"></script>
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

