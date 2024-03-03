document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("formCotizacion").addEventListener('submit', crearCotizacion); 
});

function crearCotizacion(evento) {
  evento.preventDefault();

  const formulario = document.getElementById("formCotizacion");
  const datos = new FormData(formulario);
  Swal.fire({
    title: '¿Desea registar los datos de la cotizacion?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, registrar'
  }).then((result) => {
    if (result.isConfirmed) {
  fetch('actions/crearcotizacion.php', {
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