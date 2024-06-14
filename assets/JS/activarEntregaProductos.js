
document.addEventListener("DOMContentLoaded", function() {
    get_ventas();
 });
function get_ventas(){

const solicitudesContainer = document.getElementById("solicitudesContainer");
solicitudesContainer.innerHTML = "";
let formData = new FormData();
formData.append("action", "mostarVenta");

fetch("actions/activarEntregaProductos.php", {
    method: 'POST', // Especifica que la solicitud sea POST
    body: formData  // Usar el objeto FormData como cuerpo de la solicitud
})
 .then(response => response.json())
 .then(data => {
   if (data.success) {
   data.datosVenta.forEach(dato => {
     const card = `
       <div class="col">
         <div class="card card-customServicios">
           <div class="card-body">
             <h5 class="card-title">Servicio: Venta de Productos</h5>
             <p class="card-text">Empresa: ${dato.razonSocial}</p>
             <p class="card-text">Contacto: ${dato.nombre_completo}</p>
             <p class="card-text">Pago realizado: ${dato.pago}</p>
             <p class="card-text">Fecha de pago: ${dato.fecha_pago}</p>
             <div class="row justify-content-between mt-4 mb-3">
                <div class="col-12">
             <button type="button" class="btn btn-primary
              w-100 rounded-5" onclick="abrirModal(event, ${dato.id_venta})">Activar Entrega</button>
             </div>
             </div>
             </div>
         </div>
       </div>
     `;
     solicitudesContainer.innerHTML += card;
   });
     }else{
       solicitudesContainer.innerHTML = "<h4>No se encontraron ventas para entrega.</h4>";
     }
 }).catch(error => console.error("Error al obtener los datos:", error));
}

function abrirModal(event, idVenta){
  event.preventDefault(); // Evita el comportamiento predeterminado del evento 
console.log(idVenta);
  
// Asigna el valor del ID de la orden de compra al campo oculto
document.getElementById('idVenta').value = idVenta;
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


function agregarEntrega(evento) {
    evento.preventDefault();
  
    const formulario = document.getElementById("formEntrega");
    const formData = new FormData(formulario);
    formData.append("action", "registarEntrega");

    Swal.fire({
      title: '¿Desea registar la entrega de la venta?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, registrar'
    }).then((result) => {
      if (result.isConfirmed) {
    fetch('actions/activarEntregaProductos.php', {
        method: 'POST',
        body: formData
    }).then(response => response.json())
    .then(data => {
        if (data.success == true) {
          Swal.fire({
            title: 'Éxito',
            text: data.message,
            icon: 'success'
        });
            formulario.reset(); // Se limpia el formulario
            formulario.classList.remove('was-validated');
            document.getElementById("modalPopup").style.display = "none";//estilo para cerrar el popup
            get_ventas();
        }else {
          // cuando data.success es false
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
    
    function cerrarPopup(event){
      event.preventDefault(); // Evita el comportamiento predeterminado del evento 
  
        document.getElementById("modalPopup").style.display = "none";//estilo para cerrar el popup
    
    }