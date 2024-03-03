function getCounts(){


    fetch('actions/getCounts.php')
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          console.error(data.error);
        } else {
          document.getElementById('numUsuarios').textContent = data.numUsuarios;
          document.getElementById('numClientes').textContent = data.numClientes;
          document.getElementById('numProveedores').textContent = data.numProveedores;
          document.getElementById('numProductos').textContent = data.numProductos;
          document.getElementById('numServicios').textContent = data.numServicios;
          document.getElementById('numRequisiciones').textContent = data.numRequisiciones;
          document.getElementById('numCotizaciones').textContent = data.numCotizaciones;
          document.getElementById('numOrdenesCompra').textContent = data.numOrdenesCompra;


        }
      })
      .catch(error => {
        console.error(error);
      });
    
}