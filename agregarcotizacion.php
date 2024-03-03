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
$titulo_pagina = "Agregar cotización";
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
                        <h5>Formulario Cotización</h5>
                    </div>
                    <div class="card-body">
                    <form id="formCotizacion">
    <div class="mb-3">
        <h6>Datos de la Cotización</h6>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        
        <div class="col-md-4">
            <label for="idCliente" class="form-label">ID Cliente</label>
            <input type="text" class="form-control" id="idCliente" name="idCliente" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>    
        <div class="col-md-4">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="text" class="form-control" id="cantidad" name="cantidad" pattern="\d+(\.\d{1,2})?" title="Ingrese un número entero positivo o un decimal con hasta dos decimales." required>
            <div class="invalid-feedback">Ingrese un número entero positivo o un decimal con hasta dos decimales.</div>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="precioUnitario" class="form-label">Precio Unitario</label>
            <input type="text" class="form-control" id="precioUnitario" name="precioUnitario" pattern="\d+(\.\d{1,2})?" title="Ingrese un número entero positivo o un decimal con hasta dos decimales." required>
            <div class="invalid-feedback">Ingrese un número entero positivo o un decimal con hasta dos decimales.</div>
        </div>
        <div class="col-md-4">
            <label for="importeTotal" class="form-label">Importe Total</label>
            <input type="text" class="form-control" id="importeTotal" name="importeTotal" pattern="\d+(\.\d{1,2})?" title="Ingrese un número entero positivo o un decimal con hasta dos decimales." required>
            <div class="invalid-feedback">Ingrese un número entero positivo o un decimal con hasta dos decimales.</div>
        </div>
    
        <div class="col-md-4">
            <label for="idProducto" class="form-label">ID Producto</label>
            <input type="text" class="form-control" id="idProducto" name="idProducto" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="idServicio" class="form-label">ID Servicio</label>
            <input type="text" class="form-control" id="idServicio" name="idServicio" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>

        <div class="col-md-4">
            <label for="idCatalogoCotizaciones" class="form-label">ID Catálogo Cotizaciones</label>
            <input type="text" class="form-control" id="idCatalogoCotizaciones" name="idCatalogoCotizaciones" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea type="text" class="form-control" rows="3" id="descripcion" name="descripcion" placeholder="Descripción de la cotización" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="8" maxlength="100" required></textarea>
            <div class="invalid-feedback">La descripción debe tener entre 8 y 150 letras y solo puede contener letras y espacios.</div>
        </div>
        <div class="col-md-6">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea type="text" class="form-control" rows="3" id="observaciones" name="observaciones" placeholder="Observaciones de la cotización" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="8" maxlength="100" required></textarea>
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

    <script language="javascript" src="assets/JS/agregarcotizacion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        responsive_topnav();
    </script>
    <!-- Script personalizado para validación en tiempo real -->
    <script>
        // Script personalizado para validación en tiempo real
        var formulario = document.getElementById('formCotizacion');

        formulario.addEventListener('input', function(event) {
            if (event.target.checkValidity()) {
                event.target.classList.remove('is-invalid');
            } else {
                event.target.classList.add('is-invalid');
            }
        });

        formulario.addEventListener('submit', function(event) {
            if (!formulario.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            formulario.classList.add('was-validated');
        });
    </script>
    <!-- Pie de página -->
    <?php
    require_once 'layout/footer2.php';
    ?>
</body>

</html>
