<?php
$titulo_pagina = "Servicio";
require_once 'layout/header_public.php';
?>


<body class="d-flex flex-column min-vh-100">
<?php
require_once 'layout/menu_public.php';
?>


<div id= "div-contenido-servicios" class="container-fluid flex-grow-1 mb-3" style="margin-top: 50px;"> <!-- el contenido  en este div -->

<div id="servicio-1" class="container" style="display: none;">
    <div class="row">
      <div class="col">
      <img src="assets/images/CCtv.jpg" class="img-fluid" alt="Imagen 1">
      </div>
      <div class="col">
      <div>
<h5>Sistemas de circuito cerrado de televisión</h5>
      </div>
      <div class="text-justify">
      <p>Proporcionan vigilancia visual mediante cámaras conectadas a un sistema central.
         Son fundamentales para la seguridad en lugares públicos, empresas y residencias.
</p>
</div>
<div class="text-center">
    <a href="sesion.php" class="btn btn-outline-primary me-4">Ingresar</a>
    <a href="registrarse.php" class="btn btn-outline-primary">Registrarse</a>
</div>

      </div>
    </div>
  </div>
  
  <div id="servicio-2" class="container" style="display: none;">
    <div class="row">
      <div class="col">
      <img src="assets/images/monitoreo.jpg" class="d-block w-100 img-fluid" alt="Imagen 2"> 
      </div>
      <div class="col">
      <div>
      <h5> Centro de Monitoreo</h5>
      </div>
      <div class="text-justify">
      <p>
      Es una instalación centralizada donde se supervisan y controlan múltiples sistemas de seguridad, como CCTV, alarmas de intrusión y
       sistemas de control de acceso. Permite una respuesta rápida ante cualquier incidente.
</p>
</div>
<div class="text-center">
<a href="sesion.php" class="btn btn-outline-primary me-4">Ingresar</a>
    <a href="registrarse.php" class="btn btn-outline-primary">Registrarse</a>
</div>
      </div>
    </div>
  </div>

  <div id="servicio-3" class="container" style="display: none;">
    <div class="row">
      <div class="col">
      <img src="assets/images/acceso.jpg" class="d-block w-100 img-fluid" alt="Imagen 3">
      </div>
      <div class="col">
      <div>
      <h5>Sistemas de control de accesos</h5>
      </div>
      <div class="text-justify">
      <p>
      Permiten regular y gestionar la entrada a un lugar específico mediante tarjetas, códigos o biometría.
       Son esenciales para restringir el acceso a áreas sensibles y garantizar la seguridad.
</p>
</div>
<div class="text-center">
<a href="sesion.php" class="btn btn-outline-primary me-4">Ingresar</a>
    <a href="registrarse.php" class="btn btn-outline-primary">Registrarse</a>
</div>
</div>
    </div>
  </div>

  <div id="servicio-4" class="container" style="display: none;">

    <div class="row">
      <div class="col">
      <img src="assets/images/personal.jpg" class="d-block w-100 img-fluid" alt="Imagen 4">
      </div>
      <div class="col" >
      <div>
      <h5>  Control de personal</h5>
      </div>
      <div class="text-justify">
      <p>
      Herramientas que permiten gestionar la asistencia y el tiempo laboral del personal. Pueden incluir sistemas
       de identificación biométrica o tarjetas de proximidad para un registro preciso y seguro.
</p>
</div>
<div class="text-center">
<a href="sesion.php" class="btn btn-outline-primary me-4">Ingresar</a>
    <a href="registrarse.php" class="btn btn-outline-primary">Registrarse</a>
</div>
      </div>
    </div>
  </div>

  <div id="servicio-5" class="container" style="display: none;">
    <div class="row">
      <div class="col">
      <img src="assets/images/perimetro.jpg" class="d-block w-100 img-fluid" alt="Imagen 5">
      </div>
      <div class="col">
      <div>
      <h5> Control perimetral</h5>
      </div>
      <div class="text-justify">
      <p>
      Consiste en sistemas de seguridad diseñados para proteger los límites físicos de una propiedad o instalación.
       Incluye sensores de movimiento, cercas electrificadas y sistemas de detección de intrusos.
</p>
</div>
<div class="text-center">
<a href="sesion.php" class="btn btn-outline-primary me-4">Ingresar</a>
    <a href="registrarse.php" class="btn btn-outline-primary">Registrarse</a>
</div>
      </div>
    </div>
  </div>

  <div id="servicio-6" class="container" style="display: none;">
    <div class="row">
      <div class="col">
      <img src="assets/images/plataforma.jpg" class="d-block w-100" alt="Imagen 6">
      </div>
      <div class="col">
      <div>
      <h5> Plataformas</h5>
      </div>
      <div class="text-justify">
      <p>
      Se refiere a las soluciones tecnológicas que integran y gestionan todos estos sistemas de seguridad de manera
       centralizada, permitiendo un monitoreo y control eficiente desde cualquier ubicación.
</p>
</div>
<div class="text-center">
    <a href="sesion.php" class="btn btn-outline-primary me-4">Ingresar</a>
    <a href="registrarse.php" class="btn btn-outline-primary">Registrarse</a>
</div>
      </div>
    </div>
  </div>

  

</div> <!-- fin del contenido-->

<script>
  // Función para obtener el parámetro 'id' de la URL
  function obtenerParametroId() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id');
  }

  // Función para mostrar el contenido del servicio según el ID
  function mostrarContenidoServicio() {
    const idServicio = obtenerParametroId();
    const servicio = document.getElementById('servicio-' + idServicio);
    
    if (servicio) {
      servicio.style.display = 'block';
    } else {
      console.log('El servicio solicitado no existe.');
    }
  }

  

  // Llamar a la función al cargar la página
  window.onload = mostrarContenidoServicio;
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

