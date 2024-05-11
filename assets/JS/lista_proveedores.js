document.addEventListener("DOMContentLoaded", function () {
    getProveedores(); // Llama a la función cuando la página esté cargada
           });


function getProveedores() {
   document.getElementById("NoData").innerHTML = ""; //se limpia la etiqueta
   let formData = new FormData();
    formData.append("action", "mostarProveedores");
 // Obtener las cotizaciones
 fetch('actions/compras.php',{
    method: 'POST', // Especifica que la solicitud sea POST
    body: formData  // Usar el objeto FormData como cuerpo de la solicitud
}).then(response => response.json())
      .then(data => { 
        if (data.success == true) {
          document.getElementById("tablaProveedor").innerHTML = ""; // Limpiamos la tabla
               
          let tabla = `<thead><tr><th class="text-nowrap">ID</th>
          <th class="text-nowrap">Empresa</th>
          <th class="text-nowrap">informacion de contacto</th>
           <th class="text-nowrap">Estado</th>
          <th class="text-nowrap">Email</th>
          <th class="text-nowrap">Telefono</th>
           <th class="text-nowrap">Categoría</th>
          <th class="text-nowrap" colspan="2">Acciones</th></thead>`;

           tabla += `<tbody>`; 
          for (let x of data.datosProveedores) {
             
            tabla += `<tr data-id="${x.idProveedor}"><td class="text-nowrap">${x.idProveedor}</td>
                      <td class="text-nowrap">${x.razonSocial}</td>
                      <td class="text-nowrap">${x.informacionContacto}</td>
                      <td class="text-nowrap">${x.estado}</td>
                      <td class="text-nowrap">${x.email}</td>
                      <td class="text-nowrap">${x.telefono}</td>
                      <td class="text-nowrap">${x.idCategoria}</td>
                      <td><button class="btn custom-button btn-primary btn-sm text-truncate rounded-5"
                       data-id="${x.idProveedor}" onclick="getProveedor(event, ${x.idProveedor})">Ver Datos</button></td>

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
function getProveedor(evento, idProveedor) {
    evento.preventDefault(); // Aquí se corrige el error
    let formData = new FormData();
    formData.append("action", "getProveedor");
    formData.append("idProveedor", idProveedor);

    // Obtener los datos del proveedor
    fetch('actions/compras.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success == true) {
                // Llamar a la función para cargar los datos del proveedor en el formulario
                cargarDatosProveedorEnFormulario(data.datosProveedores);
            } else {
                console.log(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Función para cargar los datos del proveedor en el formulario como texto
function cargarDatosProveedorEnFormulario(proveedor) {
    // Asignar los datos del proveedor a los elementos correspondientes del formulario como texto
    let nombreCompleto = `${proveedor.nombre} ${proveedor.apellidoPaterno} ${proveedor.apellidoMaterno}`;
    document.getElementById("nombreCompleto").textContent = nombreCompleto;
   
    document.getElementById("calle").textContent = proveedor.calle;
    document.getElementById("numero").textContent = proveedor.numero;
    document.getElementById("colonia").textContent = proveedor.colonia;
    document.getElementById("estado").textContent = proveedor.estado;
    document.getElementById("municipio").textContent = proveedor.municipio;
    document.getElementById("cp").textContent = proveedor.cp;
    document.getElementById("email").textContent = proveedor.email;
    document.getElementById("telefono").textContent = proveedor.telefono;
    document.getElementById("informacionContacto").textContent = proveedor.informacionContacto;
    document.getElementById("razonSocial").textContent = proveedor.razonSocial;
    document.getElementById("otrosDetalles").textContent = proveedor.otrosDetalles;
    abrirModal();
}


function cerrarModal(evento){
    evento.preventDefault();

document.getElementById("modalPopup").style.display = "none";

}

function abrirModal(){
    // Mostrar el formulario
    document.getElementById("modalPopup").style.display = "block";
   
   }