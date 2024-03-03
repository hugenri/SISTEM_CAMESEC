document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("formProducto").addEventListener('submit', agregarProducto); 
});

function agregarProducto(evento) {
  evento.preventDefault();

  const formulario = document.getElementById("formProducto");
  const datos = new FormData(formulario);
  Swal.fire({
    title: '¿Desea registarse los datos del producto?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, registrar'
  }).then((result) => {
    if (result.isConfirmed) {
  fetch('actions/agregarproducto.php', {
      method: 'POST',
      body: datos,
     
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

       //  limpiarFormulario("formProducto"); // Aquí se pasa el ID del formulario      } else {
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