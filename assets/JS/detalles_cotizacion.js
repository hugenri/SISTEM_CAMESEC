function verDetalles() {
  document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
fetch("actions/vercotizaciones.php")
    .then(response => response.json())
    .then(data => { 
       
      if (data.success == true) {
        
        document.getElementById("tablaCotizaciones").innerHTML = ""; // Limpiamos la tabla
             
        let tabla = `<thead><tr><th class="text-nowrap">ID</th>
        <th class="text-nowrap">Fecha</th>
        <th class="text-nowrap">Cliente</th>
        <th class="text-nowrap">Servicio</th>
        <th>Detalles</th>`;

         tabla += `<tbody>`; 
        for (let x of data.dataCotizaciones) {
       
          tabla += `<tr data-id="${x.idCotizacion}"><td class="text-nowrap">${x.idCotizacion}</td>
          <td class="text-nowrap">${x.fecha}</td>
          <td class="text-nowrap">${x.razonSocialCliente}</td>
          <td class="text-nowrap">${x.servicio}</td>
          <td>
          <img src="assets/images/ver.png" alt="ver"  class="tabla-image-accion" onclick="consultarDetalles('vercotizaciones', ${x.idCotizacion})" style="cursor: pointer;">
          </td>
          </tr>`;
        }
        tabla += `</tbody>`;
        document.getElementById("tablaCotizaciones").innerHTML = tabla;
      } 
    else {
      document.getElementById("tablaCotizaciones").innerHTML = ""; // Limpiamos la tabla
                document.getElementById("NoData").innerHTML = data.message;
              
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });

}
