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
$titulo_pagina = "Ver ordenes de compra";
require_once 'layout/header_admin.php';
?>
<body class="d-flex flex-column min-vh-100">

<?php
require_once 'layout/menu_admin.php';
?>

<div id="div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

    <div class="row justify-content-center align-items-center mt-2 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Lista de ordenes de compras</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 col-md-4">
                        <div class="input-group">
                            <label for="searchInput" class="input-group-text">Filtro de búsqueda:</label>
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar..." oninput="filtrar('tablaOrdenesCompra')">
                        </div>
                    </div>
                    
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaOrdenesCompra" class="table table-striped table-sm">
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
        <h4 class="text-center mb-0">Editar orden de compra</h4>
        <button id="closeButton" class="close-button"
        onclick='document.getElementById("popup").style.display = "none";'>
        <img src="assets/images/cerrar.png" alt="Cerrar">
        </button>
        </div>
        <div class="card-body">
         <form id="form">
         <input type="hidden" id="idOrdenCompra" name="idOrdenCompra">
        <div class="mb-3">
        <h6>Datos de la orden de compra</h6>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
        <label for="idCotizacion" class="form-label">ID Cotizacion</label>
            <input type="text" class="form-control" id="idCotizacion" name="idCotizacion" pattern="[1-9]\d{0,10}" required>
            <div class="invalid-feedback">Ingrese solo números enteros positivos de 1 a 11 dígitos.</div>
            </div>
        
            <div class="col-md-6">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
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
    <div class="row justify-content-between mt-4">
                <div class="col-5">
                    <input type="submit" onclick="actualizar(event)" class="btn btn-primary w-100 rounded-5" value="Enviar">
                </div>
                <div class="col-5">
                    <input type="reset" class="btn btn-secondary w-100 rounded-5" value="Borrar">
                </div>
            </div>
</form>
                    </div>
</div>
     </div>
    </div><!--fin ventana modal -->

   
</div> <!-- fin del contenido-->


<!-- Modal -->
<div class="modal fade" id="tablaModal" tabindex="-1" aria-labelledby="tablaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tablaModalLabel">Cotizaciones aceptadas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body table-responsive">
                <!-- Aquí se mostrará la tabla -->
                <table id="tablaCotizaciones" class="table table-sm">
                    <thead>
                        <tr>
                            <th class="text-nowrap fs-7">ID Cotización</th>
                            <th class="text-nowrap fs-7">Nombre del Servicio</th>
                            <th class="text-nowrap fs-7">Cliente</th>
                            <th class="text-nowrap fs-7">Fecha Cotización</th>
                            <th class="text-nowrap fs-7">Accion</th>

                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se añadirán dinámicamente aquí -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> <!--- ################# -->
<!-- modal popup orden conpra -->
<div id="modalPopup" class="divPopup container-fluid flex-grow-1">
<div class="row justify-content-center">
        <div class="col-lg-11 col-md-11">
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-center mb-0">Orden de compra</h4>
        <button id="closeButton" class="close-button"
        onclick='document.getElementById("modalPopup").style.display = "none";'>
        <img src="assets/images/cerrar.png" alt="Cerrar">
        </button>
        </div>
        <div class="card-body">
        
<div class="container">
  <h2 class="text-center">Detalles de la Orden de Compra</h2>
  <hr class="border-danger my-4 mt-1">
  <div class="row mb-3">
    <div class="col">
      <label for="cliente" class="form-label">Cliente:</label>
      <p id="cliente">Nombre del cliente aquí</p>
    </div>
    <div class="col">
      <label for="email_cliente" class="form-label">Email del Cliente:</label>
      <p id="email_cliente">Email del cliente aquí</p>
    </div>
    <div class="col">
      <label for="telefono_cliente" class="form-label">Teléfono del Cliente:</label>
      <p id="telefono_cliente">Teléfono del cliente aquí</p>
    </div>
  </div>

  <div class="row mb-1">
    <div class="col">
      <label for="servicio" class="form-label">Servicio Ofrecido:</label>
      <p id="servicio">Nombre del servicio aquí</p>
    </div>
  </div>
  <hr class="border-danger my-4">
  <div class="row mb-2">
    <div class="col">
      <h5>Productos para la compra</h5>
    </div>
  </div>
  <div class="table-responsive mb-3">
    <table id="tablaOrdenCompra" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio Unitario</th>
          <th>Cantidad</th>
          <th>Proveedor</th>
          <th>Email del Proveedor</th>
          <th>Teléfono del Proveedor</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td id="nombre_producto"></td>
          <td id="descripcion_producto"></td>
          <td id="precio_unitario"></td>
          <td id="cantidad_comprar"></td>
          <td id="nombre_proveedor"></td>
          <td id="email_proveedor"></td>
          <td id="telefono_proveedor"></td>
        </tr>
        <!-- Puedes agregar más filas para cada producto -->
      </tbody>
    </table>
  </div>
  <hr class="border-danger my-4">

  <div class="row mt-3 mb-3">
        <div class="col-lg-6">
        <div class="row justify-content-between mt-4">
<div class="col-5">
            <button type="button" onclick="cerrarModal(event)" class="btn btn-primary w-100 rounded-5">Cerrar</button>
        </div>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="row justify-content-between mt-4">
        <div class="col-5">
               <button type="button" id="cancelarBtn" onclick="cambiarEstado(event, 'cancelada', this.dataset.id, this.dataset.idCotizacion)" 
		       class="btn btn-danger w-100 rounded-5">Cancelada</button>
                </div>
                <div class="col-5">
			    <button type="button" id="finalizarBtn" onclick="cambiarEstado(event, 'finalizada', this.dataset.id, this.dataset.idCotizacion)"
			   class="btn btn-success w-100 rounded-5">Finalizada</button>
               </div>
                </div>
       </div>

    </div>

</div>
</div>
</div>
</div>
</div>

</div><!-- fin modal popup orden conpra -->
<!-- Script de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script  src="assets/JS/ver_ordenes_compras.js"></script>
<script  src="assets/JS/ver_orden_compra.js"></script>
<script  src="assets/JS/filtrar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        getOrdenesCompra(); // Llama a la función cuando la página esté cargada
    });
</script>
<script>
    responsive_topnav();
</script>

<script>

    // Script personalizado para validación en tiempo real
    var formulario = document.getElementById('form');
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
