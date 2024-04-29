function getProductos() {
    document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta

fetch("actions/verproductos.php")
      .then(response => response.json())
      .then(data => { 
     
        if (data.success == true) {
          document.getElementById("tablaProducto").innerHTML = ""; // Limpiamos la tabla
               
          let tabla = `<thead><tr><th class="text-nowrap">ID</th>
          <th class="text-nowrap">Nombre</th>
          <th class="text-nowrap">Proveedor</th>
          <th class="text-nowrap">Precio</th>
          <th class="text-nowrap">Descripción</th>
          <th class="text-nowrap">Stock</th>
          <th class="text-nowrap">Imagen</th>
          <th class="text-nowrap" colspan="2">Acciones</th></thead>`;

           tabla += `<tbody>`; 
          for (let x of data.dataProduct) {
         
            tabla += `<tr data-id="${x.id}">
            <td class="text-nowrap">${x.id}</td>
            <td class="text-nowrap">${x.nombre}</td>
            <td class="text-nowrap">${x. razon_social_proveedor}</td>
             <td class="text-nowrap">${x.precio}</td>
             <td>${x.descripcion}</td>
             <td class="text-nowrap">${x.stock}</td>
             <td class="text-nowrap"><img src="assets/images/productos/${x.imagen}" alt="Imagen del producto" style="width: 50px; height: 50px;"></td>                    
            <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${x.id}" onclick="eliminar('${x.id}', '${x.imagen}')">Eliminar</button></td>
            <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${x.id}" onclick="cargarForm()">Editar</button></td>
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

// Función para cargar formulario
function cargarForm() {
  document.getElementById('name_image').value = '';
  const botones = document.querySelectorAll(".bActualizar");

  botones.forEach(boton => {
    boton.addEventListener("click", function () {
      let id = this.dataset.id;
  
      let fila = document.querySelector(`#tablaProducto tr[data-id='${id}']`);
      let celdas = fila.getElementsByTagName("td");
      
// Obtener los elementos del formulario
     const IdInput = document.getElementById("id");
      const nombreInput = document.getElementById("nombre");
      const precioInput = document.getElementById("precio");
      const descripcionInput = document.getElementById("descripcion");
      const stockInput = document.getElementById("stock");
      const pathImage = document.getElementById("pathImage");

      
      
      // Asignar los datos de la fila al formulario
      IdInput.value = celdas[0].innerHTML;
      nombreInput.value = celdas[1].innerHTML;
      let razon_socialProveedor = celdas[2].innerHTML;
      precioInput.value = celdas[3].innerHTML;
      descripcionInput.value = celdas[4].innerHTML;
      stockInput.value = celdas[5].innerHTML;
      // Obtener la ruta de la imagen
      const imagenSrc = celdas[6].querySelector('img').getAttribute('src');
      // Asignar la ruta de la imagen al atributo src del elemento de entrada de imagen
    pathImage.value = imagenSrc;
      document.getElementById("popup").style.display = "block";//estilo para mostrar el popup
     
      cargarProveedores(razon_socialProveedor);
   
    });
  });
}

function actualizar(evento) {//metodo para actualizar el registro
  evento.preventDefault();
  const formulario = document.getElementById("formUpdateProducto");
  const datos = new FormData(formulario);
  
  Swal.fire({
    title: '¿Desea actualizar los datos del producto?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, registrar'
  }).then((result) => {
    if (result.isConfirmed) {
  fetch('actions/actualizarproducto.php', {
      method: 'POST',
      body: datos
     
  }).then(response => response.json())

    .then(data => {
      if (data.success == true) {
        Swal.fire({
          title: 'Éxito',
          text: data.message,
          icon: 'success'
      });
        formulario.classList.remove('was-validated');
        formulario.reset(); //se limpia el formulario
        document.getElementById("popup").style.display = "none";//estilo para ocultar el popup
        getProductos();
      }else {
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


function eliminar(id, image){

  Swal.fire({
    title: '¿Desea eliminar el registro del producto?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar'
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
        formData.append('id', id);
        formData.append('image', image);

        fetch('actions/eliminarproducto.php', {
          method: 'POST',
          body: formData
        })
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
             const row = document.querySelector(`#tablaProducto tr[data-id='${id}']`);
             if (row) {
                   row.remove();
                }
                Swal.fire({
                  title: 'Éxito',
                  text: data.message,
                  icon: 'success'
              });
          }else {
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
function cargarProveedores(proveedorRazonSocial) { 
  // Cargar proveedores al inicio
  fetch('actions/getProveedores.php')
  .then(response => response.json())
  .then(data => {
      const proveedorSelect = document.getElementById('proveedor');
      proveedorSelect.innerHTML = '';
      
      // Verificar si los datos son un objeto con la propiedad 'datosProveedor' que es un array
      if (data && Array.isArray(data.datosProveedor)) {
          data.datosProveedor.forEach(proveedor => { 
              // Creamos primero la opción que cumple la condición
              if(proveedorRazonSocial == proveedor.razonSocial) {
                  const option = document.createElement('option');
                  option.value = proveedor.idProveedor;
                  option.textContent = proveedor.razonSocial;
                  proveedorSelect.appendChild(option);
              }
          });
          
          // Luego agregamos las demás opciones
          data.datosProveedor.forEach(proveedor => { 
              if(proveedorRazonSocial != proveedor.razonSocial) {
                  const option = document.createElement('option');
                  option.value = proveedor.idProveedor;
                  option.textContent = proveedor.razonSocial;
                  proveedorSelect.appendChild(option);
              }
          });
      } else {
          console.error('Error: Los datos de proveedores no son un array válido', data);
      }
  })
  .catch(error => {
      console.error('Error al cargar proveedores: ' + error);
  });
}

/*
function cargarProveedores(){ 
   // Cargar estados al inicio
   fetch('actions/getProveedores.php')
   .then(response => response.json())
   .then(data => {
    const proveedorSelect = document.getElementById('proveedor');
    proveedorSelect.innerHTML = '';
    const option1 = document.createElement('option');           
    option1.value = '';
    option1.textContent = 'Seleccionar Proveedor';
    proveedorSelect.appendChild(option1);
       // Verificar si los datos son un objeto con la propiedad 'data' que es un array
       if (data && Array.isArray(data.datosProveedor)) {
           data.datosProveedor.forEach(proveedor => {    
            const option = document.createElement('option');           
               option.value = proveedor.idProveedor;
               option.textContent = proveedor.razonSocial;
               proveedorSelect.appendChild(option);
           });
       } else {
           console.error('Error: Los datos de estados no son un array válido', data);
       }
   })
   .catch(error => {
       console.error('Error al cargar estados: ' + error);
   });

}
*/