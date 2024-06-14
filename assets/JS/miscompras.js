document.addEventListener('DOMContentLoaded', function() {
    get_compras();
});


 
function get_compras(){

    const comprasContainer = document.getElementById("comprasContainer");
    comprasContainer.innerHTML = "";
    let formData = new FormData();
    formData.append("action", "mostarCompras");
    
    fetch("actions/mis_compras.php", {
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
     .then(response => response.json())
     .then(data => {
       if (data.success) {
       data.datos.forEach(dato => {
         const card = `
           <div class="col">
             <div class="card card-customServicios">
               <div class="card-body">
                 <h5 class="card-title">Servicio: Venta de Productos</h5>
                 <p class="card-text">Fecha de compra: ${dato.fecha_venta}</p>
                 <p class="card-text">Total de la compra: $ ${dato.total}</p>
                 <p class="card-text">IVA: $${dato.iva}</p>
                <p class="card-text">Total + IVA: $${dato.total_con_iva}</p>
                 <p class="card-text">Estado de la compra: ${dato.estado}</p>
                <p class="card-text">Fecha de entrega: ${dato.fecha_entrega}</p>
                 <div class="row justify-content-between mt-4 mb-3">
                    <div class="col-12">
                 <button type="button" class="btn btn-primary
                  w-100 rounded-5" onclick="abrirModal(${dato.id_venta})">Ver compra</button>
                 </div>
                 </div>
                 </div>
             </div>
           </div>
         `;
         comprasContainer.innerHTML += card;
       });
         }else{
            comprasContainer.innerHTML = "<h4>No tiene compras realizadas.</h4>";
         }
     }).catch(error => console.error("Error al obtener los datos:", error));
    }

    function abrirModal(id){
      // Mostrar el formulario
      document.getElementById("modalPopup").style.display = "block";
      get_orden_compra(id);
     
     }
     
     function cerrarModal(evento){
      evento.preventDefault();
  
  document.getElementById("modalPopup").style.display = "none";
  get_compras();
  }

 
  function get_orden_compra(id){
  
    const comprasContainer = document.getElementById("comprasContainer");
    comprasContainer.innerHTML = "";
    let formData = new FormData();
    formData.append("action", "getCompra");
    formData.append("idVenta", id);

    
    fetch("actions/mis_compras.php", {
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
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
       if (data.success) {
        mostrarVentas(data.datos);
         }else{
            console.log(data.message);
         }
     }).catch(error => console.error("Error al obtener los datos:", error));
    }


function mostrarVentas(ventas) {

    let direccion = ventas[0].direccion_completa;
    document.getElementById('venta-id').textContent = 'Venta ID: ' + ventas[0].id_venta;
    document.getElementById('fecha-venta').textContent = 'Fecha de Venta: ' + ventas[0].fecha_venta;
    document.getElementById('total-venta').textContent = 'Total: ' + ventas[0].total;
    document.getElementById('iva').textContent = 'IVA: ' + ventas[0].iva;
    document.getElementById('total-iva').textContent = 'Total + IVA: ' + ventas[0].total_con_iva;

    document.getElementById('fecha-pago').textContent = 'Fecha de Pago: ' + ventas[0].fecha_pago;
    document.getElementById('metodo-pago').textContent = 'Método de Pago: ' + ventas[0].metodo_pago;
   // document.getElementById('estado-pago').textContent = 'Pago realizado: ' + ventas[0].pago;
    document.getElementById('direccion-envio').textContent = 'Dirección de Envío: '  + direccion;
    document.getElementById('fecha-entrega').textContent = 'Fecha de Entrega Estimada: ' + ventas[0].fecha_entrega ;
    document.getElementById('estado-entrega').textContent = 'Estado de Entrega: ' + ventas[0].estado;

    
  // Asumiendo que 'ventas' contiene solo una venta
  const estadoPagoElement = document.getElementById('estado-pago');
  const pagoRealizado = ventas[0].pago.toLowerCase() === 'si';

  if (pagoRealizado) {
    estadoPagoElement.textContent = 'Pago realizado: ' + ventas[0].pago;
   } else {
    estadoPagoElement.innerHTML = `Pago no realizado:  <a href="pago.php?idVenta=${ ventas[0].id_venta}">Realizar pago</a>`;
  }
    let productosLista = document.getElementById('productos-lista');
    productosLista.innerHTML = ''; // Limpiar cualquier contenido previo

    ventas.forEach(venta => {
        let productoHtml = `
            <div class="producto border-bottom pb-2 mb-3 mt-4">
            <div class="row">
                <div class="col-6">
                    <img src="assets/images/productos/${venta.imagen}" alt="Imagen del producto" class="img-fluid product-image">
                </div>
                <div class="col-6">

                <h6 class="mb-0">Producto: ${venta.nombre_producto}</h6>
                <p class="mb-0">Precio: ${venta.precio}</p>
                <p>Cantidad: ${venta.cantidad}</p>
                
             </div>
            </div>
            </div>

        `;
        productosLista.innerHTML += productoHtml;
    });
}

