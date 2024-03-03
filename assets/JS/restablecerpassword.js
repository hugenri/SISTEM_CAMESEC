document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("formRP").addEventListener('submit', restablecerPassword); 

    });

    function restablecerPassword(evento) {
      evento.preventDefault();
    const datos = new URLSearchParams(new FormData(document.getElementById("formRP")));

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

    fetch('actions/restablecerpassword.php', {
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
        document.getElementById("formRP").reset(); //se limpia el formulario

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