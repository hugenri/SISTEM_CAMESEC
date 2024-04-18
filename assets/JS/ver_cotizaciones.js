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
                  <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${x.idCotizacion}" onclick="cargarForm()">Editar</button></td>
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


// Función para cargar formulario
function cargarForm() {
  const botones = document.querySelectorAll(".bActualizar");

  botones.forEach(boton => {
      boton.addEventListener("click", function () {
          let id = this.dataset.id;

          // Obtener la fila de la tabla
          let fila = document.querySelector(`#tablaCotizaciones tr[data-id='${id}']`);
          let celdas = fila.getElementsByTagName("td");

          // Obtener los elementos del formulario
          const idInput = document.getElementById("id");
          const fechaInput = document.getElementById("fecha");
          const observacionesInput = document.getElementById("observaciones");
          const idClienteInput = document.getElementById("idCliente");
          const descripcionInput = document.getElementById("descripcion");
          const cantidadInput = document.getElementById("cantidad");
          const precioUnitarioInput = document.getElementById("precioUnitario");
          const importeTotalInput = document.getElementById("importeTotal");
          const idProductoInput = document.getElementById("idProducto");
          const idServicioInput = document.getElementById("idServicio");
          const idCatalogoCotizacionesInput = document.getElementById("idCatalogoCotizaciones");

          // Asignar los datos de la fila al formulario
          idInput.value = celdas[0].innerHTML;
          fechaInput.value = celdas[1].innerHTML;
          observacionesInput.value = celdas[2].innerHTML;
          idClienteInput.value = celdas[3].innerHTML;
          descripcionInput.value = celdas[4].innerHTML;
          cantidadInput.value = celdas[5].innerHTML;
          precioUnitarioInput.value = celdas[6].innerHTML;
          importeTotalInput.value = celdas[7].innerHTML;
          idProductoInput.value = celdas[8].innerHTML;
          idServicioInput.value = celdas[9].innerHTML;
          idCatalogoCotizacionesInput.value = celdas[10].innerHTML;

          // Mostrar el formulario
          document.getElementById("popup").style.display = "block";
      });
  });
}

function actualizar(evento) {//metodo para actualizar el registro
  evento.preventDefault();
  const formulario = document.getElementById("formUpdateCotizacion");
  const datos = new FormData(formulario);

  fetch('actions/actualizarcotizacion.php', {
      method: 'POST',
      body: datos
  })
    .then(response => response.json())
    .then(data => {
      if (data.success == true) {
        alert(data.message);
        formulario.classList.remove('was-validated');
        formulario.reset(); //se limpia el formulario
        document.getElementById("popup").style.display = "none";//estilo para ocultar el popup
        getCotizaciones(); //se recarga la tabla 
      } else {
        alert(data.message);
      }
      
      }
    ).catch(error => {
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
