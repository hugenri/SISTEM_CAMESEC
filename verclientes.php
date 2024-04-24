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
$titulo_pagina = "Ver clientes";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

<div class="row justify-content-center align-items-center mt-2 mb-3">
   <div class="col-lg-12 col-md-6 col-sm-12 text-center">
<h3 id="titulo" class="mb-3">Lista de Clientes</h3>
            
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
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaCliente')">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 d-flex justify-content-end mt-1 mb-1"> 
                   <a id="pdfLink" class="btn btn-primary btn-md custom-button" href="#"onclick="generarInformePDF('reporteclientespdf.js')">Generar informe PDF</a>
                    </div>
                </div>
       </div>
        <div class="card-body mt-3">
    <div class="table-responsive">
<table id="tablaCliente" class="table table-striped table-sm">
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
</div>

<!-- popup -->
<div id="popup" class="divPopup">
  
<div class="row justify-content-center">
<div class="col-lg-10 col-md-10">
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Editar Usuario</h4>
        <button id="closeButton" class="close-button" onclick='document.getElementById("popup").style.display = "none";'>
            <img src="assets/images/cerrar.png" alt="Cerrar">
        </button>
    </div>
        <div class="card-body">
    <form id="formUpdateCliente">
        <!-- Campo oculto para el ID -->
      <input type="hidden" id="id" name="id">
      <div class="mb-3">
      <h6>Datos Personales</h6>
      </div>
      <div class="row mb-3">
      <div class="col-md-4">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
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
            <select id="estado" name="estado" class="form-control form-select" required>
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
        <div class="col-md-6">
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

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="razonSocial" class="form-label">Razón Social</label>
            <input type="text" class="form-control" id="razonSocial" name="razonSocial" placeholder="Razón Social" required minlength="8" maxlength="30">
            <div class="invalid-feedback">Por favor, ingresa una razón social válida (mínimo 8, máximo 30 caracteres)</div>
        </div>
    </div>
 <!--#######################-->
    
 <div class="row justify-content-between mt-4 mb-3">
                <div class="col-5">
                <button type="submit"  onclick="actualizar(event)" class="btn btn-primary w-100 rounded-5">Editar</button>
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
</div>

</div> <!-- fin del contenido-->

<script src="assets/JS/ver_clientes.js"></script>
<script src="assets/JS/filtrar.js"></script>
<script  src="assets/JS/reporte_pdf.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            getClients(); // Llama a la función cuando la página esté cargada
        });
    </script>
<script>
responsive_topnav();
</script>
<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formUpdateCliente');
</script>
<script src="assets/JS/form_validation.js"></script>

 <!-- Pie de página -->
 <?php
require_once 'layout/footer2.php';
?>

</body>
</html>
