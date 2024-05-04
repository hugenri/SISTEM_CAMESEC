function verDetalles() {
  document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
fetch("actions/get_detalles_servicios.php")
    .then(response => response.json())
    .then(data => { 
       
      if (data.success == true) {
        
        document.getElementById("tablaServicio").innerHTML = ""; // Limpiamos la tabla
             
        let tabla = `<thead><tr>
        <th class="text-nowrap">ID</th>
        <th class="text-nowrap">Cliente</th>
        <th class="text-nowrap">Servicio</th>
        <th class="text-nowrap">Fecha</th>
        <th>Detalles</th> </thead>`;

         tabla += `<tbody>`; 
        for (let x of data.dataServices) {
       
          tabla += `<tr data-id="${x.idServicio}">
          <td class="text-nowrap">${x.idServicio}</td>
          <td class="text-nowrap">${x.razon_social_cliente}</td>
          <td class="text-nowrap">${x.nombre_servicio}</td>
          <td class="text-nowrap">${x.fecha}</td>
          <td>
          <img src="assets/images/ver.png" alt="ver" class="tabla-image-accion" onclick="cargarDetalles(event, '${x.detalles}')" style="cursor: pointer;"> 
        </td>
          </tr>`;
        }
        tabla += `</tbody>`;
        document.getElementById("tablaServicio").innerHTML = tabla;
      } 
    else {
      document.getElementById("tablaServicio").innerHTML = ""; // Limpiamos la tabla
                document.getElementById("NoData").innerHTML = data.message;
              
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });

}

function cargarDetalles(evento, detalles) {
  evento.preventDefault();
  document.getElementById('descripcionTextarea').innerHTML = detalles;
  document.getElementById("popup").style.display = "block";//estilo para mostrar el popup
}