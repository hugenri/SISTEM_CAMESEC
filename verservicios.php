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
                    <input type="hidden" id="idOrdenCompra" name="idOrdenCompra" value="">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6">
                            <label for="responsable" class="form-label">Responsable</label>
                            <select id="responsable" name="responsable" class="form-control form-select" required>
                                <option value="">Seleccionar responsable</option>
                                <!-- Opciones del estado -->
                            </select>
                            <div class="invalid-feedback">El responsable es obligatorio.</div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="detalles" class="form-label">Detalles del servicio</label>
                        <textarea class="form-control" id="detalles" rows="3" name="detalles"
                            placeholder="Agrega detalles" required minlength="8" maxlength="150"></textarea>
                        <div class="invalid-feedback">Los detalles deben tener entre 8 y 120 caracteres y solo pueden
                            contener letras y espacios.</div>
                    </div>
                    <div class="row mb-3 justify-content-center align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <button type="submit" onclick="actualizar(event)" class="custom-button btn btn-primary w-100">Editar</button>
                    </div>
                 </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> <!-- fin del contenido-->
<!-- Modal -->
<div id="estadoModal" class="divPopup container-fluid flex-grow-1">

<div class="row justify-content-center">
        <div class="col-lg-5 col-md-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="text-center mb-0">Editar estado del servicio</h4>
                    <button id="closeButton" class="close-button"
                            onclick='document.getElementById("estadoModal").style.display = "none";'>
                        <img src="assets/images/cerrar.png" alt="Cerrar">
                    </button>
                </div>
                <div class="card-body">
        <form id="estadoServicioForm">
          <input type="hidden" id="idServicio" name="idServicio">
          <div class="mb-3">
            <label for="estadoSelect" class="form-label">Nuevo Estado:</label>
            <select class="form-select" id="estadoSelect" name="estadoSelect" required>
            <option value="">Seleccionar estado</option>
            <option value="pendiente">Pendiente</option>
              <option value="en curso">en curso</option>
              <option value="completado">Completado</option>
            </select>
          </div>
          <div class="row justify-content-center mt-2">
        <div class="col-lg-6 col-md-6 mb-2">
          <button type="button" class=" custom-button btn btn-danger w-100"   onclick='document.getElementById("estadoModal").style.display = "none";'>Cerrar</button>
          </div>
        <div class="col-lg-6 col-md-6">
          <button type="button" class=" custom-button btn btn-primary w-100" onclick="actualizarEstadoServicio(event)">Guardar Cambios</button>
          </div>
	  </div>
        </form>
        </div>
            </div>
        </div>
    </div>
	  </div>
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
