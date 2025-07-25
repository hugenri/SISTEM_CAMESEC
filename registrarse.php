<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <script src="https://www.google.com/recaptcha/api.js?render=6Lcb4OgnAAAAANdIPDiiDfiWcEhW01H4vGXhDIvs"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/index.css" rel="stylesheet">
  <script src="assets/JS/menu.js"></script>
    <link href="assets/css/style_menu.css" rel="stylesheet">
    
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_public.php';
?>

<div id="div-contenido" class="container-fluid flex-grow-1">

<div id="form-container" class="container">
<div class="row justify-content-center mt-4">
  <div class="col-lg-10 col-md-10">
  <div id="containerFormRegistro" class="card">
  <div class="card-header text-center">
    <h5>Formulario de registro</h5>
  </div>
  <div class="card-body">
  <form id="formRegistro">
  <div class="mb-3">
  <h6>Datos Personales</h6>
  </div>
  <input type="hidden" id="recaptchaToken" name="RCtoken"> <!-- campos ocultos del token -->
  <input type="hidden" id="recaptchaAction" name="RCaction">            
    <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
            <div class="invalid-feedback">Por favor, ingresa un nombre válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
        </div>
        <div class="col-md-4 mb-2">
            <label for="apellidoPaterno" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" placeholder="Apellido Paterno" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
            <div class="invalid-feedback">Por favor, ingresa un apellido paterno válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
        </div>
        <div class="col-md-4">
            <label for="apellidoMaterno" class="form-label">Apellido Materno</label>
            <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" placeholder="Apellido Materno" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
            <div class="invalid-feedback">Por favor, ingresa un apellido materno válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
        </div>
    </div>

    <div class="mb-3">
        <h6>Dirección</h6>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" required pattern="[a-zA-Z0-9\s]{3,30}">
            <div class="invalid-feedback">Por favor, ingresa una calle válida (solo letras y números, mínimo 3, máximo 30 caracteres)</div>
        </div>
        <div class="col-md-4 mb-2">
            <label for="numero" class="form-label">Número</label>
            <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" required pattern="\d{1,5}">
            <div class="invalid-feedback">Por favor, ingresa un número válido (solo números, 5 dígitos)</div>
        </div>
        <div class="col-md-4">
            <label for="colonia" class="form-label">Colonia</label>
            <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia" required pattern="[a-zA-Z0-9\s]{3,30}">
            <div class="invalid-feedback">Por favor, ingresa una colonia válida (solo letras y números, mínimo 3, máximo 30 caracteres)</div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <label for="estado" class="form-label">Estado</label>
            <select id="estado" name="estado" class="form-control form-select" required>
                <option value="">Seleccionar estado</option>
                <!-- Opciones del estado -->
            </select>
            <div class="invalid-feedback">El estado es obligatorio.</div>
        </div>
        <div class="col-md-4 mb-2">
            <label for="municipio" class="form-label">Municipio</label>
            <select id="municipio" name="municipio" class="form-control form-select" required>
                <option value="">Seleccionar municipio</option>
                <!-- Opciones del municipio -->
            </select>
            <div class="invalid-feedback">El municipio es obligatorio.</div>
        </div>
        <div class="col-md-4">
            <label for="cp" class="form-label">Código Postal</label>
            <input type="text" class="form-control" id="cp" name="cp" placeholder="Código Postal" required pattern="\d{5}">
            <div class="invalid-feedback">Por favor, ingresa un código postal válido (solo números de 5 dígitos)</div>
        </div>
    </div>

    <div class="mb-3">
        <h6>Contacto</h6>
    </div>
    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
            <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido</div>
        </div>
        <div class="col-md-6">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required pattern="\d{10}">
            <div class="invalid-feedback">Por favor, ingresa un número de teléfono válido (solo números de 10 dígitos)</div>
        </div>
        
    </div>
    <div class="mb-3">
        <h6>Datos de la empresa</h6>
    </div>
    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <label for="razonSocial" class="form-label">Razón Social</label>
            <input type="text" class="form-control" id="razonSocial" name="razonSocial" placeholder="Razón Social" required minlength="8" maxlength="30">
            <div class="invalid-feedback">Por favor, ingresa una razón social válida (mínimo 8, máximo 30 caracteres)</div>
        </div>
        <div class="col-md-6 mb-1">
            <label for="rfc" class="form-label">RFC</label>
            <input type="text" class="form-control" id="rfc" name="rfc" placeholder="Registro Federal de Contribuyentes" required minlength="12" maxlength="13"
            pattern="[A-Za-z0-9]+" title="Por favor, ingresa un RFC válido (solo letras y números)">
        </div>
    </div>

    <div class="row justify-content-between mt-4">
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
            </div>
        </div>




<div id="registroExito" class="container mt-5 d-none">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div id="cardMensaje" class="card mx-auto">
                <div  class="card-body justify-content-center align-items-center">
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

<script  src="assets/JS/select_estados_minicipios.js"></script>
<script src="assets/JS/registro_usuario.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</div>
<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formRegistro');
</script>
<script  src="assets/JS/form_validation.js"></script>
 <!-- Pie de página -->
 
<script>

responsive_topnav();

</script>
 <?php
require_once 'layout/footer.php';

?>

</body>
</html>