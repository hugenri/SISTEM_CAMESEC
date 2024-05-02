
function agregarServicio(evento) {
  evento.preventDefault();

  const formulario = document.getElementById("formServicio");
  const datos = new FormData(formulario);
  Swal.fire({
    title: '¿Desea registar el servicio?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, registrar'
  }).then((result) => {
    if (result.isConfirmed) {
  fetch('actions/agregarservicio.php', {
      method: 'POST',
      body: datos
  })
  .then(response => {
    if (!response.ok) {
        return response.json().then(errorData => {
            throw new Error('Error en la solicitud. Código de estado: ' + response.status + ', Tipo de error: ' + errorData.error + ', Mensaje: ' + errorData.message);
        });
    }
    return response.json(); // Suponiendo que la respuesta es JSON
})
  .then(data => {
      if (data.success == true) {
        Swal.fire({
          title: 'Éxito',
          text: data.message,
          icon: 'success'
      });
          formulario.reset(); // Se limpia el formulario
          formulario.classList.remove('was-validated');
          const modal = document.getElementById('modalServicio');
          const modalBS = bootstrap.Modal.getInstance(modal);
          modalBS.hide(); //Cierra el modal
          get_servicios();
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