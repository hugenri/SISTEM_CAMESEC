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
$titulo_pagina = "Lista de Facturas";
require_once 'layout/header_admin.php';
?>

<body class="d-flex flex-column min-vh-100">
    <?php
    require_once 'layout/menu_admin.php';
    ?>
    <div id="div-contenido" class="container-fluid flex-grow-1">
   
    
<div class="row justify-content-center align-items-center mt-4 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Facturas</h3>
        </div>
    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-lg-10 col-md-10 col-sm-10">
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
                        <div class="text-center">
                       <h4 id="NoData"></h4> <!-- mensaje si no hay datos que mostrar -->
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- modelPopup -->
<div id="modalPopup" class="divPopup">
<div class="container-fluit">
<div class="row justify-content-center">
<div class="col-lg-10 col-md-10">
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Datos de la factura</h4>
        <img src="assets/images/cerrar.png" alt="Cerrar" onclick="cerrarPopup()">
    </div>
       
    <div class="card-body">
    <input type="hidden" id="idFactura" name="idFactura" value="">

    <div class="row mb-2">
        <div class="col-md-9 border-bottom">
        <p>Servicio: <span id="servicio"></span></p>
        </div>
        <div class="col-md-3 border-bottom">
        <p  class="mb-0">ID factura: <span id="idFactura"></span></>
        <p>Fecha factura: <span id="fechaFactura"></span></p>

        </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <h5 class="mb-2">Datos del Cliente</h5>
            </div>
        <div class="row mb-2 border-bottom">
        <div class="col-md-8">
            <p  class="mb-0">Empresa: <span id="empresa"></span></p>
            <p  class="mb-0">RFC: <span id="rfc"></span></p>
            <p  class="mb-0">Nombre: <span id="nombreCliente"></span></p>
            <p  class="mb-0">Email: <span id="email"></span></p>
            <p>Telefono: <span id="telefono"></span></p>
            </div>
            <div class="col-md-4 mb-2">
            <p class="p-margen mb-0">Calle: <span id="calle"></span></p>
            <p class="p-margen mb-0">Numero: <span id="numero"></span></p>
            <p class="p-margen mb-0">Colonia: <span id="colonia"></span></p>
            <p class="p-margen mb-0">Municipio: <span id="municipio"></span></p>
            <p class="p-margen">Estado: <span id="estado"></span></p>
            </div>
            </div>

        <div class="row mb-2 mt-2">
        <div class="col-md-12">
            <h5 class="mb-2">Productos del Servicio</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre del Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            
                        </tr>
                    </thead>
                    <tbody id="datosProducto">
                        <!-- Aquí se insertarán dinámicamente los datos del producto -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-end">
    <div class="col-md-6 mb-2">
        <p class="text-right mb-0">Total Productos: <span id="totalProductos"></span></p>
        <p class="p-margen text-right mb-0">Costo Instalacion: <span id="instalacion"></span></p>
        <p class="p-margen text-right mb-0">Subtotal: <span id="subtotal"></span></p>
        <p class="p-margen text-right mb-0">IVA: <span id="iva"></span></p>
        <p class="p-margen text-right mb-0">Descuento: <span id="descuento"></span></p>
        <p class="p-margen text-right mb-0">Total: <span id="total"></span></p>
    </div>
</div>


            

<div class="row">
        <div class="col-md-12">
            <h5 class="mb-2">Indicar el estodo de la factura</h5>
            </div>
            </div>

<div class="row">
        <div class="col-md-12">
        <div class="row justify-content-between mt-4 mb-3">
                <div class="col-5">
                <button onclick="actualizarEstatusFactura('terminada')" class="btn btn-primary btn-sm w-100 rounded-5">Factura Terminada</button>
                </div>
                <div class="col-5">
                    <botton  onclick="actualizarEstatusFactura('cacelada')" class="btn btn-primary btn-sm w-100 rounded-5">Factura Cancelada</button>
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


</div>   <!-- #########-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script  src="assets/JS/ver_facturas.js"></script>
<script src="assets/JS/filtrar.js"></script>

            
            <script>
                responsive_topnav();
            </script>
            <!-- Pie de página -->
            <?php
            require_once 'layout/footer2.php';
            ?>
</body>
</html>
        