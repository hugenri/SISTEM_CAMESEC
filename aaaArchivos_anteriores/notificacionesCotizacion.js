function notificaciorSolicitidesCotizacion() {
    fetch('actions/notificarSolicitudesCotizacion.php')
        .then(response => response.json())
        .then(data => {
            // la respuesta exitosa
            if (data.success) {
                mostrarNotificaciones(data.dataSolicitud);
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

    data.forEach(datos => {
        let listItem = document.createElement('li');
        listItem.innerHTML = `<a class="dropdown-item" href="#"><p>${datos.servicio}</p>
        <p>${datos.fecha_solicitud}</p>
        </a>`;
        notificationMenu.appendChild(listItem); // Agregar elemento al menú de notificaciones
         
        // Agregar línea de separación después de cada elemento <li>
        let separator = document.createElement('hr');
        notificationMenu.appendChild(separator);
    });

    // Actualizar el contador de notificaciones
    let notificationCount = document.getElementById('notification-count');
    notificationCount.textContent = data.length;

    // Mostrar el menú de notificaciones
    notificationMenu.style.display = 'block';
}

/*
document.getElementById('notification-dropdown').addEventListener('click', function() {
    let notificationMenu = document.getElementById('notification-menu');
    let isExpanded = this.getAttribute('aria-expanded') === 'true';

    if (isExpanded) {
      this.setAttribute('aria-expanded', 'false');
      notificationMenu.style.display = 'none';
    } else {
      this.setAttribute('aria-expanded', 'true');
      notificationMenu.style.display = 'block';
    }
  });
*/
  document.addEventListener('DOMContentLoaded', function() {
    let notificationMenu = document.getElementById('notification-menu');
    let notificationDropdown = document.getElementById('notification-dropdown');

    // Ocultar el menú de notificaciones al cargar la página
    notificationMenu.style.display = 'none';
    notificationDropdown.setAttribute('aria-expanded', 'false');

    // Agregar el evento de clic al botón del menú de notificaciones
    notificationDropdown.addEventListener('click', function() {
      let isExpanded = this.getAttribute('aria-expanded') === 'true';

      if (isExpanded) {
        this.setAttribute('aria-expanded', 'false');
        notificationMenu.style.display = 'none';
      } else {
        this.setAttribute('aria-expanded', 'true');
        notificationMenu.style.display = 'block';
      }
    });
  });