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
$titulo_pagina = "Agregar servicio";
require_once 'layout/header_admin.php';
?>

<body class="d-flex flex-column min-vh-100">
    <?php
    require_once 'layout/menu_admin.php';
    ?>

    <div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->
    <div class="container">
    <h1 class="mb-3 mt-3">Activar  Servicio a realizar</h1>
    <div class="row row-cols-1 row-cols-md-2 g-4" id="solicitudesContainer">
      <!-- Aquí se mostrarán las tarjetas de las solicitudes -->
    </div>
  </div>

    </div> <!-- fin del contenido-->

  <!-- Modal para llenar los detalles del servicio -->
<div class="modal fade" id="modalServicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Cambié modal-dialog a modal-lg para hacer el modal más ancho -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Servicio a relizar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formServicio">
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
                            <input type="date" class="form-control" id="fecha" name="fecha"  required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="detalles" class="form-label">Detalles del servicio</label>
                        <textarea class="form-control" id="detalles" rows="3" name="detalles"
                            placeholder="Agrega detalles" required minlength="8" maxlength="150"></textarea>
                        <div class="invalid-feedback">Los detalles deben tener entre 8 y 120 caracteres y solo pueden
                            contener letras y espacios.</div>
                    </div>
              
            <div class="row justify-content-between mb-3">
        <div class="col-5 mt-1 mb-2">
                <button type="button" class="btn btn-secondary w-100 rounded-5" data-bs-dismiss="modal">Cerrar</button>
                </div>
                <div class="col-5">
                <button type="button" onclick="agregarServicio(event)" class="btn btn-primary w-100 rounded-5">Guardar Cambios</button>
                </div>
              </div>
              </form>
    </div>
    </div>
</div>

  
<!-- Script de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script  src="assets/JS/agregar_servicio.js"></script>
<script  src="assets/JS/get_servicios.js"></script>

<script>
        responsive_topnav();
</script>

<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formServicio');
</script>
<script src="assets/JS/form_validation.js"></script>



    <!-- Pie de página -->
    <?php
    require_once 'layout/footer2.php';
    ?>
</body>

</html>
