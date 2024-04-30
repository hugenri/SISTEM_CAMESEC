function verOrdenCompra(id){
 // Mostrar el formulario
 document.getElementById("modalPopup").style.display = "block";
 get_orden_compra(id)

}

function get_orden_compra(id){

    const formData = new FormData();
        formData.append('id', id);
      
        fetch('actions/get_orden_compra.php', {
          method: 'POST',
          body: formData
        })
  .then(response => response.json())
  .then(data => {
      console.log(data);
    // Insertar los datos del cliente
    document.getElementById('cliente').textContent = "Cliente: "+ data.datosOrdenCompra[0].nombre_cliente;
    document.getElementById('email_cliente').textContent = data.datosOrdenCompra[0].email_cliente;
    document.getElementById('telefono_cliente').textContent = data.datosOrdenCompra[0].telefono_cliente;
    
    // Insertar el servicio ofrecido
    document.getElementById('servicio').textContent = data.datosOrdenCompra[0].servicio_ofrecido;
    
    // Insertar los datos del producto en la tabla
    const productos = data.datosOrdenCompra;
    const filaProductos = productos.map(producto => `
      <tr>
        <td>${producto.nombre_producto}</td>
        <td>${producto.descripcion_producto}</td>
        <td>${producto.precio_unitario}</td>
        <td>${producto.cantidad_comprar}</td>
        <td>${producto.nombre_proveedor}</td>
        <td>${producto.email_proveedor}</td>
        <td>${producto.telefono_proveedor}</td>
      </tr>
    `).join('');
    document.getElementById('tablaOrdenCompra').querySelector('tbody').innerHTML = filaProductos;
})
  .catch(error => console.error('Error:', error));
}