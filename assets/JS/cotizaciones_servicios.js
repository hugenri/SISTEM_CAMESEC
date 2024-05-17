document.addEventListener('DOMContentLoaded', function() {
    mostrarCotizaciones();
});

function mostrarCotizaciones() {
    let noData = document.getElementById("NoData"); // Limpiamos el mensaje de no hay datos
    noData.innerHTML = "";
    let tabla = document.getElementById("tablaCotizaciones") // Limpiamos la tabla
    let formData = new FormData();
    formData.append("action", "mostarServiciosSolicitados");

    // Obtener las cotizaciones
    fetch('actions/mostrarServiciosSolicitados.php',{
        method: 'POST', // Especifica que la solicitud sea POST
        body: formData  // Usar el objeto FormData como cuerpo de la solicitud
    })
    .then(response => response.json())
    .then(data => {
        if (data.success == true) {
            tabla.innerHTML = "";
        // Verificar si se recibió un objeto o un array
        const cotizaciones = Array.isArray(data.cotizaciones) ? data.cotizaciones : [data.cotizaciones];

        // Mostrar las cotizaciones en una tabla utilizando Bootstrap 5
        let tablaCotizaciones = `
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Fecha de Solicitud</th>
                    <th>Estado</th>
                    <th>Estatus</th>
                    <th>Ver Cotización</th>
                </tr>
            </thead>
            <tbody>`;
        
        cotizaciones.forEach(cotizacion => {
            tablaCotizaciones += `
            <tr>
                <td>${cotizacion.id}</td>
                <td>${cotizacion.servicio}</td>
                <td>${cotizacion.fecha_solicitud}</td>
                <td>${cotizacion.estado}</td>
                <td>${cotizacion.estatus !== null ? cotizacion.estatus : ''}</td>
               <td> ${cotizacion.estado === 'cotizada' ? '<button class="btn btn-link" onclick="abirPopup(' + cotizacion.id + ', \'' + cotizacion.estatus + '\')"><img src="assets/images/ver.png" alt="Ver Cotización"></button>' : ''} 
               </td>
               </tr>`;
        });

        tablaCotizaciones += `</tbody>`;
        // Insertar la tabla en el contenedor deseado en tu página
        tabla.innerHTML = tablaCotizaciones;
    }else {
              noData.innerHTML = data.message;
          } 
        
    })
    .catch(error => {
        console.error(error);
    });
}

function abirPopup(idSC, estatus){
  
    document.getElementById("popup").style.display = "block";
    // Llamar a verificarCondiciones después de que se haya mostrado el popup
    verCotizacion(idSC, estatus);
    
   
}

//############################################################3

 
 function verCotizacion(idSC, estatus) {
     
     let formData = new FormData();
     formData.append("action", "verCotizacion");
     formData.append("idSC", idSC);

     fetch("actions/mostrarServiciosSolicitados.php", {
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
                 
             document.getElementById('costoInstalacion').innerHTML = 'Costo de instalacion: $'+  formatearNumero(data.dataCotizacion[0].costo_instalacion);
             document.getElementById('subtotal').innerHTML = 'Subtotal: $'+ formatearNumero(data.dataCotizacion[0].subtotal);
             document.getElementById('descuento').innerHTML = 'Descuento: '+ data.dataCotizacion[0].descuento + '%';
             document.getElementById('iva').innerHTML = 'IVA: $' + formatearNumero(data.dataCotizacion[0].iva);
             document.getElementById('total').innerHTML = 'Total: $' + formatearNumero(data.dataCotizacion[0].total);



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
                 if (estatus != 'aceptada' && estatus != "rechazada") {
                        console.log(estatus+'.............................');
                   document.getElementById("accionesCotizacion").innerHTML = `
                 <button id="btnAceptar"  type="button" class="btn btn-primary btn-sm rounded me-3" onclick="setEstatus(event, '${idSC}','aceptada')">Aceptar cotización</button>
                 <button id="btnRechazar" type="button" class="btn btn-primary btn-sm rounded"  onclick="setEstatus(event, '${idSC}', 'rechazada')">Rechazar cotización</button>
             `;
                 }
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
 
 
 
 function setEstatus(event, idSC, estatus) {
     event.preventDefault();
     
     let formData = new FormData();
     formData.append("action", "setEstatus");
     formData.append("idSC", idSC);
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
             fetch("actions/mostrarServiciosSolicitados.php", {
                 method: 'POST',
                 body: formData
             }).then(response => response.json())
             .then(data => {
                 if (data.success === true) {
                     Swal.fire({
                         title: 'Éxito',
                         text: data.message,
                         icon: 'success'
                     });
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
 
 function verificarCondiciones(estatus) {
    console.log(estatus);
    // Verificar si los elementos existen antes de intentar acceder a ellos
    var btnAceptar = document.getElementById('btnAceptar');
    var btnRechazar = document.getElementById('btnRechazar');

    if (btnAceptar && btnRechazar) {
        // Si los elementos existen, desactivar los botones si es necesario
        if (estatus == "aceptada" || estatus == "rechasada") {
            btnAceptar.disabled = true;
            btnRechazar.disabled = true;
        }
    } else {
        console.error("Los elementos 'btnAceptar' o 'btnRechazar' no existen en el DOM.");
    }
}

