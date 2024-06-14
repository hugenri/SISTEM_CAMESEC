document.addEventListener("DOMContentLoaded", function () {
    getOrdenesCompras(); // Llama a la función cuando la página esté cargada
});

function getOrdenesCompras() {
  document.getElementById("NoData").innerHTML = ""; // Limpiamos el mensaje de no hay datos

    let datos = new FormData();
       datos.append('action', "mostar_productos");


  fetch('actions/compra_productos.php', {
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
                  <th class="text-nowrap">ID Venta</th>
                  <th class="text-nowrap">Fecha venta</th>
                  <th class="text-nowrap">Cliente</th>
                  <th class="text-nowrap">Pago de la venta</th>
                  <th  colspan="2">Acciones</th>


              </tr></thead>`;
              tabla += `<tbody>`;
              for (let x of data.datosOrdenesCompras) {
                  tabla += `<tr data-id="${x.id_venta}">
                <td class="text-nowrap">${x.id_venta}</td>
                      <td class="text-nowrap">${x.fecha_venta}</td>
                      <td class="text-nowrap">${x.cliente_razon_social}</td>
                      <td>${x.pago}</td>
                      <td><button class="btn btn-primary rounded-3 btn-sm" onclick="abrirModal(${x.id_venta})">Ver</button></td>
                      <td><button class="btn btn-primary rounded-3 btn-sm" onclick="exportarPDF(${x.id_venta})">PDF</button></td>

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
    
    const formData = new FormData();
        formData.append('idVenta', id);
       formData.append('action', 'getOrdenCompra');
      
        fetch('actions/compra_productos.php', {
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
    document.getElementById('servicio').textContent = 'Venta de productos';
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
    // Asignar el ID a los botones
    document.getElementById('finalizarBtn').dataset.idVenta = id;
    

})

  .catch(error => console.error('Error:', error));
}

function cambiarEstado(evento, idVenta){
    evento.preventDefault();
    const datos = new FormData();
    datos.append('idVenta', idVenta);
    datos.append('action', 'setEstado');

    Swal.fire({
      title: '¿Desea establecer la orden de compra como terminada?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, acepto'
    }).then((result) => {
      if (result.isConfirmed) {
    fetch('actions/compra_productos.php', {
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

  function exportarPDF(idVenta) {
    // Construir la URL con el parámetro idVenta
    const pdfUrl = `actions/compra_productosPdf.php?idVenta=${idVenta}`;
    // Abrir la URL en una nueva pestaña
    window.open(pdfUrl, '_blank');
}


/*
  function exportarPDF(idVenta) {
    let formData = new FormData();
    formData.append("idVenta", idVenta);

    // Obtener las cotizaciones
    fetch('actions/compra_productosPdf.php',{
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
   
    })
    .then(response => response.blob())
    .then(blob => {
        // Crear una URL para el blob del PDF
        const url = window.URL.createObjectURL(new Blob([blob]));

        // Abrir el PDF en una nueva pestaña o ventana del navegador
        window.open(url, '_blank');

        // Liberar la URL creada
        window.URL.revokeObjectURL(url);
    })
    .catch(error => console.error('Error:', error));
}
*/