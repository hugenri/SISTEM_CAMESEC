
document.addEventListener("DOMContentLoaded", function () {
  mostrarSolicitudCotizaciones(); // Llama a la función cuando la página esté cargada
});


function mostrarSolicitudCotizaciones() {
    if (document.getElementById("NoData").innerHTML.trim() !== "") {
        document.getElementById("NoData").innerHTML = "";
    }
let formData = new FormData();
formData.append('action', 'mostarSolicitudes');

  fetch("actions/solicitudes_cotizacion.php", {
    method: 'POST', // Especifica que la solicitud sea POst
    body: formData  // Usar el objeto FormData como cuerpo de la solicitud
   }).
   then(response => {
    if (!response.ok) {
        return response.json().then(errorData => {
            throw new Error('Error en la solicitud. Código de estado: ' + response.status + ', Tipo de error: ' + errorData.error + ', Mensaje: ' + errorData.message);
        });
    }
    return response.json(); // Suponiendo que la respuesta es JSON
})
      .then(data => { 
          if (data.success == true) {
              document.getElementById("tabla").innerHTML = ""; // Limpiamos la tabla
              let tabla = `<thead>
              <tr>
              <th class="text-nowrap">ID</th>
              <th class="text-nowrap">Cliente</th>
              <th class="text-nowrap">Servicio</th>
                  <th class="text-nowrap">Fecha de Solicitud</th>
                  <th class="text-nowrap">Estado</th>
                  <th class="text-nowrap" colspan="2">Acciones</th>
                  </tr>
                  </thead>`;
            tabla += `<tbody>`;
            for (let dato of data.dataSolicitud) {
                // Verifica si el estado es diferente de "En proceso"
                if (dato.estado == 'en proceso') {
                  // Si el estado es diferente, se habilita el botón de cotizar
                  cotizarButton = `<td><button class="bCotizar btn custom-button btn-primary btn-sm" data-id="${dato.id}" onclick="cargarForm()">Cotizar</button></td>`;
                 //cotizarButton = `<td><button class="bCotizar btn custom-button btn-primary btn-sm" data-id="${dato.id}" onclick="cotizar()">Cotizar</button></td>`;
                } else {
                     // Si el estado es "En proceso", se deja el espacio vacío
                    cotizarButton = `<td></td>`;
                   }
                  tabla += `<tr data-id="${dato.id}">   
                 <td class="text-nowrap">${dato.id}</td>
                 <td class="text-nowrap">${dato.cliente_razon_social}</td>
                      <td class="text-nowrap">${dato.servicio}</td>
                      <td class="text-nowrap">${dato.fecha_solicitud}</td>
                      <td class="text-nowrap">${dato.estado}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${dato.id}" onclick="eliminar('${dato.id}')">Eliminar</button></td>
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

/************************ */

// Función para cargar formulario
function cargarForm() {
    const botones = document.querySelectorAll(".bCotizar");

    botones.forEach(boton => {
        boton.addEventListener("click", function () {
            let id = this.dataset.id;
            // Mostrar el formulario
            document.getElementById("popup").style.display = "block";
            
        });
    });
  }
 /**************************************** */
 /********************* */
//cargar los productos al select
function cargarProductos() {
    let selectProductos = document.getElementById('selectProductos');
     // Eliminar todas las opciones del select
     selectProductos.innerHTML = '';
     //Crear la opción "Seleccionar producto"
   var option = document.createElement('option');
   option.value = ''; // Establecer el valor de la opción (en este caso, vacío)
   option.textContent = 'Seleccionar producto'; // Establecer el texto visible de la opción
   // Agregar la opción al principio del select
   selectProductos.insertBefore(option, selectProductos.firstChild);
   fetch('actions/verproductos.php')
       .then(response => response.json())
       .then(data => {
           data.dataProduct.forEach(producto => {
               var option = document.createElement('option');
               option.value = producto.id;
               option.textContent = producto.nombre;
               selectProductos.appendChild(option);
           });
       })
       .catch(error => {
           console.error('Error al obtener los productos:', error);
       });
   }

 /************************* */

 
//funcion para agregar el producto a la lista
function agregar_Alista_producto() {
    // Obtener el valor seleccionado del select
    let productId = document.getElementById('selectProductos').value;
    console.log(productId);
   // Obtener la cantidad ingresada en el input
   let  quantity = document.getElementById('cantidad').value;
    // Construir un objeto FormData para enviar los datos
    console.log(quantity);

    var formData = new FormData();
    formData.append('action', 'addToListProduct');
    formData.append('id', productId);
    formData.append('quantity', quantity);

    // Utiliza Fetch para enviar la acción al servidor
    fetch('actions/solicitudes_cotizacion.php', {
        method: 'POST',
        body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(errorData => {
                throw new Error('Error en la solicitud. Código de estado: ' + response.status + ', Tipo de error: ' + errorData.error + ', Mensaje: ' + errorData.message);
            });
        }
        return response.json(); // Suponiendo que la respuesta es JSON
    })
    .then(data => {
          // Manejar la respuesta del servidor
        if (data.status === 'success') {
            alert(data.message);
          console.log('zzzzz');
        }
        
    })
    .catch(error => {
        // Manejar errores de la solicitud
        console.error('Error:', error);
    });
}

