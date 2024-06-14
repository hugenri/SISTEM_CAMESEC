document.addEventListener("DOMContentLoaded", function () {
    // Recupera el idVenta de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idVenta = urlParams.get('idVenta');

    if (idVenta) {
        getDatosCompra(idVenta); // Llama a la función cuando la página esté cargada
    } else {
        console.error('No se encontró idVenta en la URL.');
    }
});

function getDatosCompra(idVenta) {
    let formData = new FormData();
    formData.append("action", "mostarVenta");
    formData.append("idVenta", idVenta);

    fetch("actions/pago.php", {
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
        if (data.success == true) {
            // Mostrar los datos en los elementos HTML
            document.getElementById('nombre').innerHTML = 'Nombre: ' + data.datosVenta[0].nombre + ' ' + data.datosVenta[0].apellidoPaterno + ' ' + data.datosVenta[0].apellidoMaterno;
            document.getElementById('razonSocial').innerHTML = 'Razon social: ' + data.datosVenta[0].razonSocial;
            document.getElementById('total').innerHTML = 'Total: $' + data.datosVenta[0].total;

            // Mostrar los productos en el contenedor
            agregarProductosAlContenedor(data.datosVenta, 'productos');
        } else {
            console.error(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function agregarProductosAlContenedor(items, container) {
    let containerElement = document.getElementById(container);
    containerElement.innerHTML = ''; // Limpiar el contenedor

    // Verificar si items está definido y tiene elementos
    if (items && items.length > 0) {
        items.forEach(item => {
            const productElement = document.createElement('div');
            productElement.classList.add('item');
            productElement.innerHTML = `
                <div class="row">
                    <div class="col-3">
                        <img src="assets/images/productos/${item.imagen}" alt="${item.imagen}" class="img-fluid">
                    </div>
                    <div class="col-6">
                        <p>Producto: ${item.producto_nombre}</p>
                        <p>Cantidad: ${item.cantidad}</p>
                        <p>Precio unitario: $${item.precio}</p>
                    </div>
                </div>
                <hr>
            `;
            containerElement.appendChild(productElement);
        });
    } else {
        // Si no hay elementos en items, puedes mostrar un mensaje o realizar otra acción
        containerElement.innerHTML = '<p>No hay productos disponibles.</p>';
    }
}


function procesarPago() {

    // Recupera el idVenta de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idVenta = urlParams.get('idVenta');

    if (idVenta == '') {
        console.error('No se encontró idVenta en la URL.');
        return;

    }
    // Verificar que al menos una opción esté seleccionada
    const opcionesPago = document.querySelectorAll('.form-check-input');
    let opcionPago = null;

    opcionesPago.forEach(opcion => {
        if (opcion.checked) {
            opcionPago = opcion.value;
        }
    });

    if (!opcionPago) {
        Swal.fire('Error', 'Por favor, seleccione una opción de pago.', 'error');
        return;
    }

    Swal.fire({
        title: '¿Desea realizar el pago de su compra?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, pagar'
        }).then((result) => {
        if (result.isConfirmed) {
    let formData = new FormData();
    formData.append("action", "procesarPago");
    formData.append("idVenta", idVenta);  
    formData.append("opcionPago", opcionPago);


    fetch("actions/pago.php", {
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Éxito',
                text: data.message,
                icon: 'success'
            }).then(() => {
                // Redirigir después de cerrar el cuadro de diálogo de éxito
                window.location.href = "mis_compras.php";
            });        }else {
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