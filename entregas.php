<?php

include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'empleado') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}
?>

<?php
$titulo_pagina = "index";
require_once 'layout/header_empleado.php';
?>


<body class="d-flex flex-column min-vh-100">
<?php
$titulo_pagina = "Home";
require_once 'layout/menu_empleado2.php';
?>


<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->



<div class="row justify-content-center align-items-center mt-4 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Entregas de productos</h3>
        </div>
    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="card">
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

<!--######################################-->

<!-- modelPopup -->
<div id="modalPopup" class="divPopup">
<div class="container-fluit">
<div class="row justify-content-center">
<div class="col-lg-10 col-md-10">
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Datos del Servicio</h4>
        <img src="assets/images/cerrar.png" alt="Cerrar" onclick="cerrarPopup()">
    </div>
       
    <div class="card-body">
    <input type="hidden" id="idServicio" name="idServicio" value="">

    <div class="row mb-2">
        <div class="col-md-12 border-bottom">
        <h5>Servicio: <span id="servicio"></span></h5>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <h5 class="mb-2">Datos del Cliente</h5>
            </div>
        <div class="row mb-2 border-bottom">
        <div class="col-md-6">
            <p>Empresa: <span id="empresa"></span></p>
          </div>
          <div class="col-md-6">
            <p>Contacto: <span id="contacto"></span></p>
            </div>
            </div>
            <div class="row mb-2">
        <div class="col-md-12">
            <h5 class="mb-2">Datos de Contacto</h5>
            </div>
            </div>
            <div class="row mb-2 border-bottom">
           <div class="col-md-6">
            <p>Email: <span id="email"></span></p>
            </div>
            <div class="col-md-6">
            <p>Telefono: <span id="telefono"></span></p>
            </div>
            </div>
        <div class="row border-bottom">
        <div class="col-md-6 mb-2">
            <h5 class="mb-2 mb-2">Direccion del Cliente</h5>
            <p class="p-margen">Calle: <span id="calle"></span></p>
            <p class="p-margen">Numero: <span id="numero"></span></p>
            <p class="p-margen">Colonia: <span id="colonia"></span></p>
            <p class="p-margen">Municipio: <span id="municipio"></span></p>
            <p class="p-margen">Estado: <span id="estado"></span></p>
            </div>
        
            <div class="col-md-6">
            <h5 class="mb-2">Detalles del servicio</h5>
            <textarea class="form-control" id="detalles" rows="4" name="detalles"></textarea>
            </div>
            </div>

        <div class="row mb-2 mt-2">
        <div class="col-md-12">
            <h5 class="mb-2">Productos a Instalar</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre del Producto</th>
                            <th>Cantidad</th>
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

  </div>
  </div>
  </div>
 </div> 
 </div> 
</div> 


</div> <!-- fin del contenido-->

<script  src="assets/JS/entregas.js"></script>


<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

