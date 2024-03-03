<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link href="assets/css/style.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">

    <div class="container">

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">

        <span class="navbar-toggler-icon"></span>

      </button>

      <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav">

          <li class="nav-item">

            <a class="nav-link" href="index.php">Inicio</a>

          </li>

          <li class="nav-item">

            <a class="nav-link" href="registrarse.php">Registrarse</a>

          </li>

          <li class="nav-item">

            <a class="nav-link" href="sesion.php">Ingresar</a>

          </li>

        </ul>

      </div>

    </div>

  </nav>

<div id="div-contenido" class="container-fluid flex-grow-1">
<div id="containerFormRegistro" class="container">

<div  class="row justify-content-center mb-3">
<div class="col-lg-10 col-md-12 col-sm-12">
<form id="formRegistro" class="rounded shadow">

<h5 class="titulo mb-4">Registrar Usuario</h5>
<div class="mb-3">
  <h6>Datos Personales</h6>
  </div>            
    <div class="row mb-2">
   <div class="col-md-4 mb-2">
  <div class="form-floating">
  <input type="text" class="form-control  rounded-5" id="nombre" name="nombre" placeholder="Nombre" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
    <label for="nombre">Nombre:</label>
  <div class="invalid-feedback">Por favor, ingresa un nombre válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>
<div class="col-md-4 mb-2">
<div class="form-floating">
  <input type="text" class="form-control rounded-5" id="apellidoPaterno" name="apellidoPaterno" placeholder="apellidoPaterno" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
    <label for="apellidoPaterno">Apellido Paterno:</label>
  <div class="invalid-feedback">Por favor, ingresa un apellido válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>

<div class="col-md-4 mb-2">
<div class="form-floating">
   <input type="text" class="form-control rounded-5" id="apellidoMaterno" name="apellidoMaterno" placeholder="apellidoMaterno" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
    <label for="apellidoMaterno">Apellido Paterno:</label>
  <div class="invalid-feedback">Por favor, ingresa un apellido válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>
</div>
<div class="mb-3">
        <h6>Datos de acceso</h6>
    </div>
<div class="row mb-3">
<div class="col-md-6 mb-2">
<div class="form-floating">
  <input type="email" class="form-control rounded-5" id="email" name="email" placeholder="email" required>
    <label for="email">Correo electronico:</label>
  <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido</div>
</div>
</div>
</div>

<div class="row justify-content-between mt-3">
                <div class="col-5">
                    <input type="submit" class="btn btn-primary w-100 rounded-5" value="Registrarse">
                </div>
                <div class="col-5">
                    <input type="reset" class="btn btn-secondary w-100 rounded-5" value="Borrar">
                </div>
            </div>
</form>

    </div>
  </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div id="cardMensaje" class="card mx-auto">
                <div id="registroExito" class="card-body d-none d-flex justify-content-center align-items-center">
                    <div>
                        <div class="row mt-3">
                            <div class="col-lg-12 mb-2 text-center">
                                <h3>¡Registro exitoso! Se le ha enviado un correo electrónico con la contraseña.</h3>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12 text-center">
                                <button id="redireccionarLogin" class="btn btn-primary">Ir al inicio de sesión</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  </div>

<script src="assets/JS/registroUsuario.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</div>
<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formRegistro');
</script>
<script  src="assets/JS/form_validation.js"></script>
 <!-- Pie de página -->
 <?php
require_once 'layout/footer.php';

?>

</body>
</html>