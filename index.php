<?php
$titulo_pagina = "Inicio";
require_once 'layout/header_public.php';
?>
    

</head>
<body>
<?php
require_once 'layout/menu_public.php';
?>
    </nav>
  <div id="containerCarousel" class="container mt-5">
    <div class="row justify-content-center">
      <div id="carrusel" class="col-8">
        <div id="slider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2900">
          <!-- Indicadores -->
          <ol class="carousel-indicators">
            <li data-bs-target="#slider" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#slider" data-bs-slide-to="1"></li>
            <li data-bs-target="#slider" data-bs-slide-to="2"></li>
			<li data-bs-target="#slider" data-bs-slide-to="3"></li>
            <li data-bs-target="#slider" data-bs-slide-to="4"></li>
            <li data-bs-target="#slider" data-bs-slide-to="5"></li>

          </ol>
          <!-- Slides -->
          <div class="carousel-inner">
            <div class="carousel-item active">
              <a href="servicio.php?id=1">
               <img src="assets/images/CCtv.jpg" class="d-block w-100 img-fluid" alt="Imagen 1">
              </a>
            </div>
            <div class="carousel-item">
              <a href="servicio.php?id=2">
               <img src="assets/images/monitoreo.jpg" class="d-block w-100 img-fluid" alt="Imagen 2"> 
             </a>
            </div>
            <div class="carousel-item">
              <a href="servicio.php?id=3">
                <img src="assets/images/acceso.jpg" class="d-block w-100 img-fluid" alt="Imagen 3">
              </a>
            </div>
			<div class="carousel-item">
              <a href="servicio.php?id=4">
                <img src="assets/images/personal.jpg" class="d-block w-100 img-fluid" alt="Imagen 4">
              </a>
            </div>
			<div class="carousel-item">
              <a href="servicio.php?id=5">
                <img src="assets/images/perimetro.jpg" class="d-block w-100 img-fluid" alt="Imagen 5">
              </a>
            </div>
			<div class="carousel-item">
                <a href="servicio.php?id=6">
                <img src="assets/images/plataforma.jpg" class="d-block w-100" alt="Imagen 6">
              </a>
            </div>
          </div>
          <!-- Controles -->
          <a class="carousel-control-prev" href="#slider" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </a>
          <a class="carousel-control-next" href="#slider" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="container mb-1 mt-5">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
  <h3 class="mb-1">Explora Nuestro Catálogo de Servicios</h3>
  </div>
        </div>
        </div>
        <div class="container mb-3">
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 mt-4 mb-2">
      <div class="card justify-content-center">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 col-md-6 mb-3">
              <img src="assets/images/CCtv.jpg" class="img-fluid fixed-image" alt="Imagen 1">
            </div>
            <div class="col-lg-6 col-md-6 d-flex flex-column justify-content-between">
              <div>
                <h5>Sistemas de circuito cerrado de televisión</h5>
              </div>
              <div class="text-justify">
                <p>Proporcionan vigilancia visual mediante cámaras conectadas a un sistema central. Son fundamentales para la seguridad en lugares públicos, empresas y residencias.</p>
              </div>
              <a href="servicio.php?id=2" class="card-link">Sistema de CCTV</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 mt-4 mb-2">
      <div class="card justify-content-center">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 col-md-6 mb-3">
              <img src="assets/images/monitoreo.jpg" class="img-fluid fixed-image" alt="Imagen 1">
            </div>
            <div class="col-lg-6 col-md-6 d-flex flex-column justify-content-between">
              <div>
                <h5 >Centro de Monitoreo</h5>
              </div>
              <div class="text-justify">
                <p>Es una instalación centralizada donde se supervisan y controlan múltiples sistemas de seguridad, como CCTV, alarmas de intrusión y sistemas de control de acceso. Permite una respuesta rápida ante cualquier incidente.</p>
              </div>
              <a href="servicio.php?id=1" class="card-link">Centro de Monitoreo</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 mt-4 mb-2">
      <div class="card justify-content-center">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 col-md-6 mb-3">
              <img src="assets/images/acceso.jpg" class="img-fluid fixed-image" alt="Imagen 1">
            </div>
            <div class="col-lg-6 col-md-6 d-flex flex-column justify-content-between">
              <div>
                <h5>Sistemas de control de accesos</h5>
              </div>
              <div class="text-justify">
                <p>Permiten regular y gestionar la entrada a un lugar específico mediante tarjetas, códigos o biometría. Son esenciales para restringir el acceso a áreas sensibles y garantizar la seguridad.</p>
              </div>
              <a href="servicio.php?id=3" class="card-link">Sistemas de control de accesos</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 mt-4 mb-2">
      <div class="card justify-content-center">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 col-md-6 mb-3">
              <img src="assets/images/personal.jpg" class="img-fluid fixed-image" alt="Imagen 1">
            </div>
            <div class="col-lg-6 col-md-6 d-flex flex-column justify-content-between">
              <div>
                <h5>Control de personal</h5>
              </div>
              <div class="text-justify">
                <p>Herramientas que permiten gestionar la asistencia y el tiempo laboral del personal. Pueden incluir sistemas de identificación biométrica o tarjetas de proximidad para un registro preciso y seguro.</p>
              </div>
              <a href="servicio.php?id=4" class="card-link">Control de personal</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 mt-4 mb-2">
      <div class="card justify-content-center">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 col-md-6 mb-3">
              <img src="assets/images/perimetro.jpg" class="img-fluid fixed-image" alt="Imagen 1">
            </div>
            <div class="col-lg-6 col-md-6 d-flex flex-column justify-content-between">
              <div>
                <h5>Control perimetral</h5>
              </div>
              <div class="text-justify">
                <p>Consiste en sistemas de seguridad diseñados para proteger los límites físicos de una propiedad o instalación. Incluye sensores de movimiento, cercas electrificadas y sistemas de detección de intrusos.</p>
              </div>
              <a href="servicio.php?id=5" class="card-link">Control perimetral</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 mt-4 mb-2">
      <div class="card justify-content-center">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 col-md-6 mb-3">
              <img src="assets/images/plataforma.jpg" class="img-fluid fixed-image" alt="Imagen 1">
            </div>
            <div class="col-lg-6 col-md-6 d-flex flex-column justify-content-between">
              <div>
                <h5>Plataformas</h5>
              </div>
              <div class="text-justify">
                <p>Se refiere a las soluciones tecnológicas que integran y gestionan todos estos sistemas de seguridad de manera centralizada, permitiendo un monitoreo y control eficiente desde cualquier ubicación.</p>
              </div>
              <a href="servicio.php?id=6" class="card-link">Plataformas</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mb-4 mt-5">
  <h3 class="mb-4">Reseñas de Clientes</h3>
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Juan Pérez</h5>
          <p class="card-text">"Excelente servicio. El sistema de CCTV que instalaron en mi negocio funciona de maravilla. Me siento mucho más seguro ahora."</p>
          <div class="d-flex justify-content-end">
            <small class="text-muted">★★★★★</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">María Gómez</h5>
          <p class="card-text">"El centro de monitoreo ha sido una gran inversión para nuestra empresa. La respuesta ante incidentes ha mejorado significativamente."</p>
          <div class="d-flex justify-content-end">
            <small class="text-muted">★★★★★</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Carlos Sánchez</h5>
          <p class="card-text">"Los sistemas de control de accesos nos han permitido mantener nuestras instalaciones seguras. Muy recomendados."</p>
          <div class="d-flex justify-content-end">
            <small class="text-muted">★★★★★</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Ana Rodríguez</h5>
          <p class="card-text">"El control perimetral es exactamente lo que necesitábamos para proteger nuestra propiedad. Gran calidad y servicio."</p>
          <div class="d-flex justify-content-end">
            <small class="text-muted">★★★★★</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


</div>

	
  <!-- Incluir los scripts de Bootstrap 5 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  
  
<script>

responsive_topnav();

</script>
   <!-- Pie de página -->
  <?php

require_once 'layout/footer.php';
?>

</body>
</html>