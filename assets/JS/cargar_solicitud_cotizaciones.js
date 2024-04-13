
document.addEventListener("DOMContentLoaded", function () {
  mostrarSolicitudCotizaciones(); // Llama a la función cuando la página esté cargada
});


function mostrarSolicitudCotizaciones() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos

  fetch("actions/solicitudes_cotizacion.php", {
    method: 'GET' // Especifica que la solicitud sea GET
   })
      .then(response => response.json())
      .then(data => { 
          if (data.success == true) {
              document.getElementById("tabla").innerHTML = ""; // Limpiamos la tabla
              let tabla = `<thead>
              <tr>
              <th class="text-nowrap">ID</th>
              <th class="text-nowrap">Servicio</th>
                  <th class="text-nowrap">Fecha de Solicitud</th>
                  <th class="text-nowrap">Estado</th>
                  <th class="text-nowrap" colspan="3">Acciones</th>
                  </tr>
                  </thead>`;
            tabla += `<tbody>`;
            for (let dato of data.dataSolicitud) {
                // Verifica si el estado es diferente de "En proceso"
                if (dato.estado == 'en proceso') {
                  // Si el estado es diferente, se habilita el botón de cotizar
                  cotizarButton = `<td><button class="bCotizar btn custom-button btn-primary btn-sm" data-id="${dato.id}" onclick="cotizar()">Cotizar</button></td>`;
                 //cotizarButton = `<td><button class="bCotizar btn custom-button btn-primary btn-sm" data-id="${dato.id}" onclick="cotizar()">Cotizar</button></td>`;
                } else {
                     // Si el estado es "En proceso", se deja el espacio vacío
                    cotizarButton = `<td></td>`;
                   }
                  tabla += `<tr data-id="${dato.id}">   
                 <td class="text-nowrap">${dato.id}</td>
                      <td class="text-nowrap">${dato.servicio}</td>
                      <td class="text-nowrap">${dato.fecha_solicitud}</td>
                      <td class="text-nowrap">${dato.estado}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${dato.id}" onclick="eliminar('${dato.id}')">Eliminar</button></td>
                      <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${dato.id}" onclick="cargarForm()">Editar</button></td>
                      ${cotizarButton} <!-- Agrega el botón de cotizar -->
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


  
  