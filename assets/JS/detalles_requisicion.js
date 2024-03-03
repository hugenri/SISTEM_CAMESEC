function verDetalles() {
  document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
fetch("actions/ver_requisiciones.php")
    .then(response => response.json())
    .then(data => { 
       
      if (data.success == true) {
        
        document.getElementById("tablaRequisicion").innerHTML = ""; // Limpiamos la tabla
             
        let tabla = `<thead><tr><th class="text-nowrap">ID</th>
        <th class="text-nowrap">Fecha</th>
        <th>Detalles</th>`;

         tabla += `<tbody>`; 
        for (let requisicion of data.dataRequisiciones) {
          tabla += `<tr data-id="${requisicion.idRequisicion}"><td class="text-nowrap">${requisicion.idRequisicion}</td>
          <td class="text-nowrap">${requisicion.fecha}</td>
          <td><img src="assets/images/ver.png" alt="ver"  class="tabla-image-accion" onclick="consultarDetalles('ver_requisiciones', ${requisicion.idRequisicion})" style="cursor: pointer;">
          </td>
          </tr>`;
        }
        tabla += `</tbody>`;
        document.getElementById("tablaRequisicion").innerHTML = tabla;
      } 
    else {
      document.getElementById("tablaRequisicion").innerHTML = ""; // Limpiamos la tabla
                document.getElementById("NoData").innerHTML = data.message;
              
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });

}

