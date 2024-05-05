// Llama a la función notificarCotizaciones cuando el DOM esté completamente cargado

document.addEventListener("DOMContentLoaded", function () {
    getNumeroCotizaciones(); // Llama a la función cuando la página esté cargada
    setInterval(getNumeroCotizaciones, 120000);
           });

function getNumeroCotizaciones() {
    fetch('actions/notificar_numero_cotizaciones.php')
        .then(response => response.json())
        .then(data => {
            // la respuesta exitosa
            if (data.success) {
                 // Obtener el valor de num_cotizaciones directamente
                 const numCotizaciones = data.numCotizaciones[0].num_cotizaciones;
                 if(numCotizaciones > 0){
                // Mostrar el contenedor de cotizaciones si hay cotizaciones disponibles
                const cotizacionesContainer = document.getElementById('cotizaciones-container');
                cotizacionesContainer.style.display = 'block';
              // Actualizar el contador de cotizaciones
          let notificationCount = document.getElementById('notification-count');
            notificationCount.textContent = numCotizaciones;
                 }
            }
        })
        .catch(error => {
            // errores en la solicitud o en el archivo PHP
            console.error('Error en la solicitud...:', error);
        });
}
