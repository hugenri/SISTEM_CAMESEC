function verDetalles() {
  document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
fetch("actions/vercompras.php")
    .then(response => response.json())
    .then(data => { 
       
      if (data.success == true) {
        
        document.getElementById("tablaOrdenesCompra").innerHTML = ""; // Limpiamos la tabla
             
        let tabla = `<thead><tr><th class="text-nowrap">ID</th>
        <th class="text-nowrap">Fecha</th>
        <th>Detalles</th>`;

         tabla += `<tbody>`; 
        for (let x of data.dataOrdenesCompra) {
       
          tabla += `<tr data-id="${x.idOrdenCompra}"><td class="text-nowrap">${x.idOrdenCompra}</td>
          <td class="text-nowrap">${x.fecha}</td>
          <td><img src="assets/images/ver.png" alt="ver"  class="tabla-image-accion" onclick="consultarDetalles('vercompras', ${x.idOrdenCompra})" style="cursor: pointer;">
          </td>
          </tr>`;
        }
        tabla += `</tbody>`;
        document.getElementById("tablaOrdenesCompra").innerHTML = tabla;
      } 
    else {
      document.getElementById("tablaOrdenesCompra").innerHTML = ""; // Limpiamos la tabla
                document.getElementById("NoData").innerHTML = data.message;
              
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });

}
