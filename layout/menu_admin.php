<nav>

<div class="custom-topnav" id="myTopnav">
  <a href="admin.php" class="active icon-a" style="display: flex; align-items: center;">
    <img src="assets/images/home.png" alt="Home" style="width: 16px; height: 16px;">
  </a>
  <div class="custom-dropdown">
    <button class="dropbtn  fonnt-bolt">Usuarios
    </button>
    <div class="dropdown-content">
      <a href="crearAdmin.php">Crear Usuario Administrador</a>
      <a href="restablecerpassword.php">Restablecer contraseña de usuario</a>
      <a href="listausuarios.php">Ver lista de usuarios</a>
    </div>
  </div> 
  <div class="custom-dropdown">
    <button class="dropbtn  fonnt-bolt">Clientes 
    </button>
    <div class="dropdown-content">
      <a href="agregarcliente.php">Agregar cliente</a>
      <a href="verclientes.php">Ver lista de clientes</a>
    </div>
  </div> 

  <div class="custom-dropdown">
    <button class="dropbtn  fonnt-bolt">Proveedores 
    </button>
    <div class="dropdown-content">
    <a href="agregarproveedor.php">Agregar proveedor</a>
      <a href="verproveedores.php">Ver lista de proveedores</a>
      <a href="categoriaproveedor.php">Asignación de categoría</a>
    </div>
  </div> 
  <div class="custom-dropdown">
    <button class="dropbtn  fonnt-bolt">Requisiciones 
    </button>
    <div class="dropdown-content">
      <a href="crear_requisicion.php">Crear requisición</a>
      <a href="ver_requisiciones.php">Ver lista de requisiciones</a>
      <a href="detalles_requisiciones.php">Ver detalles de las requisiciones</a>
    </div>
  </div> 

  

  <div class="custom-dropdown">
    <button class="dropbtn  fonnt-bolt">Ordenes de compra 
    </button>

    <div class="dropdown-content">
      <a href="crear_compra.php">Crear orden de compra</a>
      <a href="vercompras.php">Ver lista de ordenes de compra</a>
      <a href="detalles_compras.php">Ver detalles de las ordenes de compra</a>

    </div>

  </div> 

  <div class="custom-dropdown">

    <button class="dropbtn  fonnt-bolt">Productos 
    </button>

    <div class="dropdown-content">
      <a href="agregarproducto.php">Agregar producto</a>
      <a href="verproductos.php">Ver lista Productos</a>
      <a href="detallesproducto.php">Ver detalles de los productos</a>

    </div>

  </div> 

  <div class="custom-dropdown">
    <button class="dropbtn  fonnt-bolt">Servicios 
    </button>
    <div class="dropdown-content">
      <a href="agregarservicio.php">Agregar Servicio</a>
      <a href="verservicios.php">Ver lista de servicios</a>
      <a href="detalles_servicios.php">Ver detalles de los servicios</a>
    </div>
  </div> 

  <div class="custom-dropdown">
    <button class="dropbtn  fonnt-bolt">Ajustes 
    </button>

    <div class="dropdown-content">

      <a href="#">Link 1</a>

      <a href="#">Link 2</a>

      <a href="#">Link 3</a>

    </div>

  </div> 

  <div class="custom-dropdown">

    <button class="dropbtn  fonnt-bolt">Conceptos de facturación 

    

    </button>

    <div class="dropdown-content">

      <a href="#">Link 1</a>

      <a href="#">Link 2</a>

      <a href="#">Link 3</a>

    </div>

  </div> 

  <div class="custom-dropdown">

    <button class="dropbtn  fonnt-bolt">Cotizaciones 
    </button>
    <div class="dropdown-content">
    <a href="ver_solicitudes_cotizaciones.php">Solicitud de cotizaciones</a>
    <a href="agregarcotizacion.php">Agregar cotización</a>
      <a href="vercotizaciones.php">Ver lista cotizaciones</a>
      <a href="detalles_cotizaciones.php">Ver detalles de las cotizaciones</a>

    </div>

  </div> 

  <div class="custom-dropdown">

    <button class="dropbtn  fonnt-bolt">Reportes

      

    </button>

    <div class="dropdown-content">

      <a href="#">Link 1</a>

      <a href="#">Link 2</a>

      <a href="#">Link 3</a>

    </div>

  </div> 

  <div class="custom-dropdown">
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