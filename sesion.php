<?php
include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
$site = $session->checkAndRedirect();
if($session->getSessionVariable('rol_usuario') == 'admin' || $session->getSessionVariable('rol_usuario') == 'cliente' ){

  header('location:' . $site);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sesion</title>
  <script src="https://www.google.com/recaptcha/api.js?render=6Lcb4OgnAAAAANdIPDiiDfiWcEhW01H4vGXhDIvs"></script>
  <!-- Incluir los estilos de Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/index.css" rel="stylesheet">
  <script src="assets/JS/menu.js"></script>
    <link href="assets/css/style_menu.css" rel="stylesheet">
    </head>

<body class="d-flex flex-column min-vh-100">
<?php
require_once 'layout/menu_public.php';
?>

<div id="div-contenido" class="container-fluid flex-grow-1">

<div id="containerFormSesion" class="container">

<div class="row justify-content-center mb-3">

<div class="col-lg-6 col-md-6 col-sm-12">

 <form id="formLogin" class="rounded shadow">

  <h5 class="titulo mb-4">Iniciar Sesión</h5>

  <div class="row mb-3">
<div class="form-floating col-12">
<input type="hidden" id="recaptchaToken" name="RCtoken"> <!-- campos ocultos del token -->
<input type="hidden" id="recaptchaAction" name="RCaction">
<input type="email" class="form-control rounded-5" id="email" name="email" placeholder="email:" required>
    <label for="email">Correo Electronico:</label>
  <div class="invalid-feedback">Por favor, ingresa un nombre válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>
<div class="row mb-3">
<div class="form-floating col-12">
<input type="password" class="form-control  rounded-5" id="password" name="password" placeholder="Password:" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])[A-Za-z\d\W\S]{8,16}$">
    <label for="password">Password:</label>
  <div class="invalid-feedback">La contraseña debe tener mínimo 8 y máximo 16 caracteres, incluir al menos una letra mayúscula, una letra minúscula, un número y al menos un carácter especial.
</div>
</div>
  </div>
  <div class="form-group row">
    <div class="col-12">
      <input type="submit" class="btn btn-primary w-100 mt-3 mb-3 rounded-5" value="Iniciar Sesión">
	 
    </div>
  </div>
</form>
        </div>
    </div>
</div>
</div>
 <!-- es requerido -->
<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formLogin');
</script>
<script  src="assets/JS/form_validation.js"></script>

<script languaje= "javascript" src="assets/JS/login.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>

responsive_topnav();

</script>
    <!-- Pie de página -->

<?php
require_once 'layout/footer.php';
?>
</body>
</html>