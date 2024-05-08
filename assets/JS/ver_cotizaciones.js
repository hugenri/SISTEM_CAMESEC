function getCotizaciones() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos

  fetch("actions/vercotizaciones.php")
      .then(response => response.json())
      .then(data => { 
        if (data.success == true) {
          document.getElementById("tablaCotizaciones").innerHTML = ""; // Limpiamos la tabla
          let tabla = `<thead>
              <tr>
                  <th class="text-nowrap">ID Cotización</th>
                  <th class="text-nowrap">Fecha</th>
                  <th class="text-nowrap">Observaciones</th>
                  <th class="text-nowrap">Cliente</th>
                  <th class="text-nowrap">Descripción</th>
                  <th class="text-nowrap">Subtotal</th>
                  <th class="text-nowrap">Total</th>
                  <th class="text-nowrap">IVA</th>
                  <th class="text-nowrap">Descuento</th>
                  <th class="text-nowrap">Costo de Instalación</th>
                  <th class="text-nowrap">Servicio</th>
                  <th class="text-nowrap">Estatus</th>
                  <th class="text-nowrap" colspan="2">Acciones</th>
              </tr>
          </thead>`;
          tabla += `<tbody>`;
          for (let x of data.dataCotizaciones) {
              tabla += `<tr data-id="${x.idCotizacion}">
                  <td class="text-nowrap">${x.idCotizacion}</td>
                  <td class="text-nowrap">${x.fecha}</td>
                  <td class="text-nowrap">${x.observaciones}</td>
                  <td class="text-nowrap">${x.razonSocialCliente}</td>
                  <td>${x.descripcion}</td>
                  <td class="text-nowrap">${x.subtotal}</td>
                  <td class="text-nowrap">${x.total}</td>
                  <td class="text-nowrap">${x.iva}</td>
                  <td class="text-nowrap">${x.descuento}</td>
                  <td class="text-nowrap">${x.costo_instalacion}</td>
                  <td class="text-nowrap">${x.servicio}</td>
                  <td class="text-nowrap">${x.estatus}</td>
                  <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${x.idCotizacion}" onclick="eliminar('${x.idCotizacion}')">Eliminar</button></td>
                  <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${x.idCotizacion}" onclick="cargarForm('${x.idCotizacion}')">Editar</button></td>
              </tr>`;
          }
          tabla += `</tbody>`;
          document.getElementById("tablaCotizaciones").innerHTML = tabla;
      }
      
          else {
              document.getElementById("tablaCotizaciones").innerHTML = ""; // Limpiamos la tabla
              document.getElementById("NoData").innerHTML = data.message;
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
}





function eliminar(id){

  Swal.fire({
    title: '¿Desea eliminar los datos de la cotización?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar'
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
        formData.append('id', id);

        fetch('actions/eliminarcotizacion.php', {
          method: 'POST',
          body: formData
        })
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
             const row = document.querySelector(`#tablaCotizaciones tr[data-id='${id}']`);
             if (row) {
                   row.remove();
                }
                Swal.fire({
                  title: 'Éxito',
                  text: data.message,
                  icon: 'success'
              });
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
