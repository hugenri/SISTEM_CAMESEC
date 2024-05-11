
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
  
  function cerrarPopup(event){
    event.preventDefault(); // Evita el comportamiento predeterminado del evento 

      document.getElementById("modalPopup").style.display = "none";//estilo para cerrar el popup
  
  }