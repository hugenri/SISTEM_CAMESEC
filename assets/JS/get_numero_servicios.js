
 document.addEventListener("DOMContentLoaded", function () {
    getCounts(); // Llama a la función cuando la página esté cargada
      setInterval(getCounts, 120000);
           });


function getCounts(){


    fetch('actions/get_numero_servicios.php')
      .then(response => response.json())
      .then(data => {
        if (data.success) {
            document.getElementById('numServicios').textContent = data.response.numServicios.numRegistros;
            document.getElementById('numNuevosServicios').textContent = data.response.numNuevosServicios.numRegistros;
            
        }else{
            console.log('sin datos');
        }
      })
      .catch(error => {
        console.error(error);
      });
    
}
