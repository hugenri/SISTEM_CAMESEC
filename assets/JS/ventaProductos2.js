
    //const cartModalContent = document.getElementById('cart-items');
    const clearCartBtn = document.getElementById('clearCartBtn');
    const checkoutBtn = document.getElementById('checkoutBtn');

    // Función para mostrar los productos del carrito

function displayCartItems() {
     // Obtener el valor del input de búsqueda
     const searchTerm = document.getElementById('searchInput').value.trim();
    let cartModalContent = document.getElementById('cartModalContent');
     // Limpia el contenido del contenedor del modal
     cartModalContent.innerHTML = '';
    // Utiliza Fetch para obtener los datos del carrito
     // Construir un objeto FormData para enviar los datos
   var formData = new FormData();
   formData.append('action', 'carrito');
   formData.append('searchTerm', searchTerm);

   // Utiliza Fetch para enviar la acción al servidor
   fetch('actions/venta.php', {
       method: 'POST',
       body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
   }).then(response => response.json())
     .then(data => {
            if (data.status === 'success') {
                const cart = data.cart;
                
                for (const item of cart) {

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
                                <button class="btn btn-sm btn-danger removeItemBtn rounded-pill" data-id="${item.rowid}">Eliminar</button>
                            </div>
                        </div>
                        <hr>
                    `;
                    cartModalContent.appendChild(productElement);
                }

                // Calcula el total de la compra y muestra el total y el IVA
                const totalPrice = calculateTotalPrice(cart);
                document.getElementById('total').textContent = `$${totalPrice.total}`;
                document.getElementById('iva').textContent = `$${totalPrice.tax}`;
                document.getElementById('total-iva').textContent = `$${totalPrice.totalIva}`;

                // Añade event listeners para los botones de eliminar producto
                const removeItemBtns = document.querySelectorAll('.removeItemBtn');
                removeItemBtns.forEach(btn => {
                    btn.addEventListener('click', removeItemFromCart);
                });

                // Muestra los productos del carrito al abrir el modal
                const productModal = new bootstrap.Modal(document.getElementById('cartModal'));
                productModal.show();
            
            }
        })
        .catch(error => console.error('Error al obtener el carrito:', error));
}


    // Función para calcular el total de la compra y el IVA
    function calculateTotalPrice(cart) {
        let total = 0;
        cart.forEach(item => {
            total += item.price * item.qty;
        });
        const tax = total * 0.16; // Suponiendo un IVA del 16%
        let totalIva = total + tax;
        return { total: total.toFixed(2), tax: tax.toFixed(2), totalIva: totalIva.toFixed(2) };
    }

    // Función para eliminar un producto del carrito
function removeItemFromCart(event) {
    const rowid = event.target.dataset.id;
   
    // Construir un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append('rowid', rowid);
    formData.append('action', 'elimonarProductoCart');

     // Utiliza Fetch para enviar la acción al servidor
   fetch('actions/venta.php', {
       method: 'POST',
       body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
   }).then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Si la eliminación del producto fue exitosa, vuelve a mostrar los productos actualizados del carrito
                document.getElementById('total').textContent = '';
                document.getElementById('iva').textContent = '';
                document.getElementById('total-iva').textContent = '';
            displayCartItems();
            getCounts();
        } else {
            console.error(data.message);
        }
    })
    .catch(error => console.error('Error al eliminar el producto del carrito:', error));

}


    // Event listener para el botón de vaciar carrito
    clearCartBtn.addEventListener('click', function () {
        //Fetct para vaciar el carrito en el servidor
       // Construir un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append('action', 'vaciar_carrito');

     // Utiliza Fetch para enviar la acción al servidor
   fetch('actions/venta.php', {
       method: 'POST',
       body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
   }).then(response => response.json())
    .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                // Si la eliminación del producto fue exitosa, vuelve a mostrar los productos actualizados del carrito
                document.getElementById('total').textContent = '';
                document.getElementById('iva').textContent = '';
                document.getElementById('total-iva').textContent = '';
                displayCartItems();
                getCounts();
            } else {
                console.error('Error al eliminar los productos del carrito:', data.message);
            }
        })
        .catch(error => console.error('Error al eliminar productos del carrito:', error));
    });

    // Event listener para el botón de confirmar compra
    checkoutBtn.addEventListener('click', function () {
        
    // Construir un objeto FormData para enviar los datos
    var formData = new FormData();
   
    formData.append('action', 'registarCartVenta');

     // Utiliza Fetch para enviar la acción al servidor
   fetch('actions/venta.php', {
       method: 'POST',
       body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
   }).then(response => response.json())
    .then(data => {
        if (data.status === 'success') {

            alert(data.message);
            /*
            displayCartItems();
            */
            getCounts();
            
        } else {
            console.error(data.message);
        }
    })
    .catch(error => console.error('Error al eliminar el producto del carrito:', error));

    });
