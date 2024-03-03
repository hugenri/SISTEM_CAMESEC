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
$titulo_pagina = "Agregar cliente";
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
  <div class="card-header">
    <h5>Formulario Cliente</h5>
  </div>
  <div class="card-body">
  <form id="formCliente">
  <div class="mb-3">
  <h6>Datos Personales</h6>
  </div>            
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control rounded-5" id="nombre" name="nombre" placeholder="Nombre" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
            <div class="invalid-feedback">Por favor, ingresa un nombre válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" required pattern="[a-zA-Z0-9\s]{3,30}">
            <div class="invalid-feedback">Por favor, ingresa una calle válida (solo letras y números, mínimo 3, máximo 30 caracteres)</div>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
            <label for="estado" class="form-label">Estado</label>
            <select id="estado" name="estado" class="form-control form-select rounded-5" required>
                <option value="">Seleccionar estado</option>
                <!-- Opciones del estado -->
            </select>
            <div class="invalid-feedback">El estado es obligatorio.</div>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
            <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido</div>
        </div>
        <div class="col-md-4">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required pattern="\d{10}">
            <div class="invalid-feedback">Por favor, ingresa un número de teléfono válido (solo números de 10 dígitos)</div>
        </div>
        <div class="col-md-4">
            <label for="informacionContacto" class="form-label">Información de Contacto</label>
            <input type="text" class="form-control" id="informacionContacto" name="informacionContacto" placeholder="Información de Contacto" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,30}">
            <div class="invalid-feedback">Por favor, ingresa información de contacto válida (solo letras, mínimo 3, máximo 30 caracteres)</div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="razonSocial" class="form-label">Razón Social</label>
            <input type="text" class="form-control" id="razonSocial" name="razonSocial" placeholder="Razón Social" required minlength="8" maxlength="30">
            <div class="invalid-feedback">Por favor, ingresa una razón social válida (mínimo 8, máximo 30 caracteres)</div>
        </div>
    </div>

    <div class="mb-3">
        <label for="otrosDetalles" class="form-label">Otros Detalles</label>
        <textarea class="form-control" id="otrosDetalles" rows="3" name="otrosDetalles" placeholder="Agrega detalles adicionales" required minlength="8" maxlength="120" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+"></textarea>
        <div class="invalid-feedback">Por favor, ingresa otros detalles válidos (solo letras, mínimo 8, máximo 120 caracteres)</div>
    </div>

    <button type="submit" class="custom-button btn btn-primary w-40">Enviar</button>
</form>

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>




</div> <!-- fin del contenido-->

<script  src="assets/JS/agregar_cliente.js"></script>
<script  src="assets/JS/select_estados_minicipios.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

responsive_topnav();

</script>

<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formCliente');
</script>
<script src="assets/JS/form_validation.js"></script>

 <!-- Pie de página -->
 <?php

require_once 'layout/footer2.php';

?>

</body>
</html>

