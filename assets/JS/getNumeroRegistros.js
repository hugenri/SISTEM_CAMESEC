document.addEventListener("DOMContentLoaded", function() {
    getNumeroRegistros();
    setInterval(getNumeroRegistros, 4 * 60 * 1000);

  });


function getNumeroRegistros(){

    let datos = new FormData();
    datos.append('action', "getNumeroRegistros");


fetch('actions/compras.php', {
   method: 'POST',
   body: datos
}).then(response => response.json())
      .then(data => {
        if (data.success) {
            document.getElementById('numProveedores').textContent = data.response.numProveedores.numRegistros;
            document.getElementById('numOrdenes').textContent = data.response.numOdenesOrdenesCompras.numRegistros;
            document.getElementById('numNuevasOrdenes').textContent = data.response.numNuevasOrdenes.numRegistros;
        }else{

            console.log(message)
        }
      })
      .catch(error => {
        console.error(error);
      });
    
}