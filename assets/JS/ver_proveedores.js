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
          <th class="text-nowrap">informacion de contacto</th>
          <th class="text-nowrap">Calle</th>
          <th class="text-nowrap">Numero</th>
           <th class="text-nowrap">Colonia</th>
          <th class="text-nowrap">CP</th>
          <th class="text-nowrap">Municipio</th>
           <th class="text-nowrap">Estado</th>
          <th class="text-nowrap">Email</th>
          <th class="text-nowrap">Telefono</th>
           <th class="text-nowrap">Detalles</th>
           <th class="text-nowrap">Categoría</th>
          <th class="text-nowrap" colspan="2">Acciones</th></thead>`;

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
                      <td class="text-nowrap">${x.otrosDetalles}</td>
                      <td class="text-nowrap">${x.idCategoria}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${x.idProveedor}" onclick="eliminar(${x.idProveedor})">Eliminar</button></td>
              <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${x.idProveedor}" onclick="cargarForm()">Editar</button></td>
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

// Función para cargar formulario
function cargarForm() {
  let categoria = '';
  const botones = document.querySelectorAll(".bActualizar");

  botones.forEach(boton => {
    boton.addEventListener("click", function () {
      let id = this.dataset.id;
      
      let fila = document.querySelector(`#tablaProveedor tr[data-id='${id}']`);
      let celdas = fila.getElementsByTagName("td");
      
// Obtener los elementos del formulario
     const IdInput = document.getElementById("id");
      const nombreInput = document.getElementById("nombre");
      const apellidoPaternoInput = document.getElementById("apellidoPaterno");
      const apellidoMaternoInput = document.getElementById("apellidoMaterno");
      const emailInput = document.getElementById("email");
      const telefonoInput = document.getElementById("telefono");
      const razonSocialInput = document.getElementById("razonSocial");
      const informacionContactoInput = document.getElementById("informacionContacto");
      const calleInput = document.getElementById("calle");
      const numeroInput = document.getElementById("numero");
      const coloniaInput = document.getElementById("colonia");
      //const estadoInput = document.getElementById("estado");
      //const municipioInput = document.getElementById("municipio");
      const cpInput = document.getElementById("cp");
      const otrosDetallesInput = document.getElementById("otrosDetalles");
      const categoriaInput = document.getElementById("categoria");

      
      // Asignar los datos de la fila al formulario
      IdInput.value = celdas[0].innerHTML;
      nombreInput.value = celdas[1].innerHTML;
      apellidoPaternoInput.value = celdas[2].innerHTML;
      apellidoMaternoInput.value = celdas[3].innerHTML;
      razonSocialInput.value = celdas[4].innerHTML;
      informacionContactoInput.value = celdas[5].innerHTML;
      calleInput.value = celdas[6].innerHTML;
      numeroInput.value = celdas[7].innerHTML;
      coloniaInput.value = celdas[8].innerHTML;
      cpInput.value = celdas[9].innerHTML;
      //municipioInput.value = celdas[10].innerHTML;
      //estadoInput.value = celdas[11].innerHTML;
      emailInput.value = celdas[12].innerHTML;
      telefonoInput.value = celdas[13].innerHTML;
      otrosDetallesInput.value = celdas[14].innerHTML;
      categoria = celdas[15].innerHTML;
      
      let estadoSeleccionado = celdas[11].innerHTML;
      let municipioSeleccionado = celdas[10].innerHTML;
      cargarEstados(estadoSeleccionado);
      cargarMunicipios(estadoSeleccionado, municipioSeleccionado);
      
      // Establecer el valor seleccionado del select
      for (let option of categoriaInput.options) {
        if (option.value === categoria) {
          option.selected = true;
          option.style.display = "none"; // Ocultar la opción
        } else {
          option.style.display = "block"; // Mostrar las demás opciones
        }
      }
  
      // Mostrar el formulario
      document.getElementById("popup").style.display = "block";//estilo para mostrar el popup
   
    });
  });
}

function actualizar(evento) {//metodo para actualizar el registro
  evento.preventDefault();
const datos = new URLSearchParams(new FormData(document.getElementById("formUpdateProveedor")));
Swal.fire({
  title: '¿Desea actualizar los datos del proveeedor?',
  text: 'Esta acción no se puede deshacer',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Sí, registrar'
}).then((result) => {
  if (result.isConfirmed) {
fetch('actions/actualizarproveedor.php', {
    method: 'POST',
    body: datos
})
    .then(response => response.json())
    .then(data => {
      if (data.success == true) {
        Swal.fire({
          title: 'Éxito',
          text: data.message,
          icon: 'success'
      });
        document.getElementById("formUpdateProveedor").reset(); //se limpia el formulario
        document.getElementById("popup").style.display = "none";//estilo para ocultar el popup
        getProveedores();
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


function eliminar(id){

  Swal.fire({
    title: '¿Desea eliminar el registro del proveedor?',
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

        fetch('actions/eliminarproveedor.php', {
          method: 'POST',
          body: formData
        })
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
             const row = document.querySelector(`#tablaProveedor tr[data-id='${id}']`);
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


function cargarEstados(valorInicial) {
  // Cargar estados
  fetch('actions/estados.php')
    .then(response => response.json())
    .then(data => {
      
      const estadosSelect = document.getElementById('estado');
      estadosSelect.innerHTML = `<option value=${valorInicial}>${valorInicial}</option>`;
      
      // Crear y agregar la opción inicial solo si estadosSelect está definido
      if (estadosSelect) {
        // Verificar si los datos son un objeto con la propiedad 'data' que es un array
        if (data && Array.isArray(data.data)) {
          data.data.forEach(estado => {
            const option = document.createElement('option');
            option.value = estado.estado;
            option.textContent = estado.estado;
            estadosSelect.appendChild(option);
          });
        } else {
          console.error('Error: Los datos de estados no son un array válido', data);
        }
      } else {
        console.error('Error: estadosSelect no está definido.');
      }
    })
    .catch(error => {
      console.error('Error al cargar estados: ' + error);
    });
}

function cargarMunicipios(estado, valorInicial) {
  const formData = new FormData();
  formData.append('estado', estado);

  fetch('actions/municipios.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      const municipiosSelect = document.getElementById('municipio');
      municipiosSelect.innerHTML = `<option value=${valorInicial}>${valorInicial}</option>`;
      if (data && Array.isArray(data.data)) {
        data.data.forEach(municipio => {
          const option = document.createElement('option');
          option.value = municipio.municipio;
          option.textContent = municipio.municipio;
          municipiosSelect.appendChild(option);
        });
      } else {
        console.error('Error: Los datos de municipios no son un array válido', data);
      }
    })
    .catch(error => {
      console.error('Error al cargar municipios: ' + error);
    });
}
