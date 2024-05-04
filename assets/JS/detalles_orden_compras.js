function verDetalles() {
  document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
  let datos = new FormData();
       datos.append('action', "mostar");


  fetch('actions/orden_compras.php', {
      method: 'POST',
      body: datos
  })
    .then(response => response.json())
    .then(data => { 
       
      if (data.success == true) {
        
        document.getElementById("tablaOrdenesCompra").innerHTML = ""; // Limpiamos la tabla
             
        let tabla = `<thead><tr><th class="text-nowrap">ID</th>
        <th class="text-nowrap">Fecha</th>
        <th>Detalles</th></thead>`;

         tabla += `<tbody>`; 
        for (let x of data.datosOrdenesCompra) {
       
          tabla += `<tr data-id="${x.idOrdenCompra}"><td class="text-nowrap">${x.idOrdenCompra}</td>
          <td class="text-nowrap">${x.fecha}</td>
          <td><img src="assets/images/ver.png" alt="ver"  class="tabla-image-accion" onclick="consultarDetalles('${x.idOrdenCompra}')" style="cursor: pointer;">
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

function consultarDetalles(id) {
  let datos = new FormData();
       datos.append('action', "getDetalle");
       datos.append('id', id);
 fetch('actions/orden_compras.php', {
  method: 'POST',
  body: datos
}).then(response => response.json())
    .then(data => {
      if (data.success) {
       
        abrirModalConDescripcion(data.descripcion);
      } else {
        console.error('Error al obtener la descripción.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

function abrirModalConDescripcion(data) {
  const descripcion = data.descripcion; // Accede a la propiedad descripcion del objeto
  document.getElementById('descripcionTextarea').innerHTML = descripcion;
  document.getElementById("popup").style.display = "block";//estilo para mostrar el popup

}