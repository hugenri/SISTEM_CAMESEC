function getServicios() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos

  fetch("actions/verservicios.php")
      .then(response => response.json())
      .then(data => { 
          if (data.success == true) {
              document.getElementById("tablaServicio").innerHTML = ""; // Limpiamos la tabla
              let tabla = `<thead><tr>
              <th class="text-nowrap">ID</th>
              <th class="text-nowrap">Nombre</th>
                  <th class="text-nowrap">Tarifa</th>
                  <th class="text-nowrap">Descripción</th>
                  <th class="text-nowrap">Disponibilidad</th>
                  <th class="text-nowrap">Cotización</th>
                    <th class="text-nowrap">Requisición</th>
                    <th class="text-nowrap">Orden de Compra</th>
                  <th class="text-nowrap" colspan="2">Acciones</th></thead>`;
              tabla += `<tbody>`;
              for (let x of data.dataServices) {
                  tabla += `<tr data-id="${x.idServicio}">
                      <td class="text-nowrap">${x.idServicio}</td>
                      <td class="text-nowrap">${x.nombre}</td>
                      <td class="text-nowrap">${x.tarifa}</td>
                      <td>${truncateDescription(x.descripcion, 5)}</td>
                      <td class="text-nowrap">${x.disponibilidad}</td>
                      <td class="text-nowrap">${x.idCotizacion}</td>
                      <td class="text-nowrap">${x.idRequisicion}</td>
                      <td class="text-nowrap">${x.idOrdenCompra}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${x.idServicio}" onclick="eliminar('${x.idServicio}')">Eliminar</button></td>
                      <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${x.idServicio}" onclick="cargarForm()">Editar</button></td>
                  </tr>`;
              }
              tabla += `</tbody>`;
              document.getElementById("tablaServicio").innerHTML = tabla;
          } 
          else {
              document.getElementById("tablaServicio").innerHTML = ""; // Limpiamos la tabla
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
  
      let fila = document.querySelector(`#tablaServicio tr[data-id='${id}']`);
      let celdas = fila.getElementsByTagName("td");
    
// Obtener los elementos del formulario
      const IdInput = document.getElementById("id");
      const nombreInput = document.getElementById("nombre");
      const descripcionInput = document.getElementById("descripcion");
      const tarifaInput = document.getElementById("tarifa");
      const disponibilidadInput = document.getElementById("disponibilidad");
      const idCotizacionInput = document.getElementById("idCotizacion");
      const idRequisicionInput = document.getElementById("idRequisicion");
      const idOrdenCompraInput = document.getElementById("idOrdenCompra");


  

      
      
      // Asignar los datos de la fila al formulario
      IdInput.value = celdas[0].innerHTML;
      nombreInput.value = celdas[1].innerHTML;
      tarifaInput.value = celdas[2].innerHTML;
      descripcionInput.value = celdas[3].innerHTML;
      disponibilidadInput.value = celdas[4].innerHTML;
      idCotizacionInput.value = celdas[5].innerHTML;
      idRequisicionInput.value = celdas[6].innerHTML;
      idOrdenCompraInput.value = celdas[7].innerHTML;
 
      
    
      // Mostrar el formulario
      document.getElementById("popup").style.display = "block";//estilo para mostrar el popup
   
    });
  });
}

function actualizar(evento) {//metodo para actualizar el registro
  evento.preventDefault();
  const formulario = document.getElementById("formUpdateServicio");
  const datos = new FormData(formulario);
  Swal.fire({
    title: '¿Desea actualizar los datos del servicio?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, actualizar'
  }).then((result) => {
    if (result.isConfirmed) {
  fetch('actions/actualizarservicio.php', {
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
        getServicios(); //se recarga la tabla 
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

        fetch('actions/eliminarservicio.php', {
          method: 'POST',
          body: formData
        })
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
             const row = document.querySelector(`#tablaServicio tr[data-id='${id}']`);
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

function truncateDescription(description, maxWords) {
  const words = description.split(' ');
  const truncatedWords = words.slice(0, maxWords);
  return truncatedWords.join(' ');
}
