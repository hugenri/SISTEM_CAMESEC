document.addEventListener("DOMContentLoaded", function () {
    getOrdenesCompras(); // Llama a la función cuando la página esté cargada
});

function getOrdenesCompras() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos

    let datos = new FormData();
       datos.append('action', "mostarOrdenesCompras");


  fetch('actions/compras.php', {
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
                  <th class="text-nowrap">Estado</th>
                  <th  colspan="3">Acciones</th>


              </tr></thead>`;
              tabla += `<tbody>`;
              for (let x of data.datosOrdenesCompras) {
                  tabla += `<tr data-id="${x.idOrdenCompra}">
                      <td class="text-nowrap">${x.idOrdenCompra}</td>
                      <td class="text-nowrap">${x.fecha}</td>
                      <td>${x.observaciones}</td>
                      <td>${x.descripcion}</td>
                      <td class="text-nowrap  data-estado="${['x.idOrdenCompra']}">${x.estado}</td>
                      <td><button class="btn btn-primary rounded-3 btn-sm" onclick="abrirModal(${x.idOrdenCompra})">Ver</button></td>

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

function abrirModal(id){
    // Mostrar el formulario
    document.getElementById("modalPopup").style.display = "block";
    get_orden_compra(id);
   
   }
   
   function cerrarModal(evento){
    evento.preventDefault();

document.getElementById("modalPopup").style.display = "none";

}

function get_orden_compra(id){
    let  idOrdenCompra = id;
    let idCotizacion;
    const formData = new FormData();
        formData.append('idOrdenCompra', id);
       formData.append('action', 'getOrdenCompra');
      
        fetch('actions/compras.php', {
          method: 'POST',
          body: formData
        })
  .then(response => response.json())
  .then(data => {
    // Insertar los datos del cliente
    document.getElementById('cliente').textContent =  data.datosOrdenCompra[0].nombre_cliente;
    document.getElementById('email_cliente').textContent = data.datosOrdenCompra[0].email_cliente;
    document.getElementById('telefono_cliente').textContent = data.datosOrdenCompra[0].telefono_cliente;
    // Insertar el servicio ofrecido
    document.getElementById('servicio').textContent = data.datosOrdenCompra[0].servicio_ofrecido;
    idCotizacion =  data.datosOrdenCompra[0].idCotizacion;
    // Insertar los datos del producto en la tabla
    const productos = data.datosOrdenCompra;
    const filaProductos = productos.map(producto => `
      <tr>
        <td>${producto.nombre_producto}</td>
        <td>${producto.precio_unitario}</td>
        <td>${producto.cantidad_comprar}</td>
        <td>${producto.nombre_proveedor}</td>
        <td>${producto.email_proveedor}</td>
        <td>${producto.telefono_proveedor}</td>
      </tr>
    `).join('');
    document.getElementById('tablaOrdenCompra').querySelector('tbody').innerHTML = filaProductos;
    // Ocultar el botón "Finalizada" si el estado es "finalizada"
    console.log(data.datosOrdenCompra[0].estado);
    if (data.datosOrdenCompra[0].estado === 'finalizada') {
        document.getElementById('finalizarBtn').style.display = 'none';
    } else {
        document.getElementById('finalizarBtn').style.display = 'block';
    }

    // Asignar el ID a los botones
    document.getElementById('finalizarBtn').dataset.idOrdenCompra= idOrdenCompra;
    document.getElementById('finalizarBtn').dataset.idCotizacion = idCotizacion;
})

  .catch(error => console.error('Error:', error));
}

function cambiarEstado(evento, estado, idOrdenCompra, idCotizacion){
    evento.preventDefault();
    const datos = new FormData();
    datos.append('idOrdenCompra', idOrdenCompra);
    datos.append('idCotizacion', idCotizacion);
    datos.append('estado', estado);
    datos.append('action', 'setEstado');

    Swal.fire({
      title: '¿Desea establecer la orden de compra como '+estado+'?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, registrar'
    }).then((result) => {
      if (result.isConfirmed) {
    fetch('actions/compras.php', {
        method: 'POST',
        body: datos
    }).then(response => response.json())
    .then(data => {
        if (data.success == true) {
          Swal.fire({
            title: 'Éxito',
            text: data.message,
            icon: 'success'
        });
        getOrdenesCompras();
        cerrarModal(evento);
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