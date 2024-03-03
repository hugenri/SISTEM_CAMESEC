document.addEventListener("DOMContentLoaded", function() {//con el submit se ejecuta el login
    document.getElementById("formProveedor").addEventListener('submit', agregarproveedor); 
    });
    
  
    function agregarproveedor(evento) {
      evento.preventDefault();

      const formulario = document.getElementById("formProveedor");
      let formData = new FormData(formulario);
      Swal.fire({
      title: '¿Desea registarse los datos del proveedor?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, registrar'
    }).then((result) => {
      if (result.isConfirmed) {
    fetch('actions/agregarproveedor.php', {
        method: 'POST',
        body: formData
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
          } else {
            Swal.fire('Error', data.message, 'error');

          }
          
          }
        ).catch(error => {
      console.error('Error:', error);
    });
  }
});
  return ;
}