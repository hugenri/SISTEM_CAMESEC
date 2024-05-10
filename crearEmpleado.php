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
$titulo_pagina = "Crear Usuario Empleado";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php

require_once 'layout/menu_admin.php';

?>



<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->



<div class="row justify-content-center align-items-center mt-3 mb-3">

   <div class="col-lg-12 col-md-6 col-sm-12 text-center">



<h3 class="mt-3">Crear usuario empleado</h3>

            

        </div>

    </div>

<div class="row justify-content-center">
<div class="col-lg-10 col-md-12 col-sm-10">
<div class="card">
<div class="card-header text-center">

<h4>Formulario Empleado</h4>
</div>
<div class="card-body">
<form id="form">
<div class="mb-3">
  <h6>Datos Personales</h6>
  </div>            
    <div class="row mb-2">
        <div class="col-md-4 mb-2">

<div class="form-floating">
  <input type="text" class="form-control rounded-5" id="nombre" name="nombre" required placeholder="Nombre:" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
  <label for="nombre">Nombre:</label>
  <div class="invalid-feedback">Por favor, ingresa un nombre válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>
<div class="col-md-4 mb-2">
<div class="form-floating">
  <input type="text" class="form-control rounded-5" id="apellidoPaterno" name="apellidoPaterno" required placeholder="" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
  <label for="apellidoPaterno">Apellido Paterno:</label>
  <div class="invalid-feedback">Por favor, ingresa un apellido paterno válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>

<div class="col-md-4 mb-2">
<div class="form-floating">
  <input type="text" class="form-control rounded-5" id="apellidoMaterno" name="apellidoMaterno" required placeholder="" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
  <label for="apellidoMaterno">Apellido Materno:</label>
  <div class="invalid-feedback">Por favor, ingresa un apellido materno válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>
</div>
<div class="mb-3">
        <h6>Datos de acceso</h6>
    </div>
<div class="row mb-2">
<div class="col-md-6 mb-2">
<div class="form-floating">
  <input type="email" class="form-control rounded-5" id="email" name="email" placeholder="" required>
  <label for="email">Correo Electrónico:</label>
  <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido</div>
</div>
</div>
<div class="col-md-6 mb-2">
    <div class="form-floating">
        <select class="form-select rounded-5" id="rolUsuario" name="rolUsuario" required>
            <option value="">Selecciona el rol</option>
            <option value="empleado">Empleado</option>
            <option value="compras">Compras</option>
        </select>
        <div class="invalid-feedback">Por favor, selecciona un el rol de usuario</div>
    </div>
</div>
</div>

<div class="row mb-2">
<div class="col-md-6 mb-2">
  <div class="form-floating mb-3">
  <input type="password" class="form-control rounded-5" id="password" name="password" placeholder="" required
         pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])[A-Za-z\d\W\S]{8,16}$">
  <label for="password">Contraseña:</label>
  <div class="invalid-feedback">
    La contraseña debe tener mínimo 8 y máximo 16 caracteres, incluir al menos una letra mayúscula, una letra minúscula, un número y al menos un carácter especial.
  </div>
</div>
</div>
<div class="col-md-6 mb-2">
<div class="form-floating">
  <input type="password" class="form-control rounded-5" id="passwordC" name="passwordC" required placeholder="">
  <label for="passwordC">Confirmar Contraseña:</label>
  <div id="passwordMismatchFeedback" class="invalid-feedback">
    La confirmación de contraseña es obligatoria
  </div>
</div>
</div>

</div>


<div class="row justify-content-between mt-4">
                <div class="col-5">
                    <input type="submit" class="btn btn-primary w-100 rounded-5" value="Registrar Cliente">
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
<script languaje= "javascript" src="assets/JS/crearEmpleado.js"></script>

<script>
responsive_topnav();
</script>

<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('form');
</script>
<script  src="assets/JS/form_validation2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <!-- Pie de página -->
 <?php
require_once 'layout/footer2.php';

?>

</body>

</html>

