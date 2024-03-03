document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("formCompra").addEventListener('submit', crearCompra); 
});

function crearCompra(evento) {
  evento.preventDefault();

  const formulario = document.getElementById("formCompra");
  const datos = new FormData(formulario);
  Swal.fire({
    title: '¿Desea registar los datos de la compra?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, registrar'
  }).then((result) => {
    if (result.isConfirmed) {
  fetch('actions/crearcompra.php', {
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
