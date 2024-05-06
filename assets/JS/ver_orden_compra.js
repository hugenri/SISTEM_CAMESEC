function verOrdenCompra(id){
 // Mostrar el formulario
 document.getElementById("modalPopup").style.display = "block";
 get_orden_compra(id)

}

function get_orden_compra(id){
    let  idCotizacion;
    const formData = new FormData();
        formData.append('idOrdenCompra', id);
      
        fetch('actions/get_orden_compra.php', {
          method: 'POST',
          body: formData
        })
  .then(response => response.json())
  .then(data => {
    // Insertar los datos del cliente
    document.getElementById('cliente').textContent = "Cliente: "+ data.datosOrdenCompra[0].nombre_cliente;
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
    // Asignar el ID a los botones
    document.getElementById('cancelarBtn').dataset.id = id;
    document.getElementById('finalizarBtn').dataset.id = id;
    document.getElementById('cancelarBtn').dataset.idCotizacion = idCotizacion;
    document.getElementById('finalizarBtn').dataset.idCotizacion = idCotizacion;
})

  .catch(error => console.error('Error:', error));
}


function cerrarModal(evento){
        evento.preventDefault();

    document.getElementById("modalPopup").style.display = "none";

}

function cambiarEstado(evento, estado, idOrdenCompra, idCotizacion){
    evento.preventDefault();
    const datos = new FormData();
    datos.append('idOrdenCompra', idOrdenCompra);
    datos.append('estado', estado);
    datos.append('idCotizacion', idCotizacion);
  
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
    fetch('actions/set_estado_ordenCompra.php', {
        method: 'POST',
        body: datos
    }).then(response => {
      if (!response.ok) {
          return response.json().then(errorData => {
              throw new Error('Error en la solicitud. Código de estado: ' + response.status + ', Tipo de error: ' + errorData.error + ', Mensaje: ' + errorData.message);
          });
      }
      return response.json(); // Suponiendo que la respuesta es JSON
  })
    .then(data => {
        if (data.success == true) {
          Swal.fire({
            title: 'Éxito',
            text: data.message,
            icon: 'success'
        });
        getOrdenesCompra();
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

