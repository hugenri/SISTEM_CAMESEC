document.addEventListener("DOMContentLoaded", function () {
    
    const passwordInput = document.getElementById("password");
    const passwordCInput = document.getElementById("passwordC");
    const passwordMismatchFeedback = document.getElementById("passwordMismatchFeedback");

    // Función para comparar contraseñas
    function comparePasswords() {
      const password = passwordInput.value.trim();
      const confirmPassword = passwordCInput.value.trim();
     
         // Verificar si ambos campos están llenos antes de la comparación
         if (passwordInput.value && passwordCInput.value) {
             if (passwordCInput.value !== passwordInput.value) {
             passwordMismatchFeedback.innerHTML = "La confirmación de la contraseña no coincide con la contraseña";
                 passwordMismatchFeedback.style.display = "block";
             } else {
                 passwordMismatchFeedback.style.display = "none";
             }
         } else {
             // Limpiar el mensaje de error si algún campo está vacío
             passwordMismatchFeedback.style.display = "none";
         }
     }
     

    // Escuchar el evento de entrada en Confirmar Contraseña
    passwordCInput.addEventListener('input', function () {
        comparePasswords();
    });

    // Escuchar el evento de entrada en el formulario
    formulario.addEventListener('input', function (event) {
        if (event.target.checkValidity()) {
            event.target.classList.remove('is-invalid');
        } else {
            event.target.classList.add('is-invalid');
        }

        // Comparar contraseñas
        if (event.target === passwordInput || event.target === passwordCInput) {
            comparePasswords();
        }
    });

    formulario.addEventListener('submit', function (event) {
        if (!formulario.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        formulario.classList.add('was-validated');
    });
});
