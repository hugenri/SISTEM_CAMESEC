function verDetalles() {
  document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
fetch("actions/verservicios.php")
    .then(response => response.json())
    .then(data => { 
       
      if (data.success == true) {
        
        document.getElementById("tablaServicio").innerHTML = ""; // Limpiamos la tabla
             
        let tabla = `<thead><tr><th class="text-nowrap">ID</th>
        <th class="text-nowrap">Nombre</th>
        <th>Detalles</th>`;

         tabla += `<tbody>`; 
        for (let x of data.dataServices) {
       
          tabla += `<tr data-id="${x.idServicio}"><td class="text-nowrap">${x.idServicio}</td>
          <td class="text-nowrap">${x.nombre}</td>
         <td> <img src="assets/images/ver.png" alt="ver"  class="tabla-image-accion" onclick="consultarDetalles('verservicios', ${x.idServicio})" style="cursor: pointer;">
         </td
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
