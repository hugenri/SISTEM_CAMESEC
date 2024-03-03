document.addEventListener("DOMContentLoaded", function() {

  document.getElementById("formLogin").addEventListener('submit', login); 

});



function login(evento) {

  evento.preventDefault();



  // se obtiene el token de reCAPTCHA

  grecaptcha.execute('6Lcb4OgnAAAAANdIPDiiDfiWcEhW01H4vGXhDIvs', { action: 'login' }).then(function(token) {

    // se agrega el token al campo oculto en el formulario

    document.getElementById("recaptchaToken").value = token;

    document.getElementById("recaptchaAction").value = 'login';



    //  se envía el formulario con el token de reCAPTCHA

    const datos = new URLSearchParams(new FormData(document.getElementById("formLogin")));

    fetch('actions/login.php', {
      method: 'POST',
      body: datos
    })
    .then(response => response.json())

    .then(data => {

      if (data.success == true) {

                location.href = data.url;
      } else {
        Swal.fire('Error', data.message, 'error');
      }
    }).catch(error => {
      console.error('Error:', error);

    });

  });

}