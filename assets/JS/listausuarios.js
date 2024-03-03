function verUsuarios() {

    document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta



fetch("actions/viewUsers.php")

      .then(response => response.json())

      .then(data => { 
        if (data.success == true) {

          document.getElementById("tablaUsuarios").innerHTML = ""; // Limpiamos la tabla

             let tabla = `<thead><tr><th class="text-nowrap">ID</th><th class="text-nowrap">
             nombre</th><th class="text-nowrap">apellido paterno</th><th class="text-nowrap">Apellido materno</th><th class="text-nowrap">Email</th>
             <th class="text-nowrap">Rol</th><th class="text-nowrap" colspan="2">Acciones</th></thead>`;

  

           tabla += `<tbody>`; 

          for (let x of data.dataUsers) {

            tabla += `<tr data-id="${x.id}"><td class="text-nowrap">${x.id}</td>
            <td class="text-nowrap">${x.nombre}</td>
                      <td class="text-nowrap">${x.apellidoPaterno}</td>
                      <td class="text-nowrap">${x.apellidoMaterno}</td>
                      <td class="text-nowrap">${x.email}</td>
                      <td class="text-nowrap">${x.rol_usuario}</td>
                      <td><button class="bEliminar custom-button btn btn-danger btn-sm" data-id="${x.id}" onclick="eliminar(${x.id})">Eliminar</button></td>
                     <td><button class="bActualizar btn custom-button btn-primary btn-sm" data-id="${x.id}" onclick="cargarForm()">Editar</button></td>

                      </tr>`;

          }

          tabla += `</tbody>`;

          document.getElementById("tablaUsuarios").innerHTML = tabla;

        } 

      else {

        document.getElementById("tablaUsuarios").innerHTML = ""; // Limpiamos la tabla

                  document.getElementById("NoData").innerHTML = data.message;

                

        }

      })

      .catch(error => {

        console.error('Error:', error);

      });
}


function cargarForm() {
  const botones = document.querySelectorAll(".bActualizar");

  botones.forEach(boton => {
    boton.addEventListener("click", function () {
      let id = this.dataset.id;
      let fila = document.querySelector(`#tablaUsuarios tr[data-id='${id}']`);
      let celdas = fila.getElementsByTagName("td");

      // Obtener los elementos del formulario
      const IdInput = document.getElementById("id");
      const nombreInput = document.getElementById("nombre");
      const apellidoPaternoInput = document.getElementById("apellidoPaterno");
      const apellidoMaternoInput = document.getElementById("apellidoMaterno");
      const emailInput = document.getElementById("email");
      const rolSelect = document.getElementById("rol");

      // Asignar los datos de la fila al formulario
      IdInput.value = id;
      nombreInput.value = celdas[1].innerHTML;
      apellidoPaternoInput.value = celdas[2].innerHTML;
      apellidoMaternoInput.value = celdas[3].innerHTML;
      emailInput.value = celdas[4].innerHTML;
      const rolUsuario = celdas[5].innerHTML;

      // Establecer el valor seleccionado del select
      for (let option of rolSelect.options) {
        if (option.value === rolUsuario) {
          option.selected = true;
          option.style.display = "none"; // Ocultar la opción
        } else {
          option.style.display = "block"; // Mostrar las demás opciones
        }
      }

      // Mostrar el formulario
      document.getElementById("popup").style.display = "block";
    });
  });
}





function actualizar(evento) {//metodo para actualizar el registro
  evento.preventDefault();

  const formulario = document.getElementById("formUpdate");
  const datos = new  FormData(document.getElementById("formUpdate"));
  Swal.fire({
    title: '¿Desea actualizar los datos del usuario?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, actualizar'
  }).then((result) => {
    if (result.isConfirmed) {
fetch('actions/actualizarUsuario.php', {
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
        formulario.reset(); // Se limpia el formulario
            formulario.classList.remove('was-validated');  
        verUsuarios();
        document.getElementById("popup").style.display = "none";//estilo para ocultar el popup
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
    title: '¿Desea emininar el registro del usuario?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('actions/eliminarUsuario.php?id='+id)
      .then(response => response.json())
      .then(data => {
          if (data.success == true) {
             const row = document.querySelector(`#tablaUsuarios tr[data-id='${id}']`);
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


