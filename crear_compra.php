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
$titulo_pagina = "Crear orden de compra ";
require_once 'layout/header_admin.php';
?>

<body class="d-flex flex-column min-vh-100">
    <?php
    require_once 'layout/menu_admin.php';
    ?>

    <div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

        <div class="row justify-content-center mt-4">
            <div class="col-lg-10 col-md-10">
                <div class="card">
                    <div class="card-header text-center">
        <h5>Formulario Orden de compra</h5>
        </div>
        <div class="card-body">
    <form id="formCompra">
    <div class="mb-3">
        <h6>Datos de orden de compra</h6>
    </div>
    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        
        <div class="col-md-6 ">
            <label for="idProveedor" class="form-label">ID Proveedor</label>
            <input type="text" class="form-control" id="idProveedor" name="idProveedor" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>    
        
        </div>
        <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <label for="idRequisicion" class="form-label">ID Requisición</label>
            <input type="text" class="form-control" id="idRequisicion" name="idRequisicion" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>

        <div class="col-md-6">
            <label for="idCatalogoOrdenCompra" class="form-label">ID Catalogo Orden Compra</label>
            <input type="text" class="form-control" id="idCatalogoOrdenCompra" name="idCatalogoOrdenCompra" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>
        </div>
        <div class="row mb-3">
        
        <div class="col-md-12">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea type="text" class="form-control" rows="3" id="observaciones" name="observaciones" placeholder="Observaciones de la orden de compra" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="8" maxlength="100" required></textarea>
            <div class="invalid-feedback">Las observaciones deben tener entre 8 y 100 letras y solo pueden contener letras y espacios.</div>
        </div>
    </div>
    <button type="submit" class="custom-button btn btn-primary w-40">Enviar</button>
</form>
</div>
</div>
            </div>
        </div>
    </div> <!-- fin del contenido-->

    <script language="javascript" src="assets/JS/crearcompra.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        responsive_topnav();
    </script>
    <!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formCompra');
</script>
<script src="assets/JS/form_validation.js"></script>
    <!-- Pie de página -->
    <?php
    require_once 'layout/footer2.php';
    ?>
</body>

</html>
