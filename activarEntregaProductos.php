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
$titulo_pagina = "Asignar entrega";
require_once 'layout/header_admin.php';
?>

<body class="d-flex flex-column min-vh-100">
    <?php
    require_once 'layout/menu_admin.php';
    ?>

    <div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->
    <div class="container">
    <h1 class="mb-3 mt-3">Activar entrega de productos</h1>
    <div class="row row-cols-1 row-cols-md-2 g-4" id="solicitudesContainer">
      <!-- Aquí se mostrarán las tarjetas de las solicitudes -->
    </div>
  </div>
<!---- #####-->
  <div id="modalPopup" class="divPopup">
<div class="container-fluit">
<div class="row justify-content-center">
<div class="col-lg-10 col-md-10">
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Datos de la entrega</h4>
        <img src="assets/images/cerrar.png" alt="Cerrar" onclick="cerrarPopup(event)">
    </div>
       
    <div class="card-body">
	
	<form id="formEntrega">
                    <input type="hidden" id="idVenta" name="idVenta" value="">
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
                            <label for="fecha" class="form-label">Fecha de entrega</label>
                            <input type="date" class="form-control" id="fecha" name="fecha"  required>
                            <div class="invalid-feedback">La fecha es obligatoria.</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="detalles" class="form-label">Detalles</label>
                        <textarea class="form-control" id="detalles" rows="3" name="detalles"
                            placeholder="Agrega detalles" required minlength="8" maxlength="150"></textarea>
                        <div class="invalid-feedback">Los detalles deben tener entre 8 y 120 caracteres y solo pueden
                            contener letras y espacios.</div>
                    </div>
              
            <div class="row justify-content-between mb-3">
        <div class="col-5 mt-1 mb-2">
                <button type="button" class="btn btn-danger w-100 rounded-5" onclick="cerrarPopup(event)">Cerrar</button>
                </div>
                <div class="col-5">
                <button type="button" onclick="agregarEntrega(event)" class="btn btn-primary w-100 rounded-5">Enviar</button>
                </div>
              </div>
              </form>
    
 </div> 
 
 </div> 
 </div>     
 </div> 
 </div>     
 </div> 



</div> <!-- fin del contenido-->

  
<!-- Script de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script  src="assets/JS/activarEntregaProductos.js"></script>

<script>
        responsive_topnav();
</script>

<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formEntrega');
</script>
<script src="assets/JS/form_validation.js"></script>



    <!-- Pie de página -->
    <?php
    require_once 'layout/footer2.php';
    ?>
</body>

</html>
