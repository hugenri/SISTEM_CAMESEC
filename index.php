<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <!-- Incluir los estilos de Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link href="assets/css/index.css" rel="stylesheet">

</head>
<body>

 <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
      <div class="container">
       
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="registrarse.php">Registrarse</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="sesion.php">Iniciar sesión</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  <div id="containerCarousel" class="container mt-5">
    <div class="row">
      <div class="col-12">
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
              <a href="amenidad.html?id=1">
               <img src="assets/images/CCtv.jpg" class="d-block w-100 img-fluid" alt="Imagen 1">
              </a>
            </div>
            <div class="carousel-item">
              <a href="amenidad.html?id=2">
               <img src="assets/images/monitoreo.jpg" class="d-block w-100 img-fluid" alt="Imagen 2"> 
             </a>
            </div>
            <div class="carousel-item">
              <a href="amenidad.html?id=3">
                <img src="assets/images/acceso.jpg" class="d-block w-100 img-fluid" alt="Imagen 3">
              </a>
            </div>
			<div class="carousel-item">
              <a href="amenidad.html?id=4">
                <img src="assets/images/personal.jpg" class="d-block w-100 img-fluid" alt="Imagen 4">
              </a>
            </div>
			<div class="carousel-item">
              <a href="amenidad.html?id=5">
                <img src="assets/images/perimetro.jpg" class="d-block w-100 img-fluid" alt="Imagen 5">
              </a>
            </div>
			<div class="carousel-item">
                <a href="amenidad.html?id=6">
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
  
<div class="container">
	
	
	<!-- Primera sección -->
	<!-- Primera sección -->
<div class="row mt-4">
  <h3>Nuestros productos y servicios </h3>
  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="image-container">
      <img src="assets/images/circuitocerrado.jpg" class="d-block w-100 h-100" alt="Imagen 1">
    </div>
  </div>
  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="image-container">
      <img src="assets/images/integracion.jpg" class="d-block w-100 h-100" alt="Imagen 2">
    </div>
  </div>
  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="image-container">
      <img src="assets/images/monitoreo.jpg" class="d-block w-100 h-100" alt="Imagen 3">
    </div>
  </div>
</div>

  <div class="row mt-1">

		<div class="col-lg-4 col-md-6 col-sm-12  mt-3">

		<p id="texto">Sistema de CCTV : Sistemas de circuito cerrado de televisión. Contempla los equipos de alta gama en tecnología y diseño para cada solución. Contamos con la ingeniería especializada en los diseños y la selección de equipos adecuados optimizando los costos.</p>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12  mt-3">
		<p id="texto">Plataforma de integración: GOLEM SISTEMAS DE SEGURIDAD. Tiene el respaldo de las marcas comerciales en plataformas de integración con otros sistemas de seguridad y control.</p>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12  mt-3">
		<p id="texto">Centro de monitoreo: Realizamos proyectos completos para centros de monitoreo y arreglos de pantallas VideoWall: Centro de control y comandos & Centro de monitoreo local.</p>
		</div>
	</div>
</div>
<div class="container mt-4 mb-3">

	<!-- Segunda sección -->
	<div class="row">
	<h3>Comentarios destacados de clientes satisfechos</h3>
		<div class="col-lg-4 col-md-6 col-sm-12">
		<p id="texto">El sistema de circuito cerrado de televisión de Golem ha transformado nuestra seguridad. La calidad de imagen, la supervisión remota y la respuesta rápida han superado nuestras expectativas. Nos sentimos más seguros que nunca.</p></div>
		<div class="col-lg-4 col-md-6 col-sm-12">
		<p id="texto">La plataforma de integración de Golem ha sido una solución revolucionaria para nuestra empresa. La capacidad de unificar múltiples sistemas de seguridad en una sola interfaz ha mejorado la eficiencia y la protección de nuestras instalaciones de manera significativa.</p></div>
		<div class="col-lg-4 col-md-6 col-sm-12">
		<p id="texto">El centro de monitoreo de Golem es la columna vertebral de nuestra seguridad. La respuesta proactiva a las alertas, la vigilancia constante y la profesionalidad del personal han elevado nuestro nivel de protección a un nivel superior.</p></div>
	</div>
</div>
	
  <!-- Incluir los scripts de Bootstrap 5 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  
   <!-- Pie de página -->
  <!-- Pie de página -->
  <?php

require_once 'layout/footer.php';
?>

</body>
</html>