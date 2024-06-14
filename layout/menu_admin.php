<nav>

<div class="custom-topnav" id="myTopnav">
  <a href="admin.php" class="active icon-a" style="display: flex; align-items: center;">
    <img src="assets/images/home.png" alt="Home" style="width: 23px; height: 23px;">
  </a>
  <div class="custom-dropdown">
    <button class="dropbtn  fonnt-bolt">Usuarios
    </button>
    <div class="dropdown-content">
      <a href="crearAdmin.php">Crear Usuario Administrador</a>
      <a href="crearEmpleado.php">Crear Usuario Empleado</a>
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
      <a href="restablecerPasswordCliente.php">Cambiar password</a>
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
    <button class="dropbtn  fonnt-bolt">Orden de compras 
    </button>

    <div class="dropdown-content">
      <a href="crear_orden_compra.php">Crear orden de compra</a>
      <a href="ver_ordenes_compras.php">Ver lista de ordenes de compras</a>
      <a href="detalles_orden_compras.php">Ver detalles de las ordenes de compra</a>

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
      <a href="activar_servicio.php">Activar Servicio</a>
      <a href="verservicios.php">Ver lista de servicios</a>
      <a href="detalles_servicios.php">Ver detalles de los servicios</a>
    </div>
  </div> 

  
  <div class="custom-dropdown">
  <button class="dropbtn  fonnt-bolt">Conceptos de facturación 
    </button>

    <div class="dropdown-content">
      <a href="ver_facturas.php">Lista de facturas</a>
      <a href="nuevas_facturas.php">Nuevas Facturas</a>
    </div>

  </div> 

  <div class="custom-dropdown">

    <button class="dropbtn  fonnt-bolt">Cotizaciones 
    </button>
    <div class="dropdown-content">
    <a href="ver_solicitudes_cotizaciones.php">Solicitudes de cotizacion</a>
      <a href="vercotizaciones.php">Ver lista cotizaciones</a>
      <a href="detalles_cotizaciones.php">Ver detalles de las cotizaciones</a>
    </div>
  </div> 
  <div class="custom-dropdown">

    <button class="dropbtn  fonnt-bolt"> Ventas de productos
    </button>
    <div class="dropdown-content">
    <a href="ver_ventas.php">Ver ventas</a>
      <a href="activarEntregaProductos.php">Activar entrega de productos</a>
    </div>
  </div> 
  
  
  <div class="custom-dropdown user-menu">
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