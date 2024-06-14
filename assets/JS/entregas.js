document.addEventListener("DOMContentLoaded", function () {
    getDatos();
});

function getDatos() {
    let noData = document.getElementById("NoData");
    noData.innerHTML = "";
    let tabla = document.getElementById("tabla");
    let formData = new FormData();
    formData.append("action", "mostar_datos");

    fetch("actions/entregaProductos.php", {
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
        if (data.success == true) {
        tabla.innerHTML = "";
            let datos = data.datos;
            
            let tablaDatos = `
                <thead>
                    <tr>
                        <th>ID Entrega</th>
                        <th>Empresa</th>
                        <th>Servicio</th>
                        <th>Fecha de entrega</th>
                        <th>Estado de la entrega</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>`;

            datos.forEach(dato => {
                tablaDatos += `
                <tr>
                    <td>${dato.id_entrega}</td>
                    <td>${dato.nombre_empresa}</td>
                    <td>Venta de productos</td>
                    <td>${dato.fecha_entrega}</td>
                    <td>${dato.estado}</td>
                    <td>
                 <button type="button" class="btn btn-sm btn-primary w-100 rounded-5" onclick="abrirModal('${dato.id_entrega}')">Ver Informacion</button>
                    </td>
                </tr>`;
            });

            tablaDatos += `</tbody>`;
            tabla.innerHTML = tablaDatos;
        } else {
            noData.innerHTML = data.message;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

//############################################################

function abrirModal(id_entrega){
 
    // Mostrar el formulario
    document.getElementById("modalPopup").style.display = "block";//estilo para mostrar el popup
    mostrarDatos(id_entrega);
    }
    
    function cerrarPopup(){
        document.getElementById("modalPopup").style.display = "none";//estilo para cerrar el popup
    
    }
    
function mostrarDatos(id_entrega) {
       
        let formData = new FormData();
        formData.append("action", "verEntrega");
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
                const datos = data.datos[0]; // Suponiendo que solo hay un servicio en la respuesta
                document.getElementById('empresa').innerText = datos.nombre_empresa;
                document.getElementById('contacto').innerText = datos.nombre_completo;
                document.getElementById('email').innerText = datos.email_cliente;
                document.getElementById('telefono').innerText = datos.telefono_cliente;
                document.getElementById('calle').innerText = datos.calle;
                document.getElementById('colonia').innerText = datos.colonia; 
                document.getElementById('numero').innerText = datos.numero;
                document.getElementById('municipio').innerText = datos.municipio;
                document.getElementById('estado').innerText = datos.estado;
                document.getElementById('servicio').innerText = 'venta de productos';
                document.getElementById('detalles').innerText = datos.detalle;

               

                data.datos.forEach(producto => {
                    const fila = `
                        <tr>
                            <td>${producto.nombre_producto}</td>
                            <td>${producto.cantidad_producto}</td>
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