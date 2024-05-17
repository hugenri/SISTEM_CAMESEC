document.addEventListener('DOMContentLoaded', function() {
  getCotizaciones();
});

document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("form").addEventListener('submit', crearCompra); 
});

function crearCompra(evento) {
  evento.preventDefault();

  const formulario = document.getElementById("form");
  const datos = new FormData(formulario);
  datos.append('action', 'createOrdenCompra');

  Swal.fire({
    title: '¿Desea registar los datos para la orden de compra?',
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
          cerrarPopup();
          getCotizaciones();
         
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


function getCotizaciones() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos
  const datos = new FormData();
  datos.append('action', 'getDatosCotizaciones');

  fetch('actions/getDatosCotizacionesOrdenCompras.php', {
      method: 'POST',
      body: datos
  }).then(response => response.json())
      .then(data => { 
        if (data.success == true) {
          document.getElementById("tabla").innerHTML = ""; // Limpiamos la tabla
          let tabla = `<thead>
              <tr>
                  <th class="text-nowrap">ID Cotización</th>
                  <th class="text-nowrap">Fecha</th>
                  <th class="text-nowrap">Cliente</th>
                  <th class="text-nowrap">Servicio</th>
                  <th class="text-nowrap">Estatus</th>
                  <th class="text-nowrap">Acciones</th>
              </tr>
          </thead>`;
          tabla += `<tbody>`;
          for (let x of data.dataCotizaciones) {
              tabla += `<tr data-id="${x.idCotizacion}">
                  <td class="text-truncate">${x.idCotizacion}</td>
                  <td class="text-truncate">${x.fecha}</td>
                  <td class="text-truncate">${x.razonSocialCliente}</td>
                  <td class="text-truncate">${x.servicio}</td>
                  <td class="text-truncate">${x.estatus}</td>
                  <td><button class="bActualizar btn custom-button btn-primary btn-sm text-truncate" data-id="${x.idCotizacion}" onclick="abrirFormulario('${x.idCotizacion}')">Crear Orden de compra</button></td>
              </tr>`;
          }
          tabla += `</tbody>`;
          document.getElementById("tabla").innerHTML = tabla;
      }
      
          else {
              document.getElementById("tabla").innerHTML = ""; // Limpiamos la tabla
              document.getElementById("NoData").innerHTML = data.message;
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
}

//******************************** */

function abrirFormulario(idCotizacion){
 // Establecer el valor del input
 document.getElementById('idCotizacion').value = idCotizacion;
  
 // Hacer el input solo de lectura
 document.getElementById('idCotizacion').readOnly = true;
 document.getElementById("modalPopup").style.display = "block";//estilo para mostrar el popup

}

  
function cerrarPopup(){
      document.getElementById("modalPopup").style.display = "none";//estilo para cerrar el popup
  
  }