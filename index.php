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
        <div id="slider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1000">
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
  <div class="container mb-1 mt-1">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
  <h3>Explora Nuestro Catálogo de Servicios</h3>
  </div>
        </div>
        </div>

  <div class="container mb-3">
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 mt-4 mb-2">
      <a href="servicio.php?id=1" class="card-link">
        <div class="card justify-content-center">
          <div class="card-body">
            <h6 class="card-title text-center">Sistema de CCTV</h6>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 mt-4 mb-2">
      <a href="servicio.php?id=2" class="card-link">
        <div class="card justify-content-center">
          <div class="card-body">
            <h6 class="card-title text-center">Centro de Monitoreo</h6>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 mt-4 mb-2">
      <a href="servicio.php?id=3" class="card-link">
        <div class="card justify-content-center">
          <div class="card-body">
            <h6 class="card-title text-center">Sistemas de control de accesos</h6>
          </div>
        </div>
      </a>
    </div>
  </div> <!-- Cierra la primera fila (row) -->
  
  <div class="row"> <!-- Abre una nueva fila (row) -->
    <div class="col-lg-4 col-md-4 col-sm-12 mt-4 mb-2">
      <a href="servicio.php?id=4" class="card-link">
        <div class="card justify-content-center">
          <div class="card-body">
            <h6 class="card-title text-center">Control de personal</h6>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 mt-4 mb-2">
      <a href="servicio.php?id=5" class="card-link">
        <div class="card justify-content-center">
          <div class="card-body">
            <h6 class="card-title text-center">Control perimetral</h6>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 mt-4 mb-2">
      <a href="servicio.php?id=6" class="card-link">
        <div class="card justify-content-center">
          <div class="card-body">
            <h6 class="card-title text-center">Plataformas</h6>
          </div>
        </div>
      </a>
    </div>
  </div> <!-- Cierra la segunda fila (row) -->
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