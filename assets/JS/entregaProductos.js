document.addEventListener("DOMContentLoaded", function () {
    get_nuevas_entregas();
    setInterval(get_nuevas_entregas, 120000);
});

function get_nuevas_entregas() {
    const contenedorTarjetas = document.getElementById('contenedor-servicios');

    let formData = new FormData();
    formData.append("action", "mostarEntregas");
    
    fetch('actions/entregaProductos.php',{
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    }) .then(response => response.json())
        .then(data => {
            if (data.success) {
                contenedorTarjetas.innerHTML = ''; // Limpiar el contenido anterior
                
                data.datos.forEach(datos => {
                    const tarjeta = `
                        <div class="col mb-2">
                            <div class="card card-servicio">
                                <div class="card-body">
                                    <h6 class="card-title">Empresa:${datos.nombre_empresa}</h6>
                                    <p class="card-text">Contacto: ${datos.nombre_completo}</p>
                                    <p class="card-text">Email: ${datos.email_cliente}</p>
                                    <p class="card-text">Teléfono: ${datos.telefono_cliente}</p>
                                    <h6 class="card-title">Servicio:Venta de productos</h6>
                                    <p class="card-text">Fecha de la entrega: ${datos.fecha_entrega}</p>
                                    <div class="col-12">
                                    <button type="button" class="btn btn-primary w-100 rounded-5" onclick="abrirModal('${datos.id_entrega}')">Ver Informacion Completa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    contenedorTarjetas.innerHTML += tarjeta;
                });
            } else {
                contenedorTarjetas.innerHTML = '<h4>No tiene nuevas entregas</h4>';

            }
        })
        .catch(error => {
            console.error(error);
        });
}


function abrirModal(id_entrega){

    mostrarDatosServicio(id_entrega);
// Mostrar el formulario
document.getElementById("modalPopup").style.display = "block";//estilo para mostrar el popup
}

function cerrarPopup(){
    document.getElementById("modalPopup").style.display = "none";//estilo para cerrar el popup

}


    
function mostrarDatosServicio(id_entrega) {

    let formData = new FormData();
    formData.append("action", "mostar_datos_entrega");
    formData.append("id_entrega", id_entrega);

    // Obtener las cotizaciones
    fetch('actions/entregaProductos.php',{
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const datosProducto = document.getElementById('datosProducto');
            datosProducto.innerHTML = ''; // Limpiar el contenido anterior
            const servicio = data.datosServicio[0]; // Suponiendo que solo hay un servicio en la respuesta
            document.getElementById('empresa').innerText = servicio.nombre_empresa;
            document.getElementById('contacto').innerText = servicio.nombre_completo;
            document.getElementById('email').innerText = servicio.email_cliente;
            document.getElementById('telefono').innerText = servicio.telefono_cliente;
            document.getElementById('calle').innerText = servicio.calle;
            document.getElementById('colonia').innerText = servicio.colonia;
            document.getElementById('numero').innerText = servicio.numero;
            document.getElementById('municipio').innerText = servicio.municipio;
            document.getElementById('estado').innerText = servicio.estado;
            document.getElementById('servicio').innerText = 'Venta de productos';
            document.getElementById('detalles').innerText = servicio.detalle;

            // Pasar un valor al campo oculto
            document.getElementById("id_entrega").value = servicio.id_entrega;

            data.datosServicio.forEach(servicio => {
                const fila = `
                    <tr>
                        <td>${servicio.nombre_producto}</td>
                        <td>${servicio.cantidad_producto}</td>
                    </tr>
                `;
                datosProducto.insertAdjacentHTML('beforeend', fila);
            });
           
        } else {
            console.log(data.message);
        }
    })
    .catch(error => {
        console.error(error);
    });
}


function actualizarEstado(estado) {
    
    // Recuperar el valor del campo oculto
   let id_entrega = document.getElementById("id_entrega").value;
    let formData = new FormData();
    formData.append("id_entrega", id_entrega);
    formData.append("estado", estado);
    formData.append("action", "cambiar_estado" );

    Swal.fire({
        title: '¿Desea registar la entrega como '+ estado + '?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, registrar'
      }).then((result) => {
        if (result.isConfirmed) {
    fetch('actions/entregaProductos.php',{
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
                  get_nuevas_entregas();
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