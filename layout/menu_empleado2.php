<nav>

<div class="custom-topnav" id="myTopnav">
  <a href="home.php" class="active icon-a" style="display: flex; align-items: center;">
    <img src="assets/images/home.png" alt="Home" style="width: 25px; height: 25px;">
  </a>
  <div class="custom-dropdown">
    <button class="dropbtn">Entregas de productos
      <i></i>
    </button>
    <div class="dropdown-content">
      <a href="entregaProductos.php">Ver nuevas entregas de productos</a>
      <a href="entregas.php">Ver  entregas de productos</a>

     
    </div>
  </div> 
  <div class="custom-dropdown">
    <button class="dropbtn">Servicios 
      <i></i>
    </button>
    <div class="dropdown-content">
      <a href="servicios.php">Ver servicios</a>
      <a href="nuevos_servicios.php">Ver nuevos servicios</a>

      
    </div>
  </div> 

  

  <div class="user-menu custom-dropdown">
      <button class="dropbtn">
        <img src="assets/images/usuario.png" alt="Usuario Imagen" style="width: 24px; height: 24px; border-radius: 50%;">
        <?=$session->getSessionVariable('nombre') ?>
        <i></i>
      </button>
      <div class="dropdown-content">
        <a href="clases/cerrar_sesion.php">Salir</a>
      </div>
    </div>

  <a href="javascript:void(0);" style="font-size:19px; margin-right: 10px;" class="icon" onclick="responsive_topnav()">&#9776;</a>

</div>

</nav>