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
$titulo_pagina = "Detalles de las requisiciones";
require_once 'layout/header_admin.php';
?>

<body class="d-flex flex-column min-vh-100">
    <?php
    require_once 'layout/menu_admin.php';
    ?>
    <div id="div-contenido" class="container-fluid flex-grow-1">
        <div class="row justify-content-center align-items-center mt-2 mb-3">
            <div class="col-lg-12 col-md-6 col-sm-12 text-center">
                <h3 id="titulo" class="mb-3">Detalles de las requisiciones</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header text-center">
                    <div class="row justify-content-between align-items-center">
       <div class="col-lg-6 col-md-6 col-sm-6 mt-1 mb-1">
             <div class="input-group">
             <label for="searchInput" class="input-group-text">Filtro de búsqueda:</label>
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaRequisicion')">
                        </div>
                    </div>
                </div>
                    </div>
                    <div class="card-body">
                    
                        <div class="table-responsive">
                            <table id="tablaRequisicion" class="table table-striped table-sm">
                            </table>
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
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- fin del contenido-->

    <div id="popup" class="divPopup">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detalles</h4>
                    <button id="closeButton" class="close-button" onclick='document.getElementById("popup").style.display = "none";'>
                        <img src="assets/images/cerrar.png" alt="Cerrar">
                    </button>
                </div>
                <div class="card-body">
                    <p id="descripcionTextarea" class="text-justify"></p>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="assets/JS/detalles_requisicion.js"></script>
    <script  src="assets/JS/filtrar.js"></script>
    <script  src="assets/JS/consultarDetalles.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            verDetalles(); // Llama a la función cuando la página esté cargada
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
