document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("formRP").addEventListener('submit', restablecerPassword); 

    });

    function restablecerPassword(evento) {
      evento.preventDefault();
	let formulario = document.getElementById("formRP");
  let datos = new FormData(formulario);

    Swal.fire({
      title: '¿Desea restablecer el password?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, restablecer'
    }).then((result) => {
      if (result.isConfirmed) {

    fetch('actions/restablecerpasswordCliente.php', {
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

          } else {
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