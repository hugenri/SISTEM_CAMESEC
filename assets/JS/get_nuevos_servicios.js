document.addEventListener("DOMContentLoaded", function () {
    get_nuevos_servicios();
    setInterval(get_nuevos_servicios, 120000);
});

function get_nuevos_servicios() {
    const contenedorTarjetas = document.getElementById('contenedor-servicios');

    let formData = new FormData();
    formData.append("action", "mostarNuevosServicios");
    
    fetch('actions/get_nuevos_servicios.php',{
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    }) .then(response => response.json())
        .then(data => {
            if (data.success) {
                contenedorTarjetas.innerHTML = ''; // Limpiar el contenido anterior
                
                data.servicios.forEach(servicio => {
                    const tarjeta = `
                        <div class="col mb-2">
                            <div class="card card-servicio">
                                <div class="card-body">
                                    <h6 class="card-title">Empresa:${servicio.nombre_empresa}</h6>
                                    <p class="card-text">Contacto: ${servicio.nombre_completo}</p>
                                    <p class="card-text">Email: ${servicio.email_cliente}</p>
                                    <p class="card-text">Teléfono: ${servicio.telefono_cliente}</p>
                                    <h6 class="card-title">Servicio:${servicio.servicio_ofrecido}</h6>
                                    <p class="card-text">Fecha del servicio: ${servicio.fecha}</p>
                                    <div class="col-12">
                                    <button type="button" class="btn btn-primary w-100 rounded-5" onclick="abrirModal('${servicio.idServicio}')">Ver Informacion Completa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    contenedorTarjetas.innerHTML += tarjeta;
                });
            } else {
                contenedorTarjetas.innerHTML = '<h4>No tiene nuevos servicios</h4>';

            }
        })
        .catch(error => {
            console.error(error);
        });
}


function abrirModal(idServicio){
// Mostrar el formulario
document.getElementById("modalPopup").style.display = "block";//estilo para mostrar el popup
mostrarDatosServicio(idServicio);
}

function cerrarPopup(){
    document.getElementById("modalPopup").style.display = "none";//estilo para cerrar el popup

}


    
function mostrarDatosServicio(idServicio) {
       
    let formData = new FormData();
    formData.append("action", "mostar_datos_servicio");
    formData.append("idServicio", idServicio);

    // Obtener las cotizaciones
    fetch('actions/get_nuevos_servicios.php',{
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
            document.getElementById('servicio').innerText = servicio.servicio_ofrecido;
            document.getElementById('detalles').innerText = servicio.detalles;
            console.log(servicio.detalles);

            // Pasar un valor al campo oculto
            document.getElementById("idServicio").value = servicio.idServicio;


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


function actualizarEstadoServicio(estadoServicio) {
    
    // Recuperar el valor del campo oculto
   let idServicio = document.getElementById("idServicio").value;

    let formData = new FormData();
    formData.append("idServicio", idServicio);
    formData.append("estadoServicio", estadoServicio);
    
    Swal.fire({
        title: '¿Desea registar el servicio como '+ estadoServicio + '?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, registrar'
      }).then((result) => {
        if (result.isConfirmed) {
    fetch('actions/actualizarEstadoServicio.php',{
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
                  document.getElementById("popup").style.display = "none";//estilo para ocultar el popup
               
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