<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}


include_once '../model/ClienteModel.php';
include_once '../model/UsuarioModel.php';
include_once '../model/ProveedorModel.php';
include_once '../model/ProductoModel.php';
include_once '../model/ServicioModel.php';
include_once '../model/RequisicionModel.php';
include_once '../model/CotizacionModel.php';
include_once '../model/CompraModel.php';


$clientes = new ClienteModel();
$usuarios = new UsuarioModel();
$proveedores = new ProveedorModel();
$productos = new ProductoModel();
$servicios = new ServicioModel();
$cotizaciones = new CotizacionModel();
$ordenesCompra = new CompraModel();


$response = array();

try {
    
 $numero_usuarios = $usuarios->getNumerUsers();
 $numero_proveedores = $proveedores->getNumerProviders();
 $numero_clientes = $clientes->getNumerClients();
 $numero_productos = $productos->getNumerProducts();
 $numero_servicios = $servicios->getNumerServices();
 $numero_cotizaciones = $cotizaciones->getNumerCotizaciones();
 $numero_ordenesCompra = $ordenesCompra->getNumerOrdenesCompra();



    $response = [
        'numUsuarios' => $numero_usuarios,
        'numClientes' => $numero_clientes,
        'numProveedores' => $numero_proveedores,
        'numProductos' => $numero_productos,
        'numServicios' => $numero_servicios,
        'numCotizaciones'  => $numero_cotizaciones,
        'numOrdenesCompra'  => $numero_ordenesCompra
    ];

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
