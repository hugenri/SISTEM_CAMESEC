
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
                /*
                // Verifica si el estado es diferente de "En proceso"
                if (dato.estado == 'en proceso') {
    
                  // Si el estado es diferente, se habilita el botón de cotizar
                  cotizarButton = `<td><button class="bCotizar btn custom-button btn-primary btn-sm" data-id="${dato.id}"  onclick="cargarForm('${dato.id_cliente}')">Cotizar</button></td>`;
                  //cotizarButton = `<td><button class="bCotizar btn custom-button btn-primary btn-sm" data-id="${dato.id}" onclick="cotizar()">Cotizar</button></td>`;
                } else {
                     // Si el estado es "En proceso", se deja el espacio vacío
                    cotizarButton = `<td></td>`;
                   }
                   */
                   tabla += `<tr data-id="${dato.id}">
                        <td class="text-nowrap">${dato.id}</td>
                        <td class="text-nowrap">${dato.cliente_razon_social}</td>
                      <td class="text-nowrap">${dato.servicio}</td>
                      <td class="text-nowrap">${dato.fecha_solicitud}</td>
                      <td class="text-nowrap">${dato.estado}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${dato.id}" onclick="eliminar('${dato.id}')">Eliminar</button></td>
                      <td><button class="bCotizar btn custom-button btn-primary btn-sm" data-id="${dato.id}"  onclick="cargarForm('${dato.id_cliente}')">Cotizar</button></td>
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
 function cargarForm(idCliente) {
    limpiarDatos();
    const botones = document.querySelectorAll(".bCotizar");
    botones.forEach(boton => {
        boton.addEventListener("click", function () {
            let id = this.dataset.id;
            
            document.getElementById("popup").style.display = "block";
            // Obtener la fila de la tabla
            let fila = document.querySelector(`#tabla tr[data-id='${id}']`);
            let celdas = fila.getElementsByTagName("td");
            // Obtener el nombre del cliente (razón social)
            let razonSocial = celdas[1].textContent;

            // Asignar valores a los campos del formulario
            document.getElementById("nombreServicio").value = celdas[2].textContent;
            document.getElementById("id").value = id;
           document.getElementById("idCliente").value = idCliente;
            
            // Asignar el valor al elemento <p>
            document.getElementById("nombreCliente").textContent = "Cliente: " + razonSocial;
            // Mostrar el formulario
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
    formData.append('action', 'addListProduct');
    formData.append('rowid', id);
    
  fetch("actions/eliminar_item.php", {
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