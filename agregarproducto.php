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
$titulo_pagina = "Agregar producto";
require_once 'layout/header_admin.php';
?>

<body class="d-flex flex-column min-vh-100">
<?php
require_once 'layout/menu_admin.php';
?>

<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->


 <div class="row justify-content-center mt-4">
    <div class="col-lg-10 col-md-10">
    <div class="card">
    <div class="card-header text-center">
    <h5>Formulario Producto</h5>
    </div>
   <div class="card-body">
   <form id="formProducto" enctype="multipart/form-data">        
      <div class="mb-3">
                <h6>Datos del producto</h6>
              </div>
              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required minlength="6" maxlength="25">
                  <div class="invalid-feedback">El nombre debe tener entre 6 y 30 caracteres.</div>
                </div>
                <div class="col-md-4">
                  <label for="precio" class="form-label">Precio</label>
                  <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio del producto" required pattern="^\d{1,12}(\.\d{1,2})?$">
                  <div class="invalid-feedback">Ingresa un precio válido (máx. 12 dígitos, opcionalmente con hasta 2 decimales).</div>
                </div>
                <div class="col-md-4">
                  <label for="stock" class="form-label">Stock</label>
                  <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" min="1" onkeydown="return event.keyCode === 38 || event.keyCode === 40;" required>
                  <div class="invalid-feedback">Ingresa una cantidad válida de stock (mín. 1).</div>
                </div>
              </div>
              <div class="mb-3">
    <label for="descripcion" class="form-label">Descripción del producto</label>
    <textarea class="form-control" id="descripcion" rows="3" name="descripcion" placeholder="Agrega detalles" required minlength="8" maxlength="150" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+"></textarea>
    <div class="invalid-feedback">La descripción debe tener entre 8 y 120 caracteres y solo puede contener letras y espacios.</div>
</div>

              <div class="mb-3">
              <label for="imagen" class="form-label">Selecciona una imagen:</label>
        <input type="file" class="form-control" name="image" id="image" accept="image/*" required> 
        <div class="invalid-feedback">Selecciona una imagen.</div>
      </div>  
      <!--#####################-->

      <div class="row justify-content-between mt-4 mb-3">
                <div class="col-5">
                <input type="submit" class="btn btn-primary w-100 rounded-5" value="Registrar Producto">
                </div>
                <div class="col-5">
                    <input type="reset" class="btn btn-secondary w-100 rounded-5" value="Borrar">
                </div>
            </div>
    </form>

    </div>
    </div>
    </div>
    </div>
    </div>

</div> <!-- fin del contenido-->
<script languaje= "javascript" src="assets/JS/agregar_producto.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
responsive_topnav();
</script>
<!-- Script personalizado para validación en tiempo real -->
<script>
 
  
  // Script personalizado para validación en tiempo real
  var formulario = document.getElementById('formProducto');
  
  formulario.addEventListener('input', function (event) {
    if (event.target.checkValidity()) {
      event.target.classList.remove('is-invalid');
    } else {
      event.target.classList.add('is-invalid');
    }
  });
  
  formulario.addEventListener('submit', function (event) {
    if (!formulario.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
  
    formulario.classList.add('was-validated');
  });

</script>
 <!-- Pie de página -->

 <?php

require_once 'layout/footer2.php';

?>

</body>

</html>

