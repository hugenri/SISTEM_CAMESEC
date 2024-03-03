

document.addEventListener("DOMContentLoaded", function() {//con el submit se ejecuta la valudacion
document.getElementById("formUpdate").addEventListener('submit', actualizar); 
    });

    function actualizar(evento) {//metodo para actualizar el registro
      evento.preventDefault();

      let formulario = document.getElementById("FormUpdate");
      let formData = new FormData(formulario);
      Swal.fire({
      title: '¿Desea actualizar los datos del usuario?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, actualizar'
    }).then((result) => {
      if (result.isConfirmed) {
    fetch('actions/actualizarUsuario.php', {
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
            document.getElementById("popup").style.display = "none";//estilo para ocultar el popup

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