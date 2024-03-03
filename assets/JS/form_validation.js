formulario.addEventListener('input', function (event) {
    if (event.target.checkValidity()) {
      event.target.classList.remove('is-invalid');
    } else {
      event.target.classList.add('is-invalid');
    }
  });
  
  formulario.addEventListener('submit', function (event) {
    if (!formulario.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
  
    formulario.classList.add('was-validated');
  });