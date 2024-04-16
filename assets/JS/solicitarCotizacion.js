// Función para mostrar los detalles del servicio
function showDetails(servicio, imagenServicio) {
    // Ocultar el contenedor de las tarjetas
    document.getElementById('cardContainer').style.display = 'none';
    // Mostrar el detalle del servicio seleccionado
    document.getElementById('detalle-servicio').style.display = 'block';
    // Actualizar el nombre del servicio seleccionado
    document.getElementById('servicio-seleccionado').innerText = servicio;
    // Actualizar el atributo src de la imagen
    let src = 'assets/images/' + imagenServicio;
let defaultImage = "assets/images/CCtv.jpg";
document.getElementById('imagen-servicio').src = imagenServicio ? src : defaultImage;
}

// Si se hace clic en cancelar, volver a mostrar las tarjetas y ocultar el detalle del servicio
document.getElementById('cancelar').addEventListener('click', function() {
    document.getElementById('cardContainer').style.display = 'block';
    document.getElementById('detalle-servicio').style.display = 'none';
});

//la lógica para el botón de "Solicitar Cotización" aquí
function cotizar(){
// Obtener el nombre del servicio seleccionado
let servicio = document.getElementById('servicio-seleccionado').innerText.trim();
     // Obtener la fecha actual
let fechaActual = new Date();

// Convertir la fecha a formato ISO8601 y eliminar la información de la zona horaria
let fechaFormateada = fechaActual.toISOString().split('T')[0]; 
// Construir un objeto FormData
let formData = new FormData();

formData.append('servicio', servicio);
formData.append('fecha', fechaFormateada); // Convertir la fecha a formato ISO8601

Swal.fire({
title: '¿Desea solicitar la cotizacion del servicio?',
text: 'Esta acción no se puede deshacer',
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Sí, registrar'
}).then((result) => {
if (result.isConfirmed) {
// Utiliza Fetch para enviar la acción al servidor
fetch('actions/cotizar_servicio.php', {
    method: 'POST',
    body: formData,  // Usar el objeto FormData como cuerpo de la solicitud
})
     .then(response => response.json())
     .then(data => {
        if (data.success === true) {
            Swal.fire({
                    title: 'Éxito',
                    text: data.message,
                    icon: 'success'
                }).then(() => {
                    // Redirigir después de cerrar el cuadro de diálogo de éxito
                    window.location.href = "cotizaciones_servicios.php";
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