document.addEventListener('DOMContentLoaded', function () {
    const cartItemsContainer = document.getElementById('cart-items');

    // Construir un objeto FormData para enviar los datos
   var formData = new FormData();
   formData.append('action', 'mostarProductos');

   // Utiliza Fetch para enviar la acción al servidor
   fetch('actions/venta.php', {
       method: 'POST',
       body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
   })
        .then(response => response.json())
        .then(products => {
            // Itera sobre los productos y crea tarjetas usando Bootstrap
            products.forEach(product => {
				
                const card = createProductCard(product);
                cartItemsContainer.appendChild(card);
            });
        })
        .catch(error => console.error('Error al obtener productos:', error));

    // Función para crear una tarjeta de producto usando Bootstrap
    function createProductCard(product) {
        const card = document.createElement('div');
        card.className = 'col-md-3 mb-4';

        card.innerHTML = `
            <div class="card  custom-card mb-2">
                <img src="assets/images/productos/${product.imagen}" class="card-img-top align-self-center" alt="${product.imagen}" style="margin: 10px; width: 100px; height: 100px; object-fit: cover;">                
                <div class="card-body">
                    <h5 class="card-title">${product.nombre}</h5>
                    <p class="card-text">$${product.precio}</p>
                    <a href="#" class="btn btn-success d-block mx-auto addToCartBtn" data-product-id="${product.id}">Agregar al Carrito</a>
                </div>
            </div>
        `;

        // Añade un evento de clic al botón "Agregar al Carrito"
        const addToCartBtn = card.querySelector('.addToCartBtn');
        addToCartBtn.addEventListener('click', function (event) {
            event.preventDefault();
            openPopup(product);
        });

        return card;
    }

	
    // Función para abrir el modal con los datos del producto
    function openPopup(product) {
        const modalContent = document.getElementById('productModalContent');
        modalContent.innerHTML = `
		<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <img id="imagen" src="assets/images/productos/${product.imagen}" class="card-img-top align-self-center mb-2" alt="${product.imagen}" style="margin: 10px; width: 170px; height: 170px; object-fit: cover;">                
            <h5 class="mb-2 mt-1">Descripción: </h5>
            <p id="descripcion">${product.descripcion}</p>
        </div>
       <div class="col-lg-4">
  <h5 id="nombre">${product.nombre}</h5>
  <p id="precio">Precio: $${product.precio}</p>
  <div class="form-group row mb-2">
   <div class=" col-lg-4 col-sm-4"> 
    <label for="productQuantity" class="col-form-label">Cantidad:</label>
	 </div>
	 <div class="col-lg-8 col-sm-8"> 
    <input type="number" class="form-control mb-2 rounded-pill" id="productQuantity" min="1" value="1">
    </div>
  </div>
  <div class="d-flex flex-column">
<button type="button" class="btn btn-primary rounded-pill w-100 mb-2" onclick="handleClick(${product.id})">Agregar al carrito</button>
<button type="button" class="btn btn-primary rounded-pill w-100" data-action="comprar" data-id="${product.id}" onclick="showProductDetailsModal(${product.id})">Comprar</button>

  </div>
</div>

</div>
 `;

        const productModal = new bootstrap.Modal(document.getElementById('productModal'));
        productModal.show();
    }
});


function showProductDetailsModal(id) {

    // Obtener la cantidad del producto del input
    const quantityInput = document.getElementById('productQuantity');
    const quantity = parseInt(quantityInput.value);

    // Obtener los valores de los elementos de texto
    const nombre = document.getElementById('nombre').textContent;
    const precioText = document.getElementById('precio').textContent;
    const imagen = document.getElementById('imagen').src; // Obtener el valor del atributo src
    const descripcion = document.getElementById('descripcion').textContent; 
    // Extraer el precio del texto usando una expresión regular
    const precio = parseFloat(precioText.match(/\d+\.\d+/)[0]);
    
    // Si hay más datos que necesitas obtener, hazlo de manera similar

    // Calcula el subtotal
    const subtotal = precio * quantity;
    // Calcula el IVA (por ejemplo, 10%)
    const iva = subtotal * 0.1;
    // Calcula el total sumando el subtotal y el IVA
    const total = subtotal + iva;

    // Actualiza el contenido del modal con los detalles del producto y la cantidad
    const content = document.getElementById('compraContent');
    content.innerHTML = `
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-4">
                    <img src="${imagen}" class="card-img-top align-self-center mb-2" alt="${imagen}" style="margin: 10px; width: 170px; height: 170px; object-fit: cover;">                
                  <!--  <p>${descripcion}</p> -->
                  <h5 class="mt-2">${nombre}</h5>
                  <p>Precio: $${precio.toFixed(2)}</p>
                <p>Cantidad: ${quantity}</p>
                </div>
                <div class="col-lg-4 col-md-4 border rounded p-4">
                <h5>Resumen de la compra</h5>
                <p>Subtotal: $${subtotal.toFixed(2)}</p>
                <p>IVA: $${iva.toFixed(2)}</p>
                <!-- Línea divisoria  -->
                <hr class="my-4">
                <p>Total: $${total.toFixed(2)}</p>
                <p>Envio: Domicilio</p>
                <!-- Línea divisoria -->
                <hr class="my-4">
                <button onclick="comprarProducto(${id}, ${quantity}, ${total.toFixed(2)})" class="btn btn-primary btn-sm btn-block rounded-pill">Continuar con la compra</button> <!-- Agregar clases de Bootstrap para estilo de botón -->
                <button onclick="closeContainer('compraContainer', 'CartContainer')" class="btn btn-secondary btn-sm btn-block rounded-pill">Cancelar</button> <!-- Agregar clases de Bootstrap para estilo de botón -->
            </div>
        </div>
    `;
    closeContainer('CartContainer', 'compraContainer')
     // Cerrar el modal
     const modalElement = document.getElementById('productModal');
     const modal = bootstrap.Modal.getInstance(modalElement);
      modal.hide();

    // Eliminar el fondo oscuro
    document.querySelector('.modal-backdrop').remove();
}


//funcion para agregar el producto al carrito de compras
function handleClick(productId) {
    var quantity = document.getElementById('productQuantity').value;
    
     
    // Construir un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append('action', 'addToCart');
    formData.append('id', productId);
    formData.append('quantity', quantity);

    // Utiliza Fetch para enviar la acción al servidor
    fetch('actions/venta.php', {
        method: 'POST',
        body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
          // Manejar la respuesta del servidor
        if (data.status === 'success') {
            alert(data.message);
           
           // Actualizar el número de productos en el carrito
            var cartItemCountElement = document.getElementById('cartItemCount');
            if (cartItemCountElement) {
                cartItemCountElement.textContent = data.cartItems;
        }
        
       // Cerrar el modal
       const modalElement = document.getElementById('productModal');
     const modal = bootstrap.Modal.getInstance(modalElement);
      modal.hide();
       
// Eliminar el fondo oscuro
document.querySelector('.modal-backdrop').remove();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        // Manejar errores de la solicitud
        console.error('Error:', error);
    });
}

// Al cargar la página, recupera el número de productos en el carrito desde localStorage
document.addEventListener("DOMContentLoaded", function () {
    getCounts(); // Llama a la función cuando la página esté cargada
    setInterval(getCounts, 30000);
          
        });
   
       // Verifica periódicamente si el número de productos en el carrito ha cambiado
function getCounts(){
       // Construir un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append('action', 'getRowCount');
    // Utiliza Fetch para enviar la acción al servidor
    fetch('actions/venta.php', {
        method: 'POST',
        body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
    })
         .then(response => response.json())
         .then(data => {
            if (data.status === 'success') {
                       // Actualiza el número de productos en el carrito
                       updateCartItemCount(data.cartItems);
                   }
         })
         .catch(error => {
           console.error(error);
         });
   }
   // Función para actualizar el número de productos en el carrito y almacenarlo en localStorage
function updateCartItemCount(newCount) {
           // Actualizar el número de productos en el carrito
               var cartItemCountElement = document.getElementById('cartItemCount');
               if (cartItemCountElement) {
                   cartItemCountElement.textContent = newCount;
           }
           // Almacena el número de productos en localStorage
           localStorage.setItem('cartItems', newCount);
}

function closeContainer(containerId1, containerId2) {
    // Ocultar el primer contenedor
    const container1 = document.getElementById(containerId1);
    if (container1) {
        container1.style.display = "none";
    }

    // Mostrar el segundo contenedor
    const container2 = document.getElementById(containerId2);
    if (container2) {
        container2.style.display = "block";
    }
}

function comprarProducto(id, cantidad, total){
    // Obtener la fecha actual
   let fechaActual = new Date();

// Convertir la fecha a formato ISO8601 y eliminar la información de la zona horaria
let fechaFormateada = fechaActual.toISOString().split('T')[0]; 
// Construir un objeto FormData
let formData = new FormData();
formData.append('action', 'registarVentaProducto');
formData.append('id', id);
formData.append('cantidad', cantidad);
formData.append('total', total);
formData.append('fecha', fechaFormateada); // Convertir la fecha a formato ISO8601

    // Utiliza Fetch para enviar la acción al servidor
    fetch('actions/venta.php', {
        method: 'POST',
        body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
    })
         .then(response => response.json())
         .then(data => {
            if (data.status === 'success') {
                       console.log(data.message);
            }else{
                console.log(data.message);
            }
         })
         .catch(error => {
           console.error(error);
         });
        
}
