//assets\JS\get_nuevas_facturas.js

function mostrarDatosCotizacion(idCotizacion) {

    let formData = new FormData();
    formData.append("action", "cargarDatosCotizacion");
    formData.append("idCotizacion", idCotizacion);

    // Obtener las cotizaciones
    fetch('actions/actualizar_cotizacion.php',{
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
          //  const datosProducto = document.getElementById('datosProducto');
            //datosProducto.innerHTML = ''; // Limpiar el contenido anterior
            const cotizacion = data.datosCotizacion[0]; // Suponiendo que solo hay un servicio en la respuesta
           document.getElementById('nombreCliente').innerText = "Cliente: " +cotizacion.nombreCliente;
           document.getElementById('fecha').value = cotizacion.fecha;
           document.getElementById('costoInstalacion').value = cotizacion.costo_instalacion;
           document.getElementById('descuento').value =  cotizacion.descuento;
           document.getElementById('descripcion').value = cotizacion.descripcion;
           document.getElementById('observaciones').value = cotizacion.observaciones;
          // document.querySelector('.invoice-instalacion').textContent = cotizacion.costo_instalacion;
           //document.querySelector('.invoice-instalacion').textContent = cotizacion.costo_instalacion;
           calcularTotal();
           //agregarProductosContenedor(data.datosCotizacion, 'ItemsContent');

        } else {
            console.log(data.message);
        }
    })
    .catch(error => {
        console.error(error);
    });
}


// Función para cargar formulario
function cargarForm(idCotizacion) {

    mostrarDatosCotizacion(idCotizacion);
    cargarDatosProducto();
    document.getElementById("modalPopup").style.display = "block";
}

/********************* */
/*
function agregarProductosContenedor(items, container) {
    let containerElement = document.getElementById(container);
    containerElement.innerHTML = '';
   // Verificar si items está definido y tiene elementos
   
    if (items && items.length > 0) {
    items.forEach(item => {
        console.log(item.imagen);
        const productElement = document.createElement('div');
        productElement.classList.add('cart-item');
        productElement.innerHTML = `
            <div class="row">
                <div class="col-3">
                    <img src="assets/images/productos/${item.imagen}" alt="${item.nombreProducto}" class="img-fluid">
                </div>
                <div class="col-6">
                    <p>${item.nombreProducto}</p>
                    <p>Cantidad: ${item.cantidad}</p>
                    <p>Precio unitario: $${item.precio}</p>
                </div>
                <div class="col-3">
                <button class="btn btn-sm btn-danger removeItemBtn rounded-pill" onclick="eliminar_item(event, '${item.idProducto}')">Eliminar</button>
                </div>
            </div>
            <hr>
        `;
        containerElement.appendChild(productElement);
        
    });
    calculosCotizacion(items);

} else {
    // Si no hay elementos en items, puedes mostrar un mensaje o realizar otra acción
    containerElement.innerHTML = '<p>No hay productos disponibles.</p>';
}
}
*/
/********************************* */

function cargarDatosProducto(){
    
    // Construir un objeto FormData para enviar los datos
     var formData = new FormData();
     formData.append('action', 'cargarDatosProductos');
   fetch("actions/actualizar_cotizacion.php", {
     method: 'POST', // Especifica que la solicitud sea POst
     body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
       .then(data => { 
           if (data.success == true) {
             const items = data.productos;

             agregarProductosAlContenedor(items, 'ItemsContent');
         }else{
             console.log(data.message);
         }
       })
       .catch(error => {
           console.error('Error:', error);
       });
 }
 

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
function agregar_Alista_producto(){
    
   // Obtener el valor seleccionado del select
    let productId = document.getElementById('selectProductos').value;
   // Obtener la cantidad ingresada en el input
   let  quantity = document.getElementById('cantidad').value;

    // Construir un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append('action', 'addListProduct');
    formData.append('id', productId);
    formData.append('quantity', quantity);
  fetch("actions/guardar_producto_en_lista.php", {
    method: 'POST', // Especifica que la solicitud sea POst
    body: formData  // Usar el objeto FormData como cuerpo de la solicitud
   })
   .then(response => response.json())
      .then(data => { 
          if (data.success == true) {
            const items = data.items;
            
            agregarProductosAlContenedor(items, 'ItemsContent');
        }else{
            console.log(data.message);
        }
      })
      .catch(error => {
          console.error('Error:', error);
      });
}

/**************************** */
function agregarProductosAlContenedor(items, container) {
    let containerElement = document.getElementById(container);
    containerElement.innerHTML = '';
   // Verificar si items está definido y tiene elementos
    if (items && items.length > 0) {
    items.forEach(item => {
        const productElement = document.createElement('div');
        productElement.classList.add('cart-item');
        productElement.innerHTML = `
            <div class="row">
                <div class="col-3">
                    <img src="assets/images/productos/${item.imagen}" alt="${item.name}" class="img-fluid">
                </div>
                <div class="col-6">
                    <p>${item.name}</p>
                    <p>Cantidad: ${item.qty}</p>
                    <p>Precio unitario: $${item.price}</p>
                </div>
                <div class="col-3">
                <button class="btn btn-sm btn-danger removeItemBtn rounded-pill" onclick="eliminar_item(event, '${item.rowid}')">Eliminar</button>
                </div>
            </div>
            <hr>
        `;
        containerElement.appendChild(productElement);
        
    });
    calculosCotizacion(items);

} else {
    // Si no hay elementos en items, puedes mostrar un mensaje o realizar otra acción
    containerElement.innerHTML = '<p>No hay productos disponibles.</p>';
}
}
document.getElementById("costoInstalacion").addEventListener("change", function(event) {
    // Aquí puedes realizar los cálculos necesarios cuando se sale del campo de costo de instalación
    calcularTotal();
});

document.getElementById("descuento").addEventListener("change", function(event) {
    // Aquí puedes realizar los cálculos necesarios cuando se sale del campo de descuento
    calcularTotal();
});

function calcularTotal() {
    // Obtener los valores actuales de costo de instalación y descuento
    let costoInstalacion = parseFloat(document.getElementById("costoInstalacion").value) || 0;
    let porcentajeDescuento = parseInt(document.getElementById("descuento").value) || 0; // Cambiado a parseInt
    let sub_totalProductos = parseFloat(document.querySelector('.invoice-prroductos').textContent) || 0;
    document.querySelector('.invoice-porcentajeDescuento').textContent = porcentajeDescuento.toFixed(0); // Cambiado a toFixed(0)
    document.querySelector('.invoice-instalacion').textContent = costoInstalacion.toFixed(2);
   
    if (isNaN(porcentajeDescuento)) {
        porcentajeDescuento = 0;
    }
    
    // Calcular el subtotal sumando el costo de instalación al subtotal actual solo si no se ha sumado antes
    let subtotal = sub_totalProductos + costoInstalacion;
    
    // Calcular el descuento en cantidad
    const descuento = (porcentajeDescuento / 100) * subtotal;

    // Calcular el IVA
    const iva = subtotal * 0.16;
    
    // Calcular el total incluyendo el descuento
    const totalIva = (subtotal - descuento)+ iva;
    
    // Actualizar los elementos en el HTML con los nuevos valores
    document.querySelector('.invoice-sub-total').textContent = subtotal.toFixed(2);
    document.querySelector('.invoice-discount').textContent = descuento.toFixed(2);
    document.querySelector('.invoice-vat').textContent = iva.toFixed(2);
    document.querySelector('.invoice-total').textContent = totalIva.toFixed(2);
}





function calculosCotizacion(items){
    
     // Calcula el total de la compra y muestra el total y el IVA
     const totalPrice = calculateTotalPrice(items);
     document.querySelector('.invoice-prroductos').textContent = `${totalPrice.total}`;
     document.querySelector('.invoice-vat').textContent = `${totalPrice.tax}`;
     document.querySelector('.invoice-total').textContent = `${totalPrice.totalIva}`;
     calcularTotal();
    }
// Función para calcular el total de la compra y el IVA
function calculateTotalPrice(items) {
    let total = 0;
    items.forEach(item => {
        total += item.price * item.qty;
    });
    const tax = total * 0.16; // Suponiendo un IVA del 16%
    let totalIva = total + tax;
    return { total: total.toFixed(2), tax: tax.toFixed(2), totalIva: totalIva.toFixed(2) };
}

 function eliminar_item(event, id) {
    event.preventDefault(); // Prevenir el envío del formulario
    var formData = new FormData();
    formData.append('action', 'eliminarItem');
    formData.append('rowid', id);
    
  fetch("actions/solicitudes_cotizacion.php", {
    method: 'POST', // Especifica que la solicitud sea POst
    body: formData  // Usar el objeto FormData como cuerpo de la solicitud
   })
   .then(response => response.json())
      .then(data => { 
          if (data.success == true) {
            agregarProductosAlContenedor(data.items, 'ItemsContent');


        }else{
            document.getElementById('ItemsContent').innerHTML = '<p>No hay productos.</p>';
            limpiarDatos();
            calcularTotal();
        }
      })
      .catch(error => {
          console.error('Error:', error);
      });
}

function limpiarDatos(){

            document.querySelector('.invoice-sub-total').textContent = '0.0';
            document.querySelector('.invoice-vat').textContent = '0.0';
            document.querySelector('.invoice-total').textContent = '0.0';
            //document.querySelector('.invoice-discount').textContent = '0.0';
}

/****************************** */

function limpiarDatos() {
    const formulario = document.getElementById("form");
    // Elimina las clases de validación de Bootstrap
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function(form) {
        form.classList.remove('was-validated');
    });
    formulario.reset(); // Se limpia el formulario     
    // Limpiar elementos de totales
    document.getElementById("costo-instalacion").innerHTML = "Instalación: $<span class='invoice-instalacion'>0.00</span>";
    document.getElementById("porcentaje-descuento").innerHTML = "Descuento: %<span class='invoice-porcentajeDescuento'>0</span>";
    document.getElementById("Productos").innerHTML = "Productos $<span class='invoice-prroductos'>0.00</span>";
    document.getElementById("subTotal").innerHTML = "Subtotal: $<span class='invoice-sub-total'>0.00</span>";
    document.getElementById("totaldescuento").innerHTML = "Descuento: $<span class='invoice-discount'>0.00</span>";
    document.getElementById("iva").innerHTML = "IVA: $<span class='invoice-vat'>0.00</span>";
    document.getElementById("total-iva").innerHTML = "Total: $<span class='invoice-total'>0.00</span>";
}


function eliminar_items(){
    
    //Definir formData 
    const formData = new FormData();
    formData.append('action', 'eliminarItems');

    // Utiliza Fetch para enviar la acción al servidor
    fetch('actions/solicitudes_cotizacion.php', {
        method: 'POST',
        body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(data.message);
        } else {
            console.error(data.message);
        }
    })
    .catch(error => console.error('Error al eliminar', error));
}

 // Selecciona el botón para abrir el modal
 let btnAbrirModal = document.getElementById('btnAbrirModal');
 let btCargarProducto = document.getElementById('btCargarProducto');
 // Selecciona el modal
 var modalProducto = document.getElementById('ModalProducto');

 // Agrega un listener al botón para abrir el modal
btnAbrirModal.addEventListener('click', function() {

abrirModal('ModalProducto');


 });
 
btCargarProducto.addEventListener('click', function() {  
// Obtener el valor seleccionado del select
let productId = document.getElementById('selectProductos').value;
// Obtener la cantidad ingresada en el input
let  quantity = document.getElementById('cantidad').value;

 // Validar que ambos campos tengan datos
 if (productId.trim() === '' || quantity.trim() === '') {
     // Si uno o ambos campos están vacíos, muestra un mensaje de error con SweetAlert2
     Swal.fire({
         icon: 'error',
         title: 'Oops...',
         text: 'Por favor completa todos los campos.',
     });
 } else {
     agregar_Alista_producto();
 cerrarModal('ModalProducto');
 }

});
 // Cierra el modal si se hace clic fuera de él
 modalProducto.addEventListener('click', function(event) {
     if (event.target === modalProducto) {
         modalProducto.classList.remove('show');
         modalProducto.style.display = 'none';
         modalProducto.setAttribute('aria-modal', 'false');
         modalProducto.setAttribute('aria-hidden', 'true');
     }
 });
 // Función para abrir el modal
function abrirModal(modalId) {
 var modal = document.getElementById(modalId);
 modal.classList.add('show');
 modal.style.display = 'block';
 modal.setAttribute('aria-modal', 'true');
 modal.setAttribute('aria-hidden', 'false');
 cargarProductos(); // Llama a la función al abrir el modal
}

// Función para cerrar el modal
function cerrarModal(modalId) {
 var modal = document.getElementById(modalId);
 modal.classList.remove('show');
 modal.style.display = 'none';
 modal.setAttribute('aria-modal', 'false');
 modal.setAttribute('aria-hidden', 'true');
}
function cerrarPopup(){
 let containerElement = document.getElementById('ItemsContent');
containerElement.innerHTML = '';
 document.getElementById("modalPopup").style.display = "none";
 eliminar_items();


}