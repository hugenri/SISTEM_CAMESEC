<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'compras'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';
require_once '../clases/Response_json.php';

$respuesta_json = new ResponseJson();
$response = null;

$action =  $_POST['action'];

if(isset($action) && !empty($action)){
 if($action == "mostar_productos"){

    $sql = "SELECT DISTINCT
    v.id_venta, 
    v.fecha_venta,
    c.razonSocial AS cliente_razon_social,
    pv.pago
FROM 
    ventas v
JOIN 
    ventas_productos vp ON v.id_venta = vp.id_venta
JOIN 
    entregas e ON v.id_venta = e.id_venta
JOIN 
    pagos_venta pv ON v.id_venta = pv.id_venta
JOIN 
    cliente c ON v.id_cliente = c.idCliente
WHERE 
    pv.pago <> 'no' 
    AND e.estado = 'pendiente';";

           
    $parametros = array(
        
    );
    
    // Ejecutar la consulta
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    
    if(!empty($datos)){
        $response = array('success' => true, 'datosOrdenesCompras'  => $datos);
        $respuesta_json->response_json($response);
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registro!');
    }
   
  }elseif($action == "getOrdenCompra"){


    $idVenta =  DataSanitizer::sanitize_input($_POST['idVenta']);


    //si se envia formulario sin datos se marca un error
    if(empty($idVenta)){
  
      $respuesta_json->handle_response_json(false, 'Faltan datos para precesar solicitud');
    }
    
   $messageLength = "ingrese solo numeros";
    $response = DataValidator:: validateNumber($idVenta, $messageLength);
    if ($response !== true) {
        $respuesta_json->response_json($response);
   }
 
  
  $sql = "SELECT  v.id_venta, prod.nombre AS nombre_producto, prod.descripcion AS descripcion_producto, prod.precio AS precio_unitario, vp.cantidad AS cantidad_comprar,
  pr.razonSocial AS nombre_proveedor, pr.email AS email_proveedor, pr.telefono AS telefono_proveedor,
  c.razonSocial AS nombre_cliente, c.email AS email_cliente, c.telefono AS telefono_cliente, 
  e.id_entrega, e.estado
FROM 
  ventas v
JOIN 
  ventas_productos vp ON v.id_venta = vp.id_venta
JOIN 
  entregas e ON v.id_venta = e.id_venta
JOIN 
  pagos_venta pv ON v.id_venta = pv.id_venta
JOIN 
  producto prod ON vp.id_producto = prod.id

JOIN 
  proveedor pr ON prod.idProveedor = pr.idProveedor
JOIN 
  cliente c ON v.id_cliente = c.idCliente
WHERE v.id_venta = :idVenta;";  

  $parametros = array(
      'idVenta'=>$idVenta
  );
  
  // Ejecutar la consulta
  $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
  
  if(!empty($datos)){
      $response = array('success' => true, 'datosOrdenCompra'  => $datos);
      $respuesta_json->response_json($response);
  } else {
      $respuesta_json->handle_response_json(false, 'No hay registro!');
  }
  }elseif($action == "setEstado"){
  $idVenta = DataSanitizer::sanitize_input($_POST['idVenta']);
  $estado = "en proceso";

  
  
    //si se envia formulario sin datos se marca un error
    if(empty($idVenta) && empty($estado)){
  
      $respuesta_json->handle_response_json(false, 'Faltan datos para procesar solicitud');
    }
  
  
   $message = "ingrese solo numeros";
    $response = DataValidator:: validateNumber($idVenta, $message);
    if ($response !== true) {
        $respuesta_json->response_json($response);
   }
   
    
  $sql = "UPDATE entregas
  SET estado = :estado
  WHERE id_venta = :idVenta;";
  
         
  $parametros = array(
      'idVenta'=>$idVenta,
      'estado'=> $estado
  );
  
  // Ejecutar la consulta
  $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, false);
  
  if($consulta){
   
      $response = array('success' => true, 'message'=>'Se realizó correcta mente en registro!');
      $respuesta_json->response_json($response);
  } else {
      $respuesta_json->handle_response_json(false, 'No hay registro!');
  }
  }elseif($action == "mostarCompras"){

    $sql = "SELECT DISTINCT
    v.id_venta, v.fecha_venta,
     c.razonSocial AS cliente_razon_social
    , pv.pago
FROM 
    ventas v
JOIN 
    ventas_productos vp ON v.id_venta = vp.id_venta
JOIN 
    entregas e ON v.id_venta = e.id_venta
JOIN 
    pagos_venta pv ON v.id_venta = pv.id_venta
JOIN 
    producto prod ON vp.id_producto = prod.id
JOIN 
    proveedor p ON prod.idProveedor = p.idProveedor
JOIN 
    cliente c ON v.id_cliente = c.idCliente;";

           
    $parametros = array(
        
    );
    
    // Ejecutar la consulta
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    
    if(!empty($datos)){
        $response = array('success' => true, 'datosOrdenesCompras'  => $datos);
        $respuesta_json->response_json($response);
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registro!');
    }
  }
       //####################
} else {
  $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
