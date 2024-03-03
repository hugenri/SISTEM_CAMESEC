function verDetalles() {
  document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
fetch("actions/verproductos.php")
    .then(response => response.json())
    .then(data => { 
       
      if (data.success == true) {
        
        document.getElementById("tablaProducto").innerHTML = ""; // Limpiamos la tabla
             
        let tabla = `<thead><tr><th class="text-nowrap">ID</th>
        <th class="text-nowrap">Nombre</th>
        <th>Detalles</th>`;

         tabla += `<tbody>`; 
        for (let x of data.dataProduct) {
       
          tabla += `<tr data-id="${x.id}"><td class="text-nowrap">${x.id}</td>
          <td class="text-nowrap">${x.nombre}</td>
          <td><img src="assets/images/ver.png" alt="ver"  class="tabla-image-accion" onclick="consultarDetalles('verproductos', ${x.id})" style="cursor: pointer;">
          </td>
          </tr>`;
        }
        tabla += `</tbody>`;
        document.getElementById("tablaProducto").innerHTML = tabla;
      } 
    else {
      document.getElementById("tablaProducto").innerHTML = ""; // Limpiamos la tabla
                document.getElementById("NoData").innerHTML = data.message;
              
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });

}
