function verDetalles() {
  document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
fetch("actions/verproductos.php")
    .then(response => response.json())
    .then(data => { 
       
      if (data.success == true) {
        
        document.getElementById("tablaProducto").innerHTML = ""; // Limpiamos la tabla
             
        let tabla = `<thead><tr><th class="text-nowrap">ID</th>
        <th class="text-nowrap">Nombre</th>
        <th>Detalles</th></thead>`;

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

function consultarDetalles(action, id) {
  fetch('actions/detalles_producto.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `id=${id}`,
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
       console.log(data);
        abrirModalConDescripcion(data.datosProducto);
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
  const imagen =  data.imagen; // que data.imagen contiene la URL de la imagen
  // Asignar la URL de la imagen al atributo src del elemento img
  document.getElementById('imagenDescripcion').src = "assets/images/productos/"+ imagen;

  document.getElementById("popup").style.display = "block";//estilo para mostrar el popup

}