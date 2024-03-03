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
$titulo_pagina = "Restablecer password";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->
<div class="row justify-content-center align-items-center mt-2 mb-3">
   <div class="col-lg-12 col-md-6 col-sm-12 text-center">

   <h3 class="mb-3">Restablecer contraseña de usuario</h3>
        </div>

    </div>

<div class="row justify-content-center">
<div class="col-lg-6 col-md-8 col-sm-8">
<div class="card">
<div class="card-header text-center">
    <h4>Restablecer contraseña</h4>
</div>
<div class="card-body">
<form id="formRP">
    <div class="form-floating mb-3">
<input type="email" class="form-control" id="email" name="email" required>
  <label for="email">Correo Electrónico:</label>
  <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido</div>
</div>

<div class="form-floating mb-3">
<input type="password" class="form-control" id="password" name="password" required
         pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])[A-Za-z\d\W\S]{8,16}$">
  <label for="password">Contraseña:</label>
  <div class="invalid-feedback">
    La contraseña debe tener mínimo 8 y máximo 16 caracteres, incluir al menos una letra mayúscula, una letra minúscula, un número y al menos un carácter especial.
  </div>
 </div>
 <div class="form-floating mb-3">
 <input type="password" class="form-control" id="passwordC" name="passwordC" required>
  <label for="passwordC">Confirmar Contraseña:</label>
  <div id="passwordMismatchFeedback" class="invalid-feedback">
    La confirmación de contraseña es obligatoria
  </div>
 </div>

<button type="submit" class="custom-button btn btn-primary w-100">Enviar</button>
</form>
 </div>
</div> 
 </div>
</div>
</div>

</div> <!-- fin del contenido-->

<script src="assets/JS/restablecerpassword.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

responsive_topnav();

</script>

<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formRP');
</script>
<script  src="assets/JS/form_validation2.js"></script>

 <!-- Pie de página -->

 <?php

require_once 'layout/footer2.php';

?>



</body>

</html>

