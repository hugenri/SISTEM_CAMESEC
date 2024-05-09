document.addEventListener('DOMContentLoaded', function() {
    mostrarFacturas();
});

function mostrarFacturas() {
    let noData = document.getElementById("NoData"); // Limpiamos el mensaje de no hay datos
    noData.innerHTML = "";
    let tabla = document.getElementById("tabla") // Limpiamos la tabla
    let formData = new FormData();
    formData.append("action", "mostar_facturas");

    // Obtener las cotizaciones
    fetch('actions/mostrar_facturas.php',{
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
        if (data.success == true) {
            tabla.innerHTML = "";
         let facturas = data.facturas
        // Mostrar las cotizaciones en una tabla utilizando Bootstrap 5
        let tablaFacturas = `
            <thead>
                <tr>
                    <th>ID factura</th>
                    <th>Empresa</th>
                    <th>Servicio</th>
                    <th class="text-truncate">Fecha Factura</th>
                    <th class="text-truncate">Estado de la factura</th>       
                    <th>Accion</th>                   
            
                </tr>
            </thead>
            <tbody>`;
        
        facturas.forEach(factura => {
            tablaFacturas += `
            <tr>
                <td>${factura.idFactura}</td>
                <td class="text-truncate">${factura.razon_social_cliente}</td>
                <td class="text-truncate">${factura.servicio}</td>
                <td>${factura.fecha_factura}</td>
                <td>${factura.estatus_factura}</td>
                <td>
                <button type="button" class="btn btn-sm btn-primary w-100 rounded-5 text-truncate" onclick="abrirModal('${factura.idFactura}')">Ver Informacion</button>
                </td>
               </td>
               </tr>`;
        });

        tablaFacturas += `</tbody>`;
        // Insertar la tabla en el contenedor deseado en tu página
        tabla.innerHTML = tablaFacturas;
    }else {
              noData.innerHTML = data.message;
          } 
        
    })
    .catch(error => {
        console.error(error);
    });
}



//############################################################

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
        fetch('actions/mostrar_facturas.php',{
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
            
                actualizarEstadoBotones(factura.estatus_factura, factura.idFactura);
               
                
            } else {
                console.log(data.message);
            }
        })
        .catch(error => {
            console.error(error);
        });
    }


    function actualizarEstadoBotones(estatus_factura, idFactura) {
        const botonTerminada = document.getElementById("botonTerminada");
        const botonCancelada = document.getElementById("botonCancelada");
    
        if (estatus_factura === "terminada") {
            botonCancelada.classList.remove("d-none"); // Ocultar el botón Cancelada
            botonCancelada.dataset.idFactura = idFactura;
            botonCancelada.dataset.estatusFactura = 'cancelada';
            botonTerminada.classList.add("d-none"); // Ocultar el botón Cancelada


        } else if (estatus_factura === "cancelada") {
            botonTerminada.classList.remove("d-none"); // Ocultar el botón Terminada
            botonTerminada.dataset.idFactura = idFactura;
            botonTerminada.dataset.estatusFactura = 'terminada';
            botonCancelada.classList.add("d-none"); // Ocultar el botón Cancelada

            
        }
    }
    
    function actualizarEstatusFactura(event) {
    
        const button = event.currentTarget;
        const idFactura = button.dataset.idFactura;
        const estatusFactura = button.dataset.estatusFactura;

    
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