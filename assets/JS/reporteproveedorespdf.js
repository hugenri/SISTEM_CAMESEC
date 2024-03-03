function reporteProveedorespdf() {
    document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
// Deshabilitar el enlace si no hay datos
document.getElementById("pdfLink").setAttribute("href", "javascript:void(0);");
fetch("actions/verproveedores.php")
      .then(response => response.json())
      .then(data => { 
     
        if (data.success == true) {
          // Habilitar el enlace si hay datos
        document.getElementById("pdfLink").setAttribute("href", "actions/reporteproveedoresPDF.php");
          document.getElementById("tablaProveedor").innerHTML = ""; // Limpiamos la tabla
               
          let tabla = `<thead><tr><th class="text-nowrap">ID</th><th class="text-nowrap">
          Nombre</th><th class="text-nowrap">Apellido paterno</th>
          <th class="text-nowrap">Apellido materno</th>
          <th class="text-nowrap">Razon Social</th>
          <th class="text-nowrap">Informacion contacto</th>
          <th class="text-nowrap">Calle</th>
          <th class="text-nowrap">Numero</th>
           <th class="text-nowrap">Colonia</th>
          <th class="text-nowrap">CP</th>
          <th class="text-nowrap">Municipio</th>
           <th class="text-nowrap">Estado</th>
          <th class="text-nowrap">Email</th>
          <th class="text-nowrap">Telefono</th>
           <th class="text-nowrap">Categoría</th>`;


           tabla += `<tbody>`; 
          for (let x of data.dataprovider) {
         
            tabla += `<tr data-id="${x.idProveedor}"><td class="text-nowrap">${x.idProveedor}</td>
            <td class="text-nowrap">${x.nombre}</td>
                      <td class="text-nowrap">${x.apellidoPaterno}</td>
                      <td class="text-nowrap">${x.apellidoMaterno}</td>
                      <td class="text-nowrap">${x.razonSocial}</td>
                      <td class="text-nowrap">${x.informacionContacto}</td>
                      <td class="text-nowrap">${x.calle}</td>
                      <td class="text-nowrap">${x.numero}</td>
                      <td class="text-nowrap">${x.colonia}</td>
                      <td class="text-nowrap">${x.cp}</td>
                      <td class="text-nowrap">${x.municipio}</td>
                      <td class="text-nowrap">${x.estado}</td>
                      <td class="text-nowrap">${x.email}</td>
                      <td class="text-nowrap">${x.telefono}</td>
                      <td class="text-nowrap">${x.idCategoria}</td>                      
                      
                      </tr>`;
          }
          tabla += `</tbody>`;
          document.getElementById("tablaProveedor").innerHTML = tabla;
        } 
      else {
        document.getElementById("tablaProveedor").innerHTML = ""; // Limpiamos la tabla
                  document.getElementById("NoData").innerHTML = data.message;
                
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });

}
