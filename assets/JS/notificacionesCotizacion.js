function notificaciorSolicitidesCotizacion() {
    fetch('actions/notificarSolicitudesCotizacion.php')
        .then(response => response.json())
        .then(data => {
            // la respuesta exitosa
            if (data.success) {
            // Obtener la longitud del array de objetos en la propiedad 'data'
            const numero = data.dataSolicitud.length;
            
            if(numero > 0){
                mostrarNotificaciones(data.dataSolicitud);
            }
            }
        })
        .catch(error => {
            // errores en la solicitud o en el archivo PHP
            console.error('Error en la solicitud...:', error);
        });
}


function mostrarNotificaciones(data) {
  let notificationMenu = document.getElementById('notification-menu');
  notificationMenu.innerHTML = ''; // Limpiar contenido anterior
  
  // Mostrar el contenedor de cotizaciones si hay cotizaciones disponibles
  const containerNotificacionSolicitudes = document.getElementById('containerNotificacionSolicitudes');
         containerNotificacionSolicitudes.style.display = 'block';

  data.forEach((datos, index) => {
      let listItem = document.createElement('li');
      listItem.innerHTML = `<a class="dropdown-item" href="cotizar_solicitud.php?idCliente=${datos.id_cliente}&idSolicitud=${datos.id}
      &razonSocial=${datos.razonSocial}&servicio=${datos.servicio}&telefono=${datos.telefono}&nombre=${datos.nombreCliente}"">
      <p>Cliente: ${datos.razonSocial}</p>
      <p>Servicio: ${datos.servicio}</p>
      <p>Fecha: ${datos.fecha_solicitud}</p></a>`;
      notificationMenu.appendChild(listItem); // Agregar elemento al menú de notificaciones

      // Agregar línea de separación después de cada elemento <li> excepto el último
      if (index !== data.length - 1) {
          let separator = document.createElement('hr');
          notificationMenu.appendChild(separator);
      }
  });

  // Actualizar el contador de notificaciones
  let notificationCount = document.getElementById('notification-count');
  notificationCount.textContent = data.length;

  // Mostrar el menú de notificaciones
 // notificationMenu.style.display = 'block';
}


// JavaScript para mostrar y ocultar el dropdown al hacer clic en el card
document.getElementById('dropdown-card').addEventListener('click', function(event) {
  var dropdownMenu = document.getElementById('notification-menu');
  if (dropdownMenu.style.display === 'block') {
    dropdownMenu.style.display = 'none';
  } else {
    dropdownMenu.style.display = 'block';
  }
  event.stopPropagation(); // Evita que el evento se propague al hacer clic en el card
});

// JavaScript para ocultar el dropdown al hacer clic fuera del card
document.addEventListener('click', function(event) {
  var dropdownMenu = document.getElementById('notification-menu');
  if (event.target.closest('#dropdown-card') === null && dropdownMenu.style.display === 'block') {
    dropdownMenu.style.display = 'none';
  }
});