document.addEventListener("DOMContentLoaded", function () {
    get_nuevas_facturas();
    setInterval(get_nuevas_facturas, 120000);
});

function get_nuevas_facturas() {
    const contenedorTarjetas = document.getElementById('contenedor-servicios');

    let formData = new FormData();
    formData.append("action", "mostarNuevosFacturas");
    
    fetch('actions/get_nuevas_facturas.php',{
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    }) .then(response => response.json())
        .then(data => {
            if (data.success) {
               
                contenedorTarjetas.innerHTML = ''; // Limpiar el contenido anterior
                
                data.datosFacturas.forEach(factura => { // Aquí se corrige el nombre de la variable
                    const tarjeta = `
                        <div class="col mb-2">
                            <div class="card card-servicio  bg-custom">
                                <div class="card-body">
                                    <h6 class="card-title">Empresa: ${factura.razon_social_cliente}</h6>
                                    <p class="card-text">Contacto: ${factura.nombre_completo}</p>
                                    <p class="card-text">Email: ${factura.email_cliente}</p>
                                    <p class="card-text">Teléfono: ${factura.telefono_cliente}</p>
                                    <h6 class="card-title">Servicio:${factura.servicio_ofrecido}</h6>
                                    <p class="card-text">Fecha de la factura: ${factura.fecha_factura}</p>
                                    <div class="col-12">
                                    <button type="button" class="btn btn-primary w-100 rounded-5" onclick="abrirModal('${factura.idFactura}')">Ver Informacion Completa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    contenedorTarjetas.innerHTML += tarjeta;
                });
            } else {
                contenedorTarjetas.innerHTML = '<h4>No tiene nuevos facturas</h4>';

            }
        })
        .catch(error => {
            console.error(error);
        });
}



function abrirModal(idFactura){
// Mostrar el formulario
document.getElementById("modalPopup").style.display = "block";//estilo para mostrar el popup
mostrarDatosFactura(idFactura);
}

function cerrarPopup(){
    document.getElementById("modalPopup").style.display = "none";//estilo para cerrar el popup

}


    
function mostrarDatosFactura(idFactura) {
       
    let total_productos = 0;
    let formData = new FormData();
    formData.append("action", "mostar_datos_factura");
    formData.append("idFactura", idFactura);

    // Obtener las cotizaciones
    fetch('actions/get_nuevas_facturas.php',{
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
            const datosProducto = document.getElementById('datosProducto');
            datosProducto.innerHTML = ''; // Limpiar el contenido anterior
            const factura = data.datosFactura[0]; // Suponiendo que solo hay un servicio en la respuesta
           
           document.getElementById('servicio').innerText = factura.servicio;
           document.getElementById('fechaFactura').innerText = factura.fecha_factura;
           document.getElementById('idFactura').innerText = factura.idFactura;

           document.getElementById('rfc').innerText = factura.rfc;
           document.getElementById('empresa').innerText = factura.razon_social_cliente;
            document.getElementById('nombreCliente').innerText = factura.nombre_completo;
            document.getElementById('email').innerText = factura.email_cliente;
            document.getElementById('telefono').innerText = factura.telefono_cliente;

            document.getElementById('calle').innerText = factura.calle_cliente;
            document.getElementById('colonia').innerText = factura.colonia_cliente;
            document.getElementById('numero').innerText = factura.numero_cliente;
            document.getElementById('municipio').innerText = factura.municipio_cliente;
            document.getElementById('estado').innerText = factura.estado_cliente;

            document.getElementById('instalacion').innerText = factura.costo_instalacion;
            document.getElementById('subtotal').innerText = factura.subtotal;
            document.getElementById('iva').innerText = factura.iva;
            document.getElementById('descuento').innerText = parseInt(factura.descuento)+'%';
            document.getElementById('total').innerText = factura.total;

            document.getElementById("idFactura").value = factura.idFactura;

            data.datosFactura.forEach(factura => {
                const fila = `
                    <tr>
                        <td>${factura.nombre_producto}</td>
                        <td>${factura.cantidad_producto}</td>
                        <td>${factura.precio_producto}</td>

                    </tr>
                `;
                datosProducto.insertAdjacentHTML('beforeend', fila);
                total_productos += parseFloat(factura.cantidad_producto * factura.precio_producto);
            });
            document.getElementById('totalProductos').innerText = total_productos;

        } else {
            console.log(data.message);
        }
    })
    .catch(error => {
        console.error(error);
    });
}


function actualizarEstatusFactura(estatusFactura) {
    
    // Recuperar el valor del campo oculto
   let idFactura = document.getElementById("idFactura").value;

    let formData = new FormData();
    formData.append("idFactura", idFactura);
    formData.append("estatusFactura", estatusFactura);
    
    Swal.fire({
        title: '¿Desea registar el estatus de la factura como '+ estatusFactura + '?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, registrar'
      }).then((result) => {
        if (result.isConfirmed) {
    fetch('actions/actualizarEstatusFactura.php',{
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    }) .then(response => {
        if (!response.ok) {
            return response.json().then(errorData => {
                throw new Error('Error en la solicitud. Código de estado: ' + response.status + ', Tipo de error: ' + errorData.error + ', Mensaje: ' + errorData.message);
            });
        }
        return response.json(); // Suponiendo que la respuesta es JSON
    })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Éxito',
                    text: data.message,
                    icon: 'success'
                });   
                  document.getElementById("modalPopup").style.display = "none";//estilo para ocultar el popup
               
            } else {
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