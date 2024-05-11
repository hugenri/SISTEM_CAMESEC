
 document.addEventListener("DOMContentLoaded", function () {
    getCounts(); // Llama a la función cuando la página esté cargada
      setInterval(getCounts, 120000);
           });


function getCounts(){


    fetch('actions/get_numero_facturas.php')
      .then(response => response.json())
      .then(data => {
        if (data.success) {
            document.getElementById('numFacturas').textContent = data.response.numFacturas.numRegistros;
            document.getElementById('numNuevasFacturas').textContent = data.response.numNuevasFacturas.numRegistros;
   
            
        }else{
            console.log('sin datos');
        }
      })
      .catch(error => {
        console.error(error);
      });
    
}
