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
$titulo_pagina = "Agregar servicio";
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
        <h5>Formulario Requisición</h5>
        </div>
        <div class="card-body">
         <form id="formRequisicion">
        <div class="mb-3">
        <h6>Datos de la requisición</h6>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
        <label for="idCotizaciones" class="form-label">ID Cotizacion</label>
            <input type="text" class="form-control" id="idCotizaciones" name="idCotizaciones" pattern="[1-9]\d{0,10}" required>
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
                    <input type="submit" class="btn btn-primary w-100 rounded-5" value="Enviar">
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
                <table id="tablaServicios" class="table">
                    <thead>
                        <tr>
                            <th class="text-nowrap">ID Servicio</th>
                            <th class="text-nowrap">Nombre del Servicio</th>
                            <th class="text-nowrap">Cliente</th>
                            <th class="text-nowrap">Accion</th>

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
</div>


<!-- Script de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script language="javascript" src="assets/JS/crear_requisicion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        responsive_topnav();
    </script>
    <!-- Script personalizado para validación en tiempo real -->
<script>
  var formulario = document.getElementById('formRequisicion');
</script>
<script src="assets/JS/form_validation.js"></script>

<script>

// Función para cargar los datos de servicios desde la API
    function cargarServicios() {
        
        fetch("actions/cargar_datos_cotizacion.php")
            .then(response => response.json())
            .then(data => {
                mostrarTabla(data.dataCotizacion);
                
            })
            .catch(error => console.error('Error al cargar los servicios:', error));
    }

    // Función para mostrar la tabla con los datos de servicios
    function mostrarTabla(datos) {
        var tbody = document.getElementById("tablaServicios").querySelector("tbody");

        // Limpiar contenido previo de la tabla
        tbody.innerHTML = "";

        // Agregar filas con los datos de los servicios
       datos.forEach(function(cotizacion) {
            var row = document.createElement("tr");
            row.innerHTML = `
                      <td class="text-nowrap">${cotizacion.idCotizacion}</td>
                      <td class="text-nowrap">${cotizacion.servicio}</td>
                      <td>${cotizacion.razonSocial}</td>
                      <td><button class="btn-seleccionar btn custom-button btn-primary btn-sm" data-id="${cotizacion.idCotizacion}">Seleccionar</button></td>
                      `;    
                      tbody.appendChild(row);
        });
         // Agregar eventos de clic a los botones de selección
         var btnSeleccionar = document.querySelectorAll('.btn-seleccionar');
        btnSeleccionar.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var nombre = this.getAttribute('data-nombre');
                var cliente = this.getAttribute('data-cliente');
                document.getElementById('idCotizaciones').value = id; // Actualizamos el valor del input con los datos seleccionados
                var tablaModal = bootstrap.Modal.getInstance(document.getElementById('tablaModal'));
                tablaModal.hide(); // Cerramos el modal después de seleccionar
            });
        });
        var tablaModal = new bootstrap.Modal(document.getElementById('tablaModal')); // Inicializar el modal
            tablaModal.show();
    }

    // Evento al hacer clic en el input para cargar los servicios
    document.getElementById("idCotizaciones").addEventListener("click", function() {
        cargarServicios();
    });
</script>
    <!-- Pie de página -->
    <?php
    require_once 'layout/footer2.php';
    ?>
</body>

</html>
