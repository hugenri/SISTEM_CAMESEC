document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("form").addEventListener('submit', crearCompra); 
});

function crearCompra(evento) {
  evento.preventDefault();

  const formulario = document.getElementById("form");
  const datos = new FormData(formulario);
  datos.append('action', 'createOrdeneCompra');

  Swal.fire({
    title: '¿Desea registar los datos de la orden de compra?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, registrar'
  }).then((result) => {
    if (result.isConfirmed) {
  fetch('actions/orden_compras.php', {
      method: 'POST',
      body: datos
  })
  .then(response => response.json())
  .then(data => {
      if (data.success == true) {
        Swal.fire({
          title: 'Éxito',
          text: data.message,
          icon: 'success'
      });
          formulario.reset(); // Se limpia el formulario
          formulario.classList.remove('was-validated');
      }else {
        Swal.fire('Error', data.message, 'error');

      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
}
});
return ;
}


// Función para cargar los datos de servicios desde la API
function cargarCotizaciones() {
        
  fetch("actions/cargar_datos_cotizacion.php")
      .then(response => response.json())
      .then(data => {
          mostrarTabla(data.dataCotizacion);
          
      })
      .catch(error => console.error('Error al cargar los servicios:', error));
}

// Función para mostrar la tabla con los datos de servicios
function mostrarTabla(datos) {
  var tbody = document.getElementById("tablaCotizaciones").querySelector("tbody");

  // Limpiar contenido previo de la tabla
  tbody.innerHTML = "";

  // Agregar filas con los datos de los servicios
 datos.forEach(function(cotizacion) {
      var row = document.createElement("tr");
      row.innerHTML = `
                <td class="text-nowrap">${cotizacion.idCotizacion}</td>
                <td class="text-nowrap">${cotizacion.servicio}</td>
                <td>${cotizacion.razonSocial}</td>
                <td>${cotizacion.fecha}</td>
                <td><button class="btn-seleccionar btn custom-button btn-primary btn-sm" data-id="${cotizacion.idCotizacion}">Seleccionar</button></td>
                `;    
                tbody.appendChild(row);
  });
   // Agregar eventos de clic a los botones de selección
   var btnSeleccionar = document.querySelectorAll('.btn-seleccionar');
  btnSeleccionar.forEach(function(btn) {
      btn.addEventListener('click', function() {
          var id = this.getAttribute('data-id');
          var nombre = this.getAttribute('data-nombre');
          var cliente = this.getAttribute('data-cliente');
          document.getElementById('idCotizacion').value = id; // Actualizamos el valor del input con los datos seleccionados
          var tablaModal = bootstrap.Modal.getInstance(document.getElementById('tablaModal'));
          tablaModal.hide(); // Cerramos el modal después de seleccionar
      });
  });
  var tablaModal = new bootstrap.Modal(document.getElementById('tablaModal')); // Inicializar el modal
      tablaModal.show();
}

// Evento al hacer clic en el input para cargar los servicios
document.getElementById("idCotizacion").addEventListener("click", function() {
  cargarCotizaciones();
});