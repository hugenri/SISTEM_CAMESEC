function getRequisiciones() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos

  fetch("actions/ver_requisiciones.php")
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
              document.getElementById("tablaRequisicion").innerHTML = ""; // Limpiamos la tabla
              let tabla = `<thead><tr><th class="text-nowrap">ID</th>
                   <th class="text-nowrap">Fecha</th>
                   <th class="text-nowrap">Descripción</th>
                  <th class="text-nowrap">Cantidad</th>
                  <th class="text-nowrap">Precio Unitario</th>
                  <th class="text-nowrap">Importe Total</th>
                  <th class="text-nowrap">Observaciones</th>
                  <th class="text-nowrap">ID Proveedor</th>
                  <th class="text-nowrap">ID Servicio</th>
                  <th class="text-nowrap">ID Concepto</th>
                  <th class="text-nowrap">ID Cotizaciones</th>
                  <th class="text-nowrap">ID Producto</th>
                  <th class="text-nowrap">ID Cliente</th>
                  <th class="text-nowrap">ID Catalogo Requisición</th>
                  <th class="text-nowrap" colspan="2">Acciones</th></thead>`;
              tabla += `<tbody>`;
              for (let requisicion of data.dataRequisiciones) {
                
                  tabla += `<tr data-id="${requisicion.idRequisicion}">
                      <td class="text-nowrap">${requisicion.idRequisicion}</td>
                      <td class="text-nowrap">${requisicion.fecha}</td>
                      <td>${requisicion.descripcion}</td>
                      <td class="text-nowrap">${requisicion.cantidad}</td>
                      <td class="text-nowrap">${requisicion.precioUnitario}</td>
                      <td class="text-nowrap">${requisicion.importeTotal}</td>
                      <td>${requisicion.observaciones}</td>
                      <td class="text-nowrap">${requisicion.idProveedor}</td>
                      <td class="text-nowrap">${requisicion.idServicio}</td>
                      <td class="text-nowrap">${requisicion.idConcepto}</td>
                      <td class="text-nowrap">${requisicion.idCotizaciones}</td>
                      <td class="text-nowrap">${requisicion.idProducto}</td>
                      <td class="text-nowrap">${requisicion.idCliente}</td>
                      <td class="text-nowrap">${requisicion.idCatalogoRequisicion}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${requisicion.idRequisicion}" onclick="eliminar('${requisicion.idRequisicion}')">Eliminar</button></td>
                      <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${requisicion.idRequisicion}" onclick="cargarForm()">Editar</button></td>
                  </tr>`;
              }
              tabla += `</tbody>`;
              document.getElementById("tablaRequisicion").innerHTML = tabla;
          } else {
              document.getElementById("tablaRequisicion").innerHTML = ""; // Limpiamos la tabla
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

          let fila = document.querySelector(`#tablaRequisicion tr[data-id='${id}']`);
          let celdas = fila.getElementsByTagName("td");

          
          // Obtener los elementos del formulario
          const IdInput = document.getElementById("id");
          const fechaInput = document.getElementById("fecha");
          const descripcionInput = document.getElementById("descripcion");
          const cantidadInput = document.getElementById("cantidad");
          const precioUnitarioInput = document.getElementById("precioUnitario");
          const importeTotalInput = document.getElementById("importeTotal");
          const observacionesInput = document.getElementById("observaciones");
          const idProveedorInput = document.getElementById("idProveedor");
          const idServicioInput = document.getElementById("idServicio");
          const idConceptoInput = document.getElementById("idConcepto");
          const idCotizacionesInput = document.getElementById("idCotizaciones");
          const idProductoInput = document.getElementById("idProducto");
          const idClienteInput = document.getElementById("idCliente");
          const idCatalogoRequisicionInput = document.getElementById("idCatalogoRequisicion");

          // Asignar los datos de la fila al formulario
          IdInput.value = celdas[0].innerHTML;
          fechaInput.value = celdas[1].innerHTML;
          descripcionInput.value = celdas[2].innerHTML;
          cantidadInput.value = celdas[3].innerHTML;
          precioUnitarioInput.value = celdas[4].innerHTML;
          importeTotalInput.value = celdas[5].innerHTML;
          observacionesInput.value = celdas[6].innerHTML;
          idProveedorInput.value = celdas[7].innerHTML;
          idServicioInput.value = celdas[8].innerHTML;
          idConceptoInput.value = celdas[9].innerHTML;
          idCotizacionesInput.value = celdas[10].innerHTML;
          idProductoInput.value = celdas[11].innerHTML;
          idClienteInput.value = celdas[12].innerHTML;
          idCatalogoRequisicionInput.value = celdas[13].innerHTML;


          // Mostrar el formulario
          document.getElementById("popup").style.display = "block"; // Estilo para mostrar el popup
      });
  });
}

function actualizar(evento) {//metodo para actualizar el registro
  evento.preventDefault();
  const formulario = document.getElementById("formUpdateRequisicion");
  const datos = new FormData(formulario);
  Swal.fire({
    title: '¿Desea actualizar los datos de la requisición?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, actualizar'
  }).then((result) => {
    if (result.isConfirmed) {
  fetch('actions/actualizar_requisicion.php', {
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
        formulario.classList.remove('was-validated');
        formulario.reset(); //se limpia el formulario
        document.getElementById("popup").style.display = "none";//estilo para ocultar el popup
        getRequisiciones(); //se recarga la tabla 
      } else {
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

function eliminar(id){

  Swal.fire({
    title: '¿Desea eliminar el registro?',
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

        fetch('actions/eliminar_requisicion.php', {
          method: 'POST',
          body: formData
        })
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
             const row = document.querySelector(`#tablaRequisicion tr[data-id='${id}']`);
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
