function getVentas() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos
  const datos = new FormData();
  datos.append('action', 'mostarVentas');

  fetch('actions/verventas.php', {
      method: 'POST',
      body: datos
    })
      .then(response => response.json())
      .then(data => { 
        if (data.success == true) {
          document.getElementById("tablaVentas").innerHTML = ""; // Limpiamos la tabla
          let tabla = `<thead>
              <tr>
                  <th class="text-nowrap">ID Venta</th>
                  <th class="text-nowrap">Cliente</th>
                  <th class="text-nowrap">Fecha de venta</th>
                  <th class="text-nowrap">Total+IVA</th>
                  <th class="text-nowrap">IVA</th>
                  <th class="text-nowrap">Método de Pago</th>
                  <th class="text-nowrap">Pago realizado</th>
                  <th class="text-nowrap">Estado de Entrega</th>
                  <th class="text-nowrap" colspan="2">Acciones</th>
              </tr>
          </thead>`;
          tabla += `<tbody>`;
          for (let x of data.datosVentas) {
              tabla += `<tr data-id="${x.id_venta}">
                  <td class="text-nowrap">${x.id_venta}</td>
                  <td class="text-nowrap">${x.razonSocial}</td>
                  <td class="text-nowrap">${x.fecha_venta}</td>
                  <td class="text-nowrap">${x.total_con_iva}</td>
                  <td class="text-nowrap">${x.iva}</td>
                  <td class="text-nowrap">${x.metodo_pago}</td>
                  <td class="text-nowrap">${x.pago}</td>
                  <td class="text-nowrap">${x.estado_entrega}</td>
                  <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${x.id_venta}" onclick="eliminar('${x.id_venta}')">Eliminar</button></td>
                  <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${x.id_venta}" onclick="cargarForm('${x.id_venta}')">Editar</button></td>
              </tr>`;
          }
          tabla += `</tbody>`;
          document.getElementById("tablaVentas").innerHTML = tabla;
      }
      
      else {
          document.getElementById("tablaVentas").innerHTML = ""; // Limpiamos la tabla
          document.getElementById("NoData").innerHTML = data.message;
      }
      })
      .catch(error => {
          console.error('Error:', error);
      });
}



function eliminar(idVenta){

  Swal.fire({
    title: '¿Desea eliminar los datos de la venta?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar'
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
        formData.append('idVenta', idVenta);
        formData.append('action', 'eliminarVenta');


        fetch('actions/verventas.php', {
          method: 'POST',
          body: formData
        })
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
             const row = document.querySelector(`#tablaVentas tr[data-id='${idVenta}']`);
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
