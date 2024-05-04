document.addEventListener('DOMContentLoaded', function() {
    mostrarServicios();
});

function mostrarServicios() {
    let noData = document.getElementById("NoData"); // Limpiamos el mensaje de no hay datos
    noData.innerHTML = "";
    let tabla = document.getElementById("tabla") // Limpiamos la tabla
    let formData = new FormData();
    formData.append("action", "mostar_servicios");

    // Obtener las cotizaciones
    fetch('actions/mostrar_servicios.php',{
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
        if (data.success == true) {
            tabla.innerHTML = "";
         let servicios = data.servicios;
        // Mostrar las cotizaciones en una tabla utilizando Bootstrap 5
        let tablaServicio = `
            <thead>
                <tr>
                    <th>ID Servicio</th>
                    <th>Empresa</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Estado del servicio</th>       
                    <th>Accion</th>                   
            
                </tr>
            </thead>
            <tbody>`;
        
        servicios.forEach(servicio => {
            tablaServicio += `
            <tr>
                <td>${servicio.idServicio}</td>
                <td>${servicio.razonSocial}</td>
                <td>${servicio.servicio_ofrecido}</td>
                <td>${servicio.fecha}</td>
                <td>${servicio.estado}</td>
                <td>
                <button type="button" class="btn btn-sm btn-primary w-100 rounded-5" onclick="abrirModal('${servicio.idServicio}')">Ver Informacion</button>
                </td>
               </td>
               </tr>`;
        });

        tablaServicio += `</tbody>`;
        // Insertar la tabla en el contenedor deseado en tu página
        tabla.innerHTML = tablaServicio;
    }else {
              noData.innerHTML = data.message;
          } 
        
    })
    .catch(error => {
        console.error(error);
    });
}



//############################################################

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
        fetch('actions/mostrar_servicios.php',{
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