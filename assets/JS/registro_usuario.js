document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("formRegistro").addEventListener('submit', registrar); 
});

function registrar(evento) {
  evento.preventDefault();
  const formulario = document.getElementById("formRegistro");
// se obtiene el token de reCAPTCHA
grecaptcha.execute('6Lcb4OgnAAAAANdIPDiiDfiWcEhW01H4vGXhDIvs', { action: 'login' }).then(function(token) {

  // se agrega el token al campo oculto en el formulario
  document.getElementById("recaptchaToken").value = token;
  document.getElementById("recaptchaAction").value = 'login';

  Swal.fire({
    title: '¿Desea registrarse como usuario?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, registrar'
  }).then((result) => {
    if (result.isConfirmed) {
      //  se envía el formulario con el token de reCAPTCHA
      const datos = new FormData(document.getElementById("formRegistro"));
      fetch('actions/registro_usuario_cliente.php', {
        method: 'POST',
        body: datos
      })
      .then(response => response.json())
      .then(data => {
        if (data.success == true) {
          formulario.reset(); // Se limpia el formulario
          formulario.classList.remove('was-validated');
          mostrarMensajeExito();   
        } else {
          Swal.fire('Error', data.message, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }
  });
});
}

function mostrarMensajeExito() {
  const formulario = document.getElementById("containerFormRegistro");
  const mensajeExito = document.getElementById("registroExito");
  const redireccionarLogin = document.getElementById("redireccionarLogin");

  formulario.classList.add('d-none');
  mensajeExito.classList.remove('d-none');

  redireccionarLogin.addEventListener('click', function() {
    window.location.href = "sesion.php"; // Cambia la URL según tu estructura de archivos
  });
}
