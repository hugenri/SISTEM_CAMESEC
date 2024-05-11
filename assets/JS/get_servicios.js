
document.addEventListener("DOMContentLoaded", function() {
    get_servicios();
 });
function get_servicios(){

const solicitudesContainer = document.getElementById("solicitudesContainer");
solicitudesContainer.innerHTML = "";

fetch("actions/nuevos_servicios.php") // Reemplaza "ruta_a_tu_archivo_php.php" con la ruta correcta a tu archivo PHP que realiza la consulta a la base de datos y devuelve los resultados
 .then(response => response.json())
 .then(data => {
   if (data.success) {
   data.datos.forEach(dato => {
     const card = `
       <div class="col">
         <div class="card card-customServicios">
           <div class="card-body">
             <h5 class="card-title">Servicio: ${dato.servicio}</h5>
             <p class="card-text">Empresa: ${dato.razon_social_cliente}</p>
             <p class="card-text">Contacto: ${dato.nombre_cliente} ${dato.apellido_paterno_cliente} ${dato.apellido_materno_cliente}</p>
             <p class="card-text">Email: ${dato.email_cliente}</p>
             <p class="card-text">Teléfono: ${dato.telefono_cliente}</p>
             <div class="row justify-content-between mt-4 mb-3">
                <div class="col-12">
             <button type="button" class="btn btn-primary
              w-100 rounded-5" onclick="abrirModal(event, ${dato.idOrdenCompra})">Activar Servicio</button>
             </div>
             </div>
             </div>
         </div>
       </div>
     `;
     solicitudesContainer.innerHTML += card;
   });
     }else{
       solicitudesContainer.innerHTML = "<h4>No se encontraron servicios para realizar.</h4>";
     }
 }).catch(error => console.error("Error al obtener los datos:", error));
}

function abrirModal(event, idOrdenCompra){
  event.preventDefault(); // Evita el comportamiento predeterminado del evento 

  
// Asigna el valor del ID de la orden de compra al campo oculto
document.getElementById('idOrdenCompra').value = idOrdenCompra;
  // Mostrar el formulario
  document.getElementById("modalPopup").style.display = "block";//estilo para mostrar el popup
get_empleados();
  }


function get_empleados(){

// Fetch para obtener la lista de empleados
fetch("actions/get_empleados.php")
.then(response => response.json())
.then(data => {
const responsableSelect = document.getElementById("responsable");
// Limpiar opciones existentes
responsableSelect.innerHTML = "";
// Crear la opción para "Seleccione un responsable"
const defaultOption = document.createElement("option");
     defaultOption.value = ''; // Ajusta esto según el ID del empleado en tu base de datos
     defaultOption.text = 'Seleccione un responsable'; // Ajusta esto según la estructura de datos de tu empleado
     responsableSelect.appendChild(defaultOption);
     const option = document.createElement("option");

// Agregar una opción por cada empleado
data.datos.forEach(empleado => {
option.value = empleado.id; // Ajusta esto según el ID del empleado en tu base de datos
option.text = empleado.nombre_completo; // Ajusta esto según la estructura de datos de tu empleado
responsableSelect.appendChild(option);
});
})
.catch(error => console.error("Error al obtener la lista de empleados:", error));

}   