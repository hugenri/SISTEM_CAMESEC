function getProveedores() {
  document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta

fetch("actions/verproveedores.php")
    .then(response => response.json())
    .then(data => { 
   
      if (data.success == true) {
        document.getElementById("tablaProveedor").innerHTML = ""; // Limpiamos la tabla
             
        let tabla = `<thead><tr><th class="text-nowrap">ID</th><th class="text-nowrap">
        Nombre</th><th class="text-nowrap">Apellido paterno</th>
        <th class="text-nowrap">Apellido materno</th>
        <th class="text-nowrap">Razon Social</th>
        <th class="text-nowrap">Categoría asignada</th>
        <th class="text-nowrap" colspan="2">Asignar categoría</th></thead>`;

         tabla += `<tbody>`; 
        for (let x of data.dataprovider) {
       
          tabla += `<tr data-id="${x.idProveedor}"><td class="text-nowrap">${x.idProveedor}</td>
          <td class="text-nowrap">${x.nombre}</td>
                    <td class="text-nowrap">${x.apellidoPaterno}</td>
                    <td class="text-nowrap">${x.apellidoMaterno}</td>
                    <td class="text-nowrap">${x.razonSocial}</td>
                    <td class="text-nowrap">${x.idCategoria}</td>
                   <td><select id="categoria_${x.idProveedor}" class="form-select" onchange="asignarCategoria(this.value, ${x.idProveedor})">
                   <option value="">Selecciona una categoría</option>
                   <option value="Fabricante">Fabricante</option>
                   <option value="Distribuidor">Distribuidor</option>
                   <option value="CCTV">CCTV</option>
                   <option value="Cámaras">Cámaras</option>                   
                   <option value="Cableado">Cableado</option>
                   <option value="Otros">Otros</option>
               </select></td>
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

function asignarCategoria(categoria, idProveedor) {
  // Aquí puedes usar idProveedor para identificar el proveedor

  if (categoria) {
    Swal.fire({
      title: '¿Desea agregar la categoria?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, agregar'
    }).then((result) => {
      if (result.isConfirmed) {
          const formData = new FormData();
          formData.append('idProveedor', idProveedor);
          formData.append('categoria', categoria);
    
          fetch('actions/asignarcategoria.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
           
              if (data.success == true) {
                Swal.fire({
                  title: 'Éxito',
                  text: data.message,
                  icon: 'success'
              });
                  getProveedores();
              } else {
                Swal.fire('Error', data.message, 'error');
    
              }
          })
          .catch(error => {
              console.error('Error:', error);
          });
        }
    });
        return ;
  }
}






