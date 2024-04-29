function getOrdenesCompra() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos

    let datos = new FormData();
       datos.append('action', "mostar");


  fetch('actions/orden_compras.php', {
      method: 'POST',
      body: datos
  })  .then(response => {
    if (!response.ok) {
        return response.json().then(errorData => {
            throw new Error('Error en la solicitud. Código de estado: ' + response.status + ', Tipo de error: ' + errorData.error + ', Mensaje: ' + errorData.message);
        });
    }
    return response.json(); // Suponiendo que la respuesta es JSON
})
      .then(data => {
          if (data.success == true) {
              document.getElementById("tablaOrdenesCompra").innerHTML = ""; // Limpiamos la tabla
              let tabla = `<thead><tr>
                  <th class="text-nowrap">ID Orden de Compra</th>
                  <th class="text-nowrap">Fecha</th>
                  <th class="text-nowrap">Observaciones</th>
                  <th class="text-nowrap">Descripción</th>
                  <th class="text-nowrap">ID Cotización</th>
                  <th class="text-nowrap">Estado</th>
                  <th  colspan="3">Acciones</th>


              </tr></thead>`;
              tabla += `<tbody>`;
              for (let x of data.datosOrdenesCompra) {
                  tabla += `<tr data-id="${x.idOrdenCompra}">
                      <td class="text-nowrap">${x.idOrdenCompra}</td>
                      <td class="text-nowrap">${x.fecha}</td>
                      <td>${x.observaciones}</td>
                      <td class="text-nowrap">${x.descripcion}</td>
                      <td class="text-nowrap">${x.idCotizacion}</td>
                      <td class="text-nowrap cursor-pointer" data-estado="${['x.idOrdenCompra']}">${x.estado}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${x.idOrdenCompra}" onclick="eliminar('${x.idOrdenCompra}')">Eliminar</button></td>
                      <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${x.idOrdenCompra}" onclick="cargarForm()">Editar</button></td>
                      <td><button class="btn btn-primary custom-button btn-sm" onclick="cargarForm()">Ver</button></td>

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
          const idOrdenCompraInput = document.getElementById("idOrdenCompra");
          const fechaInput = document.getElementById("fecha");
          const observacionesInput = document.getElementById("observaciones");
          const descripcionInput = document.getElementById("descripcion");
          const idCotizacionInput = document.getElementById("idCotizacion");

          

          // Asignar los datos de la fila al formulario
          idOrdenCompraInput.value = celdas[0].innerHTML;
          fechaInput.value = celdas[1].innerHTML;
          observacionesInput.value = celdas[2].innerHTML;
          descripcionInput.value = celdas[3].innerHTML;
          idCotizacionInput.value = celdas[4].innerHTML;


          // Mostrar el formulario
          document.getElementById("popup").style.display = "block";
      });
  });
}

function actualizar(evento){
  evento.preventDefault();
  let formulario = document.getElementById("form");
  let formData = new FormData(formulario);
   Swal.fire({
     title: '¿Desea actualizar el registros de la orden de compra?',
     text: 'Esta acción no se puede deshacer',
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Sí, registrar'
   }).then((result) => {
     if (result.isConfirmed) {
         formData.append('action', "actualizar");
         fetch('actions/orden_compras.php', {
           method: 'POST',
           body: formData
         }) .then(response => {
          if (!response.ok) {
              return response.json().then(errorData => {
                  throw new Error('Error en la solicitud. Código de estado: ' + response.status + ', Tipo de error: ' + errorData.error + ', Mensaje: ' + errorData.message);
              });
          }
          return response.json(); // Suponiendo que la respuesta es JSON
      })
       .then(data => {
           if (data.success == true) {
            formulario.classList.remove('was-validated');
            formulario.reset(); //se limpia el formulario
            document.getElementById("popup").style.display = "none";//estilo para ocultar el popup
            getOrdenesCompra(); //se recarga la tabla 
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


function eliminar(idOrdenCompra){
 console.log(idOrdenCompra)
  Swal.fire({
    title: '¿Desea eliminar el registros de la orden de compra?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, registrar'
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
        formData.append('idOrdenCompra', idOrdenCompra);
        formData.append('action', "eliminar");

        fetch('actions/orden_compras.php', {
          method: 'POST',
          body: formData
        })
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
             const row = document.querySelector(`#tablaOrdenesCompra tr[data-id='${idOrdenCompra}']`);
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

// Función para abrir el modal con el select de estado
function abrirModalEstado(idOrdenCompra, estadoActual) {
  /*
  // Obtener el modal y el select
  const modal = new bootstrap.Modal(document.getElementById('modalEstado'));
  const selectEstado = document.getElementById('selectEstado');

  // Asignar el valor actual del estado al select
  selectEstado.value = estadoActual;

  // Mostrar el modal
  modal.show();

  // Agregar un evento de clic al botón de guardar en el modal
  document.getElementById('btnGuardarEstado').addEventListener('click', function() {
    const nuevoEstado = selectEstado.value;

    // Realizar la solicitud para actualizar el estado en la base de datos
    actualizarEstado(idOrdenCompra, nuevoEstado);

    // Cerrar el modal
    modal.hide();
  });
  */
 console.log('mmmmm');
}

// Adjuntar evento de clic a cada celda de estado para abrir el modal
document.querySelectorAll('#tablaOrdenesCompra .estado').forEach(celda => {
  celda.addEventListener('click', function() {
    const idOrdenCompra = this.parentNode.dataset.id;
    const estadoActual = this.innerHTML;
    abrirModalEstado(idOrdenCompra, estadoActual);
  });
});
