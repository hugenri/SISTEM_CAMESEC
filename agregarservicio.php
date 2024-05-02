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
                        <h5>Formulario Servicio</h5>
                    </div>
                    <div class="card-body">
                        <form id="formServicio">
                            <div class="mb-3">
                                <h6>Datos del servicio</h6>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required minlength="5" maxlength="30" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" required>
                                    <div class="invalid-feedback">El nombre debe tener entre 5 y 30 letras.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="disponibilidad" class="form-label">Disponibilidad</label>
                                    <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" placeholder="Disponibilidad del servicio" minlength="5" maxlength="30" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" required>
                                    <div class="invalid-feedback">El nombre debe tener entre 5 y 30 letras.</div>
                                </div>
                               
                            </div>
                            <div class="row mb-3">
                                 <div class="col-md-12">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea type="text" class="form-control" rows="3" id="descripcion" name="descripcion" placeholder="Descripción del servicio"  pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="8" maxlength="150" required></textarea>
                                    <div class="invalid-feedback">La descripción debe tener entre 8 y 150 caracteres y
                                      solo puede contener letras y espacios.
                                    </div>
                                </div>
                              </div>
                              
                            <div class="row justify-content-between mt-4">
                <div class="col-5">
                    <input type="submit" class="btn btn-primary w-100 rounded-5" value="Registrarse">
                </div>
                <div class="col-5">
                    <input type="reset" class="btn btn-secondary w-100 rounded-5" value="Borrar">
                </div>
            </div>                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- fin del contenido-->

    <script language="javascript" src="assets/JS/agregar_servicio.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        responsive_topnav();
    </script>
    <!-- Script personalizado para validación en tiempo real -->
    <script>
        // Script personalizado para validación en tiempo real
        var formulario = document.getElementById('formServicio');

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
