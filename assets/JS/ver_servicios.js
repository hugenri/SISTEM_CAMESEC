function getServicios() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos

  fetch("actions/verservicios.php")
      .then(response => response.json())
      .then(data => { 
          if (data.success == true) {
              document.getElementById("tablaServicio").innerHTML = ""; // Limpiamos la tabla
              let tabla = `<thead><tr>
              <th class="text-nowrap">ID</th>
              <th class="text-nowrap">ID Orden de compra</th>
                  <th class="text-nowrap">Detalles</th>
                  <th class="text-nowrap">Encargado</th>
                  <th class="text-nowrap">fecha</th>
                    <th class="text-nowrap">Estado</th>
                  <th class="text-nowrap" colspan="2">Acciones</th></thead>`;
              tabla += `<tbody>`;
              for (let x of data.dataServices) {
                  tabla += `<tr data-id="${x.idServicio}">
                      <td class="text-nowrap">${x.idServicio}</td>
                      <td class="text-nowrap">${x.idOrdenCompra}</td>
                      <td data-detalles="${x.detalles}">${truncateDetalles(x.detalles, 14)} ...</td>
                      <td data-idEmpleado="${x.idEmpleado}" class="text-nowrap">${x.nombre_usuario} ${x.apellidoP} ${x.apellidoM}</td>
                      <td class="text-nowrap">${x.fecha}</td>
                      <td class="text-nowrap clickeable" onclick="abrirModalPopup('${x.idServicio}', '${x.estado}')">${x.estado}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${x.idServicio}" onclick="eliminar('${x.idServicio}')">Eliminar</button></td>
                      <td>
                       <button class="bActualizar btn custom-button btn-primary btn-sm"
                      data-id="${x.idServicio}"
                      onclick="cargarForm(event)">Editar</button>
                      </td>
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
function cargarForm(evento) {
  evento.preventDefault();
  const botones = document.querySelectorAll(".bActualizar");

  botones.forEach(boton => {
    boton.addEventListener("click", function () {
      let id = this.dataset.id;
     
      let fila = document.querySelector(`#tablaServicio tr[data-id='${id}']`);
      let celdas = fila.getElementsByTagName("td");
      
      // Obtenemos el valor de data-idEmpleado de la celda
      let idEmpleado = document.querySelector(`#tablaServicio tr[data-id='${id}'] td[data-idEmpleado]`);
      if (idEmpleado) {
        idEmpleado = idEmpleado.getAttribute("data-idEmpleado");
      }
    // Obtenemos el valor de data-detalles de la celda
    let detalles = document.querySelector(`#tablaServicio tr[data-id='${id}'] td[data-detalles]`);
    if (detalles) {
      detalles = detalles.getAttribute("data-detalles");
    }
  
// Obtener los elementos del formulario
      const IdInput = document.getElementById("id");
      const detallesInput = document.getElementById("detalles");
      const fechaInput = document.getElementById("fecha");
      const idOrdenCompraInput = document.getElementById("idOrdenCompra");

      // Asignar los datos de la fila al formulario
      IdInput.value = celdas[0].innerHTML;
      idOrdenCompraInput.value = celdas[1].innerHTML;
      fechaInput.value = celdas[4].innerHTML;
      detallesInput.value = detalles;

      get_empleados(idEmpleado);
    
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

function truncateDetalles(detalles, maxCharacters) {
  if (detalles.length <= maxCharacters) {
    return detalles; // Devuelve la cadena completa si es menor o igual al número deseado de caracteres
  } else {
    const truncatedString = detalles.substring(0, maxCharacters); // Toma los primeros maxCharacters caracteres
    return truncatedString.trim(); // Elimina los posibles espacios en blanco al final
  }
}


function get_empleados(idEmpleado){
  // Fetch para obtener la lista de empleados
fetch("actions/get_empleados.php")
.then(response => response.json())
.then(data => {
  const responsableSelect = document.getElementById("responsable");
   // Limpiar opciones existentes
   responsableSelect.innerHTML = "";
    
  // Agregar una opción por cada empleado
  data.datos.forEach(empleado => {
    let option = document.createElement("option"); // Define la variable option aquí

    if (idEmpleado == empleado.id) {
      option.value = empleado.id; // Ajusta esto según el ID del empleado en tu base de datos
      option.text = empleado.nombre_completo; // Ajusta esto según la estructura de datos de tu empleado
      responsableSelect.appendChild(option);
    }
    option.value = empleado.id; // Ajusta esto según el ID del empleado en tu base de datos
    option.text = empleado.nombre_completo; // Ajusta esto según la estructura de datos de tu empleado
    responsableSelect.appendChild(option);
  });
})
.catch(error => console.error("Error al obtener la lista de empleados:", error));

}   

function abrirModalPopup(idServicio, estado){
   
   // Mostrar el formulario
   document.getElementById("estadoModal").style.display = "block";//estilo para mostrar el popup
   
    // Establecer el valor del campo de entrada oculto idServicio
    document.getElementById("idServicio").value = idServicio;
   quitarOpcion(estado);
}

function quitarOpcion(estado){
    // Obtener el elemento select
    var selectElement = document.getElementById("estadoSelect");
    // Iterar sobre las opciones del select
    for (var i = 0; i < selectElement.options.length; i++) {
        // Comparar el valor de la opción con el estado que quieres excluir
        if (selectElement.options[i].value === estado) {
            // Remover la opción que coincide con el estado
            selectElement.remove(i);
            break; // Terminar el bucle una vez que se haya removido la opción
        }
    }
}

function actualizarEstadoServicio(evento) {//metodo para actualizar el registro
  evento.preventDefault();
  const formulario = document.getElementById("estadoServicioForm");
  const datos = new FormData(formulario);
  Swal.fire({
    title: '¿Desea el estodo  del servicio?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, actualizar'
  }).then((result) => {
    if (result.isConfirmed) {
  fetch('actions/cambiarEstadoServicio.php', {
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
        document.getElementById("estadoModal").style.display = "none";//estilo para mostrar el popup        getServicios(); //se recarga la tabla 
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