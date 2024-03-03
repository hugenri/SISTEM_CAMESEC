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
$titulo_pagina = "Ver servicios";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

    <div class="row justify-content-center align-items-center mt-2 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Lista de Requisiciones</h3>
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
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaRequisicion')">

                        </div>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaRequisicion" class="table table-striped table-sm">
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

<!-- popup -->
<div id="popup" class="divPopup">

    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10">
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Editar Requisición</h4>
        <button id="closeButton" class="close-button"
        onclick='document.getElementById("popup").style.display = "none";'>
        <img src="assets/images/cerrar.png" alt="Cerrar">
        </button>
        </div>
        <div class="card-body">
        <form id="formUpdateRequisicion">
        <!-- Campo oculto para el ID -->
        <input type="hidden" id="id" name="id">
        <div class="mb-3">
        <h6>Datos de la requisición</h6>
        </div>
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        
        <div class="col-md-4">
    <label for="cantidad" class="form-label">Cantidad</label>
    <input type="text" class="form-control" id="cantidad" name="cantidad" pattern="\d+(\.\d{1,2})?" title="Ingrese un número entero positivo o un decimal con hasta dos decimales." required>
    <div class="invalid-feedback">Ingrese un número entero positivo o un decimal con hasta dos decimales.</div>
</div>

    
        <div class="col-md-4">
            <label for="precioUnitario" class="form-label">Precio Unitario</label>
            <input type="text" class="form-control" id="precioUnitario" name="precioUnitario" pattern="\d+(\.\d{1,2})?" title="Ingrese un número entero positivo o un decimal con hasta dos decimales." require>
            <div class="invalid-feedback">Ingrese un número entero positivo o un decimal con hasta dos decimales.</div>
        </div>
        </div>
    <div class="row mb-3">
    <div class="col-md-4">
            <label for="importeTotal" class="form-label">Importe Total</label>
            <input type="text" class="form-control" id="importeTotal" name="importeTotal" pattern="\d+(\.\d{1,2})?" title="Ingrese un número entero positivo o un decimal con hasta dos decimales." require>
            <div class="invalid-feedback">Ingrese un número entero positivo o un decimal con hasta dos decimales.</div>
        </div>
        
        <div class="col-md-4">
            <label for="idProveedor" class="form-label">ID Proveedor</label>
            <input type="text" class="form-control" id="idProveedor" name="idProveedor"pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>

        <div class="col-md-4">
            <label for="idServicio" class="form-label">ID Servicio</label>
            <input type="text" class="form-control" id="idServicio" name="idServicio" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>
        </div>
    <div class="row mb-3">
    <div class="col-md-4">
            <label for="idConcepto" class="form-label">ID Concepto</label>
            <input type="text" class="form-control" id="idConcepto" name="idConcepto" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>
        <div class="col-md-4">
            <label for="idCotizaciones" class="form-label">ID Cotizaciones</label>
            <input type="text" class="form-control" id="idCotizaciones" name="idCotizaciones" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>
        <div class="col-md-4">
            <label for="idProducto" class="form-label">ID Producto</label>
            <input type="text" class="form-control" id="idProducto" name="idProducto" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>
       
    </div>
    <div class="row mb-3">
    <div class="col-md-4">
            <label for="idCliente" class="form-label">ID Cliente</label>
    <input type="text" class="form-control" id="idCliente" name="idCliente" pattern="[1-9]\d{0,10}" required>
    <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>        
</div>
  <div class="col-md-4">
    <label for="idCatalogoRequisicion" class="form-label">ID Catálogo Requisición</label>
    <input type="text" class="form-control" id="idCatalogoRequisicion" name="idCatalogoRequisicion" pattern="[1-9]\d{0,10}" required>
    <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
</div>

    </div>
    <div class="row mb-3">
         <div class="col-md-6">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea type="text" class="form-control" rows="3" id="descripcion" name="descripcion" placeholder="Descripción del servicio"  pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="8" maxlength="100" required></textarea>
        <div class="invalid-feedback">La descripción debe tener entre 8 y 150 letras y
                                      solo puede contener letras y espacios.</div>
    </div>
    <div class="col-md-6">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea type="text" class="form-control" rows="3" id="observaciones" name="observaciones" placeholder="Observaciones del servicio"  pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="8" maxlength="100" required></textarea>
        <div class="invalid-feedback">La observaciones debe tener entre 8 y 100 letras y
                                      solo puede contener letras y espacios.</div>
    </div>
    </div>
    <button type="submit" onclick="actualizar(event)" class="custom-button btn btn-primary w-40">Editar</button>
</form>
                </div>
            </div>
        </div>
    </div>
</div> <!-- fin del contenido-->

<script  src="assets/JS/ver_requisiciones.js"></script>
<script  src="assets/JS/filtrar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        getRequisiciones(); // Llama a la función cuando la página esté cargada
    });
</script>
<script>
    responsive_topnav();
</script>

<!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formUpdateRequisicion');
</script>
<script src="assets/JS/form_validation.js"></script>
<!-- Pie de página -->

<?php
require_once 'layout/footer2.php';
?>

</body>
</html>
