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
$titulo_pagina = "Ver productos";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

    <div class="row justify-content-center align-items-center mt-2 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Lista de productos</h3>
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
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaProducto')">
                        </div>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaProducto" class="table table-striped table-sm">
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
                    <h4 class="text-center mb-0">Editar Producto</h4>
                    <button id="closeButton" class="close-button"
                            onclick='document.getElementById("popup").style.display = "none";'>
                        <img src="assets/images/cerrar.png" alt="Cerrar">
                    </button>
                </div>
                <div class="card-body">
                    <form id="formUpdateProducto" enctype="multipart/form-data">
                        <!-- Campo oculto para el ID -->
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="name_image" name="name_image">
                        <div class="mb-3">
                            <h6>Datos del producto</h6>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                       placeholder="Nombre" required minlength="6" maxlength="30">
                                <div class="invalid-feedback">El nombre debe tener entre 6 y 30 caracteres.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="text" class="form-control" id="precio" name="precio"
                                       placeholder="Precio del producto" required
                                       pattern="^\d{1,12}(\.\d{1,2})?$">
                                <div class="invalid-feedback">Ingresa un precio válido (máx. 12 dígitos,
                                    opcionalmente con hasta 2 decimales).
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                       placeholder="Stock" min="1"
                                       onkeydown="return event.keyCode === 38 || event.keyCode === 40;" required>
                                <div class="invalid-feedback">Ingresa una cantidad válida de stock (mín. 1).
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción del producto</label>
                            <textarea class="form-control" id="descripcion" rows="3" name="descripcion"
                                      placeholder="Agrega detalles" required minlength="8" maxlength="120"
                                      pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+"></textarea>
                            <div class="invalid-feedback">La descripción debe tener entre 8 y 120 caracteres y
                                solo puede contener letras y espacios.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="imagen" class="form-label">Selecciona una imagen:</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        </div>
                        <div id="mensajeError" class="alert alert-danger mb-3" style="display:none;"></div>

                        <button type="button" id="EButton" onclick="submitForm(event)"
                                class="custom-button btn btn-primary w-40">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> <!-- fin del contenido-->

<script src="assets/JS/ver_productos.js"></script>
<script  src="assets/JS/filtrar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        getProductos(); // Llama a la función cuando la página esté cargada
    });
</script>
<script>
    responsive_topnav();
</script>

<script>

    // Script personalizado para validación en tiempo real
    var formulario = document.getElementById('formUpdateProducto');
    var enviarButton = document.getElementById('EButton'); // Agrega un ID al botón de envío

    formulario.addEventListener('input', function (event) {
        if (event.target.checkValidity()) {
            event.target.classList.remove('is-invalid');
        } else {
            event.target.classList.add('is-invalid');
        }
    });

    function submitForm(event) {
        if (formulario.checkValidity()) {
            // El formulario es válido
            formulario.classList.add('was-validated');
            // Llama a la función de actualización
            actualizar(event);
        } else {
            // El formulario no es válido, se puede mostrar un mensaje de error o realizar acciones adicionales
            event.preventDefault();
            event.stopPropagation();
            alert('Por favor, completa todos los campos correctamente antes de enviar el formulario.');
        }
    }

</script>
<!-- Pie de página -->

<?php
require_once 'layout/footer2.php';
?>

</body>
</html>
