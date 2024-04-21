document.addEventListener("DOMContentLoaded", function () {

   getCotizaciones();// Llama a la función cuando la página esté cargada
});

function mostrarCotizacion(idCotizacion) {
    
    let formData = new FormData();
    formData.append("action", "mostarCotizacion");
    formData.append("idCotizacion", idCotizacion);

    fetch("actions/mostrar_cotizacion.php", {
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
        if (data.success == true) {
            document.getElementById('nombre').innerHTML = 'Nombre: '+ data.dataCotizacion[0].nombre + data.dataCotizacion[0].apellidoPaterno + data.dataCotizacion[0].apellidoMaterno;
            document.getElementById('razonSocial').innerHTML = 'Razon social: '+ data.dataCotizacion[0].razonSocial;
              
            document.getElementById('servicio').innerHTML = 'Servicio: '+ data.dataCotizacion[0].servicio;
            document.getElementById('fecha').innerHTML = 'Fecha: '+ data.dataCotizacion[0].fecha;
            document.getElementById('observaciones').innerHTML = 'Observaciones: '+ data.dataCotizacion[0].observaciones;
            document.getElementById('descripcion').innerHTML ='Descripción: '+ data.dataCotizacion[0].descripcion;
                
            document.getElementById('costoInstalacion').innerHTML = 'Costo de instalacion: $'+data.dataCotizacion[0].costo_instalacion;
            document.getElementById('subtotal').innerHTML = 'Subtotal: $'+ data.dataCotizacion[0].subtotal;
            document.getElementById('descuento').innerHTML = 'Descuento: $'+ data.dataCotizacion[0].descuento;
            document.getElementById('iva').innerHTML = 'IVA: $' + data.dataCotizacion[0].iva;
            document.getElementById('total').innerHTML = 'Total: $' + data.dataCotizacion[0].total;
          
            if (data.dataCotizacion[0].producto != '') {
                document.getElementById("ItemsContent").innerHTML = ""; // Limpiamos el contenido anterior
        
                let tabla = `
                <table class="table table-striped table-bordered">
                    <thead>
                            <tr>
                                <th class="text-nowrap">Producto</th>
                                <th class="text-nowrap">Precio</th>
                                <th class="text-nowrap">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
                /****** */
                //Agregar los botones de acción con el idCotizacion como atributo de datos
            document.getElementById("accionesCotizacion").innerHTML = `
                <button type="button" class="btn btn-primary btn-sm rounded me-3" onclick="setEstatus(event, '${idCotizacion}','aceptada')">Aceptar cotización</button>
                <button type="button" class="btn btn-primary btn-sm rounded"  onclick="setEstatus(event, '${idCotizacion}', 'rechazada')">Rechazar cotización</button>
            `;
                /****** */
                data.dataCotizacion.forEach(dato => {
                    tabla += `
                        <tr>
                            <td class="text-nowrap">${dato.nombre_producto}</td>
                            <td class="text-nowrap">${dato.precio}</td>
                            <td class="text-nowrap">${dato.cantidad}</td>
                        </tr>
                    `;
                });
            
                tabla += `
                        </tbody>
                    </table>
                `;
            
                // Agregar la tabla al elemento con el ID "ItemsContent"
                document.getElementById("ItemsContent").innerHTML = tabla;
            }
            
        } else {
            //  document.getElementById("NoData").innerHTML = data.message;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
/**************************** */
function getCotizaciones() {
    let formData = new FormData();
    formData.append("action", "getCotizaciones");

    fetch("actions/mostrar_cotizacion.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success == true) {
            const cotizaciones = data.dataCotizacion;
            const container = document.getElementById("cotizacionesContainer");

            // Limpiar el contenedor antes de agregar nuevos datos
            container.innerHTML = "";

            cotizaciones.forEach(cotizacion => {
                const card = document.createElement("div");
                card.classList.add("col-md-6", "mb-3");
                card.innerHTML = `
                    <div class="card">
                        <div class="card-header">
                            Cotización
                        </div>
                        <div class="card-body">
                           <p class="card-text">Razón Social: ${cotizacion.razonSocial}</p>
                            <p class="card-text">Fecha de cotización: ${cotizacion.fecha}</p>
                            <p class="card-text">Servicio: ${cotizacion.servicio}</p>
                            <a href="#" class="btn btn-success rounded-pill  d-block mx-auto addToCartBtn" data-product-id="${cotizacion.idCotizacion}">Ver Cotización</a>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });

            // Agregar el evento click fuera del bucle forEach
            const addToCartBtns = document.querySelectorAll('.addToCartBtn');
            addToCartBtns.forEach(btn => {
                btn.addEventListener('click', function (event) {
                    event.preventDefault();
                    const productId = this.getAttribute('data-product-id');
                    openPopup(productId);
                });
            });
        } else {
            // Manejar el caso en que no haya datos de cotizaciones
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function openPopup(id){

    document.getElementById("popup").style.display = "block";
    mostrarCotizacion(id);
    
}

function setEstatus(event, idCotizacion, estatus) {
    event.preventDefault();
    
    let formData = new FormData();
    formData.append("action", "setEstatus");
    formData.append("idCotizacion", idCotizacion);
    formData.append("estatus", estatus);
    
    let title = '';
    let confirmButtonText = '';
    
    if (estatus === "aceptada") {
        title = '¿Desea aceptar la cotización?';
        confirmButtonText = 'Aceptar';
    } else {
        title = '¿Desea rechazar la cotización?';
        confirmButtonText = 'Rechazar';
    }
    
    Swal.fire({
        title: title,
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ' + confirmButtonText
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("actions/mostrar_cotizacion.php", {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error('Error en la solicitud. Código de estado: ' + response.status + ', Tipo de error: ' + errorData.error + ', Mensaje: ' + errorData.message);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success === true) {
                    Swal.fire({
                        title: 'Éxito',
                        text: data.message,
                        icon: 'success'
                    });
                    getCotizaciones();
                    document.getElementById("popup").style.display = "none";
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Hubo un error al procesar la solicitud', 'error');
            });
        }
    });
}
