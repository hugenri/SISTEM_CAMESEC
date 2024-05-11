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
$titulo_pagina = "Lista de provvedores";
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
            <h3 id="titulo" class="mb-3">Lista de nuevas ordenes de compras</h3>
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
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaProveedor')">
                        </div>
                    </div>
                    
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaProveedor" class="table table-striped table-sm">
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
<!-- Modal Popup Orden de Compra -->
<div id="modalPopup" class="divPopup container-fluid flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-md-11">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="text-center mb-0">Orden de compra</h4>
                    <img src="assets/images/cerrar.png" alt="Cerrar" onclick='document.getElementById("modalPopup").style.display = "none";'>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row justify-content-center mt-4">
                            <div class="col-lg-10 col-md-10">
                                <div class="mb-3">
                                    <h6>Datos Personales</h6>
                                </div>
                                <div class="row mb-3 border-bottom border-danger border-2">
                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Razón Social:</strong> <span id="razonSocial"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Nombre:</strong> <span id="nombreCompleto"></span></p>
                                    </div>
                                    
                                </div>

                                <div class="mb-3">
                                    <h6>Dirección</h6>
                                </div>
                                <div class="row mb-3 border-bottom border-danger border-2">
                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Calle:</strong> <span id="calle"></span></p>
                                        <p class="mb-0"><strong>Número:</strong> <span id="numero"></span></p>
                                        <p"><strong>Colonia:</strong> <span id="colonia"></span></p>
</div>

                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Estado:</strong> <span id="estado"></span></p>
                                        <p class="mb-0"><strong>Municipio:</strong> <span id="municipio"></span></p>
                                        <p><strong>Código Postal:</strong> <span id="cp"></span></p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6>Contacto</h6>
                                </div>
                                <div class="row mb-3 border-bottom border-danger border-2">
                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Correo Electrónico:</strong> <span id="email"></span></p>
                                    
                                        <p"><strong>Teléfono:</strong> <span id="telefono"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Información de Contacto:</strong> <span id="informacionContacto"></span></p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <p><strong>Detalles:</strong> <span id="otrosDetalles"></span></p>
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

<script src="assets/JS/lista_proveedores.js"></script>
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

