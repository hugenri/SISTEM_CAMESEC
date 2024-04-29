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
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Disponibilidad</th>
                    <th>idCotizacion</th>
                   
                </tr>
            </thead>
            <tbody>`;
        
        servicios.forEach(servicio => {
            tablaServicio += `
            <tr>
                <td>${servicio.idServicio}</td>
                <td>${servicio.nombre}</td>
                <td>${servicio.disponibilidad}</td>
                <td>${servicio.idCotizacion}</td>
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

function abirPopup(idSC, estatus){
  
    document.getElementById("popup").style.display = "block";
    // Llamar a verificarCondiciones después de que se haya mostrado el popup
    verCotizacion(idSC, estatus);
    
   
}

//############################################################