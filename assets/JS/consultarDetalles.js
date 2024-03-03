
function consultarDetalles(action, id) {
    fetch('actions/'+action+'.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${id}`,
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
         
          abrirModalConDescripcion(data.detalles);
        } else {
          console.error('Error al obtener la descripción.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }
  
  function abrirModalConDescripcion(data) {
    const descripcion = data.descripcion; // Accede a la propiedad descripcion del objeto
    document.getElementById('descripcionTextarea').innerHTML = descripcion;
    document.getElementById("popup").style.display = "block";//estilo para mostrar el popup
  
  }