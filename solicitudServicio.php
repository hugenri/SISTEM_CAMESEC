<?php
/*
include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'usuario' && $session->getSessionVariable('rol_usuario') != 'empleado') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}
*/
?>

<?php
$titulo_pagina = "Home";
require_once 'layout/header_user.php';
?>


<body class="d-flex flex-column min-vh-100">
<?php
$titulo_pagina = "Home";
require_once 'layout/menu_user.php';
?>


<div id= "div-contenido" class="container-fluid flex-grow-1"> <!-- el contenido  en este div -->

<div id="cardContainer" class="container">
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-12 text-center">
        
        <h3 class="card-title">Cotiza nuestros servicios</h3>
      
        </div>
        </div>
          </div>

<div class="container">
    <div class="row">
        <!-- Tarjeta para Sistemas de Circuito Cerrado de Televisión -->
        <div class="col-lg-6 col-md-6 mt-3">
            <div class="card text-center ServiciobackColor" onclick="showDetails('CCtv', 'CCtv.jpg');" style="cursor: pointer;">
                <div class="card-body">
                    <h5 class="card-title">Sistemas de circuito cerrado de televisión</h5>
                    <p class="card-text">solicita tu cotizacion</p>
                </div>
            </div>
        </div>
        <!-- Tarjeta para plataformas -->
        <div class="col-lg-6 col-md-6 mt-3">
            <div class="card text-center ServiciobackColor" onclick="showDetails('Plataformas', 'plataforma.jpg');" style="cursor: pointer;">
                <div class="card-body">
                    <h5 class="card-title">Plataformas</h5>
                    <p class="card-text">solicita tu cotizacion</p>
                </div>
            </div>
        </div>
        
        <!-- Tarjeta para Centro de Monitoreo -->
        <div class="col-lg-6 col-md-6 mt-3">
            <div class="card text-center ServiciobackColor" onclick="showDetails('Centro de Monitoreo', 'monitoreo2.png');" style="cursor: pointer;">
                <div class="card-body">
                    <h5 class="card-title">Centro de Monitoreo</h5>
                    <p class="card-text">solicita tu cotizacion</p>
                </div>
            </div>
        </div>
        <!-- Tarjeta para Sistemas de control de accesos -->
        <div class="col-lg-6 col-md-6 mt-3">
            <div class="card text-center ServiciobackColor" onclick="showDetails('Sistemas de control de accesos', 'personal.jpg');" style="cursor: pointer;">
                <div class="card-body">
                    <h5 class="card-title">Sistemas de control de accesos</h5>
                    <p class="card-text">solicita tu cotizacion</p>
                </div>
            </div>
        </div>
        
        <!-- Tarjeta para Centro de Monitoreo -->
        <div class="col-lg-6 col-md-6 mt-3 ">
            <div class="card text-center ServiciobackColor" onclick="showDetails('Control perimetral', 'perimetro.jpg');" style="cursor: pointer;">
                <div class="card-body">
                    <h5 class="card-title">Control perimetral</h5>
                    <p class="card-text">solicita tu cotizacion</p>
                </div>
            </div>
        </div>
</div>    
</div>
</div>





<div id="detalle-servicio" class="container mt-5" style="display: none;">
  <div class="row">
    <div class="col-lg-6 mb-3">
      <img  id= "imagen-servicio" src="" alt="Imagen del servicio" class="img-fluid rounded-3 shadow-lg">
    </div>
    <div class="col-lg-6">
      <h4 class="mb-3">Servicio a cotizar: <span id="servicio-seleccionado"></span></h4>
      <p class="lead">Un especialista de la empresa se pondrá en contacto contigo para hacer una visita a tu empresa o realizar una video llamada y así tomar los requerimientos para realizar tu cotización del servicio.</p>
      <div class="d-grid gap-2 mt-2">
        <button id="solicitar-cotizacion" class="btn btn-primary btn-lg rounded-pill">Solicitar Cotización</button>
        <button id="cancelar" class="btn btn-danger  btn-lg rounded-pill">Cancelar</button>
      </div>
    </div>
  </div>
</div>


</div> <!-- fin del contenido-->
<script>
    // Función para mostrar los detalles del servicio
    function showDetails(servicio, imagenServicio) {
        // Ocultar el contenedor de las tarjetas
        document.getElementById('cardContainer').style.display = 'none';
        // Mostrar el detalle del servicio seleccionado
        document.getElementById('detalle-servicio').style.display = 'block';
        // Actualizar el nombre del servicio seleccionado
        document.getElementById('servicio-seleccionado').innerText = servicio;
        // Actualizar el atributo src de la imagen
        let src = 'assets/images/' + imagenServicio;
  let defaultImage = "assets/images/CCtv.jpg";
  document.getElementById('imagen-servicio').src = imagenServicio ? src : defaultImage;
    }

    // Si se hace clic en cancelar, volver a mostrar las tarjetas y ocultar el detalle del servicio
    document.getElementById('cancelar').addEventListener('click', function() {
        document.getElementById('cardContainer').style.display = 'block';
        document.getElementById('detalle-servicio').style.display = 'none';
    });

    // Puedes agregar la lógica para el botón de "Solicitar Cotización" aquí

</script>


<script>

responsive_topnav();

</script>



 <!-- Pie de página -->
<?php 
require_once 'layout/footer_user.php';
?>
</body>

</html>

