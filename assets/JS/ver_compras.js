function getOrdenesCompra() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos

  fetch("actions/vercompras.php")
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
              document.getElementById("tablaOrdenesCompra").innerHTML = ""; // Limpiamos la tabla
              let tabla = `<thead><tr>
                  <th class="text-nowrap">ID Orden de Compra</th>
                  <th class="text-nowrap">Fecha</th>
                  <th class="text-nowrap">Observaciones</th>
                  <th class="text-nowrap">ID Proveedor</th>
                  <th class="text-nowrap">ID Requisición</th>
                  <th class="text-nowrap">ID Catálogo Orden de Compra</th>
                  <th class="text-nowrap" colspan="2">Acciones</th>
              </tr></thead>`;
              tabla += `<tbody>`;
              for (let x of data.dataOrdenesCompra) {
                  tabla += `<tr data-id="${x.idOrdenCompra}">
                      <td class="text-nowrap">${x.idOrdenCompra}</td>
                      <td class="text-nowrap">${x.fecha}</td>
                      <td>${x.observaciones}</td>
                      <td class="text-nowrap">${x.idProveedor}</td>
                      <td class="text-nowrap">${x.idRequisicion}</td>
                      <td class="text-nowrap">${x.idCatalogoOrdenCompra}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${x.idOrdenCompra}" onclick="eliminar('${x.idOrdenCompra}')">Eliminar</button></td>
                      <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${x.idOrdenCompra}" onclick="cargarForm()">Editar</button></td>
                  </tr>`;
              }
              tabla += `</tbody>`;
              document.getElementById("tablaOrdenesCompra").innerHTML = tabla;
          } else {
              document.getElementById("tablaOrdenesCompra").innerHTML = ""; // Limpiamos la tabla
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
          let fila = document.querySelector(`#tablaOrdenesCompra tr[data-id='${id}']`);
          let celdas = fila.getElementsByTagName("td");

          // Obtener los elementos del formulario
          const idInput = document.getElementById("id");
          const fechaInput = document.getElementById("fecha");
          const observacionesInput = document.getElementById("observaciones");
          const idProveedorInput = document.getElementById("idProveedor");
          const idRequisicionInput = document.getElementById("idRequisicion");
          const idCatalogoOrdenCompraInput = document.getElementById("idCatalogoOrdenCompra");

          // Asignar los datos de la fila al formulario
          idInput.value = celdas[0].innerHTML;
          fechaInput.value = celdas[1].innerHTML;
          observacionesInput.value = celdas[2].innerHTML;
          idProveedorInput.value = celdas[3].innerHTML;
          idRequisicionInput.value = celdas[4].innerHTML;
          idCatalogoOrdenCompraInput.value = celdas[5].innerHTML;

          // Mostrar el formulario
          document.getElementById("popup").style.display = "block";
      });
  });
}


function actualizar(evento) {//metodo para actualizar el registro
  evento.preventDefault();
  const formulario = document.getElementById("formUpdateCompra");
  const datos = new FormData(formulario);

  fetch('actions/actualizarcompra.php', {
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
        getOrdenesCompra(); //se recarga la tabla 
      } else {
        alert(data.message);
      }
      
      }
    ).catch(error => {
      console.error('Error:', error);
    });
}


function eliminar(id){

  const confirmar = window.confirm("¿Deseas eliminar el registro?");
      if(confirmar){
      const formData = new FormData();
        formData.append('id', id);

        fetch('actions/eliminarcompra.php', {
          method: 'POST',
          body: formData
        })
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
             const row = document.querySelector(`#tablaOrdenesCompra tr[data-id='${id}']`);
             if (row) {
                   row.remove();
                }
                alert(data.message);
                //verUsuarios();
          }else {
              alert(data.message);
            }
  }).catch(error => {
    console.error('Error:', error);
  });
}
  
}

