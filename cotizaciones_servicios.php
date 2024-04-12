<?php

include_once 'clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'cliente') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

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



<div class="row justify-content-center align-items-center mt-4 mb-3">
        <div class="col-lg-12 col-md-6 col-sm-12 text-center">
            <h3 id="titulo" class="mb-3">Mis cotizaciones</h3>
        </div>
    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaCotizaciones" class="table table-striped table-sm">
                        </table>
                        <div class="text-center">
                       <h4 id="NoData"></h4> <!-- mensaje si no hay datos que mostrar -->
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
</div>
   





</div> <!-- fin del contenido-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    mostrarCotizaciones();
});

function mostrarCotizaciones() {
    let noData = document.getElementById("NoData"); // Limpiamos el mensaje de no hay datos
    noData.innerHTML = "";
    let tabla = document.getElementById("tablaCotizaciones") // Limpiamos la tabla

    // Obtener las cotizaciones
    fetch('actions/mostrarCotizacionesServicios.php')
    .then(response => response.json())
    .then(data => {
        if (data.success == true) {
            tabla.innerHTML = "";
        // Verificar si se recibió un objeto o un array
        const cotizaciones = Array.isArray(data.cotizaciones) ? data.cotizaciones : [data.cotizaciones];

        // Mostrar las cotizaciones en una tabla utilizando Bootstrap 5
        let tablaCotizaciones = `
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Fecha de Solicitud</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>`;
        
        cotizaciones.forEach(cotizacion => {
            tablaCotizaciones += `
            <tr>
                <td>${cotizacion.id}</td>
                <td>${cotizacion.servicio}</td>
                <td>${cotizacion.fecha_solicitud}</td>
                <td>${cotizacion.estado}</td>
            </tr>`;
        });

        tablaCotizaciones += `</tbody>`;
        // Insertar la tabla en el contenedor deseado en tu página
        tabla.innerHTML = tablaCotizaciones;
    }else {
              noData.innerHTML = data.message;
          } 
        
    })
    .catch(error => {
        console.error(error);
    });
}


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

