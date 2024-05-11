<nav>

<div class="custom-topnav" id="myTopnav">
  <a href="compras.php" class="active icon-a" style="display: flex; align-items: center;">
    <img src="assets/images/home.png" alt="Home" style="width: 25px; height: 25px;">
  </a>
  <div class="custom-dropdown">
    <button class="dropbtn">Nuevas ordenes de compras
      <i></i>
    </button>
    <div class="dropdown-content">
      <a href="nuevas_ordenes_compras.php">Ver ordenes de conpra</a>
     
    </div>
  </div> 
  <div class="custom-dropdown">
    <button class="dropbtn">Ordenes de compras 
      <i></i>
    </button>
    <div class="dropdown-content">
      <a href="ordenes_compras.php">Ver Ordenes de compra</a>
      
    </div>
  </div> 
  <div class="custom-dropdown">
    <button class="dropbtn">Proveedores
      <i></i>
    </button>
    <div class="dropdown-content">
      <a href="proveedores.php">Ver lista de proveedores</a>
      
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