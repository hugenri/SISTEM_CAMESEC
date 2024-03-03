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
$titulo_pagina = "Ver servicios";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

    <div class="row justify-content-center align-items-center mt-2 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Lista de servicios</h3>
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
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaServicio')">

                        </div>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaServicio" class="table table-striped table-sm">
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

    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="text-center mb-0">Editar Producto</h4>
                    <button id="closeButton" class="close-button"
                            onclick='document.getElementById("popup").style.display = "none";'>
                        <img src="assets/images/cerrar.png" alt="Cerrar">
                    </button>
                </div>
                <div class="card-body">
                <form id="formUpdateServicio">
                    <!-- Campo oculto para el ID -->
                    <input type="hidden" id="id" name="id">
                            <div class="mb-3">
                                <h6>Datos del servicio</h6>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required minlength="5" maxlength="30" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" required>
                                    <div class="invalid-feedback">El nombre debe tener entre 5 y 30 letras.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="disponibilidad" class="form-label">Disponibilidad</label>
                                    <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" placeholder="Disponibilidad del servicio" minlength="5" maxlength="30" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" required>
                                    <div class="invalid-feedback">El nombre debe tener entre 5 y 30 letras.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="tarifa" class="form-label">Tarifa</label>
                                    <input type="text" class="form-control" id="tarifa" name="tarifa" placeholder="Tarifa del servicio" pattern="^\d{1,6}(\.\d{1,2})?$" required>
                                    <div class="invalid-feedback">Ingresa una tarifa válida (máx. 6 dígitos, opcionalmente con hasta 2 decimales).</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                 <div class="col-md-12">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea type="text" class="form-control" rows="3" id="descripcion" name="descripcion" placeholder="Descripción del servicio"  pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="8" maxlength="150" required></textarea>
                                    <div class="invalid-feedback">La descripción debe tener entre 8 y 150 caracteres y
                                      solo puede contener letras y espacios.
                                    </div>
                                </div>
                              </div>
                              <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="idCotizacion" class="form-label">ID Cotización</label>
                                    <input type="text" class="form-control" id="idCotizacion" name="idCotizacion" placeholder="ID Cotización" pattern="^\d{1,10}$" maxlength="10" required>
                                    <div class="invalid-feedback">Ingresa una numero  (mínimo 1 y máximo  10 dígitos).</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="idRequisicion" class="form-label">ID Requisición</label>
                                    <input type="text" class="form-control" id="idRequisicion" name="idRequisicion" placeholder="ID Requisición" pattern="^\d{1,10}$" maxlength="10" required>
                                    <div class="invalid-feedback">Ingresa una numero  (mínimo 1 y máximo  10 dígitos).</div>
                                </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="idOrdenCompra" class="form-label">ID Orden de Compra</label>
                                <input type="text" class="form-control" id="idOrdenCompra" name="idOrdenCompra" placeholder="ID Orden de Compra" pattern="^\d{1,10}$" maxlength="10" required>
                                <div class="invalid-feedback">Ingresa una numero  (mínimo 1 y máximo  10 dígitos).</div>
                            </div>
                            </div>
                            <button type="submit" onclick="actualizar(event)" class="custom-button btn btn-primary w-40">Editar</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> <!-- fin del contenido-->

<script src="assets/JS/ver_servicios.js"></script>
<script  src="assets/JS/filtrar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        getServicios(); // Llama a la función cuando la página esté cargada
    });
</script>
<script>
    responsive_topnav();
</script>

<script>

    // Script personalizado para validación en tiempo real
    var formulario = document.getElementById('formUpdateServicio');
    var enviarButton = document.getElementById('EButton'); // Agrega un ID al botón de envío

    formulario.addEventListener('input', function (event) {
        if (event.target.checkValidity()) {
            event.target.classList.remove('is-invalid');
        } else {
            event.target.classList.add('is-invalid');
        }
    });

    function submitForm(event) {
        if (formulario.checkValidity()) {
            // El formulario es válido
            formulario.classList.add('was-validated');
            // Llama a la función de actualización
            actualizar(event);
        } else {
            // El formulario no es válido, se puede mostrar un mensaje de error o realizar acciones adicionales
            event.preventDefault();
            event.stopPropagation();
            alert('Por favor, completa todos los campos correctamente antes de enviar el formulario.');
        }
    }

</script>
<!-- Pie de página -->

<?php
require_once 'layout/footer2.php';
?>

</body>
</html>
