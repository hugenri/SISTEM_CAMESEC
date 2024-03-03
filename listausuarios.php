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
$titulo_pagina = "Lista de usuarios";
require_once 'layout/header_admin.php';
?>

<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>


<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

<div class="row justify-content-center align-items-center mt-2 mb-3">

   <div class="col-lg-12 col-md-6 col-sm-12 text-center">

<h3 id="titulo" class="mb-3">Lista de Usuarios</h3>
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
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaUsuarios')">

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 d-flex justify-content-end mt-1 mb-1"> 
                   <a id="pdfLink" class="btn btn-primary btn-md custom-button" href="#" onclick="generarInformePDF('reporteUsuariosPDF.php')">Generar informe PDF</a>
                    </div>
                </div>

       </div>

        <div class="card-body">

    <div class="table-responsive">

<table id="tablaUsuarios" class="table table-striped table-sm">

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

<div class="col-lg-10 col-md-10 col-sm-10">

        <div class="card">

        <div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="text-center mb-0">Editar Usuario</h4>

        <button id="closeButton" class="close-button" onclick='document.getElementById("popup").style.display = "none";'>

            <img src="assets/images/cerrar.png" alt="Cerrar">

        </button>

    </div>

          <div class="card-body">
            <form id="formUpdate">
              <!-- Campo oculto para el ID -->
              <input type="hidden" id="id" name="id">
              <div>
              <h6>Datos Personales</h6>
  </div>            
    <div class="row mb-2">
        <div class="col-md-4 mb-2">
<input type="hidden" id="recaptchaToken" name="RCtoken"> <!-- campos ocultos del token -->
<input type="hidden" id="recaptchaAction" name="RCaction">
<div class="form-floating">
  <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
  <label for="nombre">Nombre:</label>
  <div class="invalid-feedback">Por favor, ingresa un nombre válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>
<div class="col-md-4 mb-2">
<div class="form-floating">
  <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
  <label for="apellidoPaterno">Apellido Paterno:</label>
  <div class="invalid-feedback">Por favor, ingresa un apellido paterno válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>

<div class="col-md-4 mb-2">
<div class="form-floating">
  <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}">
  <label for="apellidoMaterno">Apellido Materno:</label>
  <div class="invalid-feedback">Por favor, ingresa un apellido materno válido (solo letras, mínimo 3, máximo 20 caracteres)</div>
</div>
</div>
</div>
<div class="mb-3">
        <h6>Datos de acceso</h6>
    </div>
<div class="row mb-2">
<div class="col-md-12 mb-2">
<div class="form-floating">
  <input type="email" class="form-control" id="email" name="email" required>
  <label for="email">Correo Electrónico:</label>
  <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido</div>
</div>
</div>
</div>
<div class="mb-3">
  <h6>Rol de usuario</h6>
</div>
<div class="row mb-2">
<div class="col-md-12 mb-2">
<select class="form-select form-control mb-3" name="rol" id="rol">
  <option value="admin">Admin</option>
  <option value="usuario">Usuario</option>
   <option value="empleado">Empleado</option>
   </select>
</div>
</div>    
    <button type="submit" onclick="actualizar(event)" class="custom-button btn btn-primary w-40" >Editar</button>
            </form>
          </div>
        </div>
      </div>
      </div>

      </div>


</div> <!-- fin del contenido-->
<script  src="assets/JS/listausuarios.js"></script>
<script  src="assets/JS/filtrar.js"></script>
<script  src="assets/JS/reporte_pdf.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
        document.addEventListener("DOMContentLoaded", function () {
            verUsuarios(); // Llama a la función cuando la página esté cargada
        });

    </script>

<script>
responsive_topnav();
</script>
<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formUpdate');
</script>
<script  src="assets/JS/form_validation.js"></script>
 <!-- Pie de página -->
 <?php
require_once 'layout/footer2.php';

?>
</body>
</html>

