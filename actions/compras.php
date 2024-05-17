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
 if($action == "mostarNuevasOrdenes"){

    $sql = "SELECT *
    FROM orden_compras WHERE estado = 'en proceso';";
    
           
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


    $idOrdenCompra =  DataSanitizer::sanitize_input($_POST['idOrdenCompra']);


    //si se envia formulario sin datos se marca un error
    if(empty($idOrdenCompra)){
  
      $respuesta_json->handle_response_json(false, 'Faltan datos para precesar solicitud');
    }
    
   $messageLength = "ingrese solo numeros";
    $response = DataValidator:: validateNumber($idOrdenCompra, $messageLength);
    if ($response !== true) {
        $respuesta_json->response_json($response);
   }
          
  $sql = "SELECT pc.id, p.nombre AS nombre_producto, p.descripcion AS descripcion_producto, p.precio AS precio_unitario, pc.cantidad AS cantidad_comprar,
  pr.razonSocial AS nombre_proveedor, pr.email AS email_proveedor, pr.telefono AS telefono_proveedor,
  c.razonSocial AS nombre_cliente, c.email AS email_cliente, c.telefono AS telefono_cliente,
  sc.servicio AS servicio_ofrecido, co.idCotizacion, oc.estado
  FROM orden_compras oc
  INNER JOIN cotizaciones co ON oc.idCotizacion = co.idCotizacion
  INNER JOIN productos_cotizacion pc ON co.idCotizacion = pc.idCotizacion
  INNER JOIN producto p ON pc.id_producto = p.id
  INNER JOIN proveedor pr ON p.idProveedor = pr.idProveedor
  INNER JOIN solicitudes_cotizacion sc ON co.idSolicitudCotizacion = sc.id
  INNER JOIN cliente c ON sc.id_cliente = c.idCliente
  WHERE oc.idOrdenCompra = :idOrdenCompra
  ;";
  
         
  $parametros = array(
      'idOrdenCompra'=>$idOrdenCompra
  );
  
  // Ejecutar la consulta
  $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
  
  if(!empty($datos)){
      $response = array('success' => true, 'datosOrdenCompra'  => $datos);
      $respuesta_json->response_json($response);
  } else {
      $respuesta_json->handle_response_json(false, 'No hay registro!');
  }
  }elseif($action == "mostarOrdenesCompras"){

    $sql = "SELECT *
    FROM orden_compras;";
    
           
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
  }elseif($action == "setEstado"){
  $idOrdenCompra = DataSanitizer::sanitize_input($_POST['idOrdenCompra']);
  $estado = DataSanitizer::sanitize_input($_POST['estado']);
  $idCotizacion = DataSanitizer::sanitize_input($_POST['idCotizacion']);

  
  
    //si se envia formulario sin datos se marca un error
    if(empty($idOrdenCompra) && empty($estado) && empty($idCotizacion)){
  
      $respuesta_json->handle_response_json(false, 'Faltan datos para procesar solicitud');
    }
  
  
   $messageLength = "ingrese solo numeros";
    $response = DataValidator:: validateNumber($idOrdenCompra, $messageLength);
    if ($response !== true) {
        $respuesta_json->response_json($response);
   }
   $messageLength = "El dato debe tener más de 4 caracteres y menos de 10";
  $response = DataValidator::validateLength($estado, 3, 25, $messageLength);
  if ($response !== true) {
      $respuesta_json->response_json($response);
  }
  $messageLetters = "Ingrese solo letras en el dato";
  $response = DataValidator::validateLettersOnly($estado, $messageLetters);
  if ($response !== true) {
   $validacion = false;
   $respuesta_json->response_json($response);
  
  }
    
  $sql = "UPDATE orden_compras
  SET estado = :estado
  WHERE idOrdenCompra = :id;";
  
         
  $parametros = array(
      'id'=>$idOrdenCompra,
      'estado'=> $estado
  );
  
  // Ejecutar la consulta
  $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
  
  if($consulta){
    if($estado == "finalizada"){
      date_default_timezone_set('America/Mexico_City');
      $fecha = date('Y-m-d');
   //crear factura 

   $sql = "SELECT * FROM facturas WHERE idCotizacion = :idCotizacion;";
 
        
 $parametros = array(
     'idCotizacion'=> $idCotizacion
 );
 
 // Ejecutar la consulta
 $consulta_existe = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
 
 if(!empty($consulta_existe)){
  $respuesta_json->handle_response_json(false, 'Yatiene un registro!');

 }

   /////////////////////
    $sql = "INSERT INTO facturas (idCotizacion, fecha)
    VALUES (:idCotizacion, :fecha);";
  
         
  $parametros = array(
      'idCotizacion'=> $idCotizacion,
      'fecha' => $fecha
  );
  
  // Ejecutar la consulta
  $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
  
  
    }
      $response = array('success' => true, 'message'=>'El estado de la orden de compra a canbiado a: '. $estado);
      $respuesta_json->response_json($response);
  } else {
      $respuesta_json->handle_response_json(false, 'No hay registro!');
  }
}elseif($action == "mostarProveedores"){

  $sql = "SELECT *
  FROM proveedor;";
  
         
  $parametros = array(
      
  );
  
  // Ejecutar la consulta
  $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
  
  if(!empty($datos)){
      $response = array('success' => true, 'datosProveedores'  => $datos);
      $respuesta_json->response_json($response);
  } else {
      $respuesta_json->handle_response_json(false, 'No hay registro!');
  }
}elseif($action == "getProveedor"){
  $idProveedor = DataSanitizer::sanitize_input($_POST['idProveedor']);

  $messageLength = "ingrese solo numeros";
    $response = DataValidator:: validateNumber($idProveedor, $messageLength);
    if ($response !== true) {
        $respuesta_json->response_json($response);
   }

  $sql = "SELECT *
  FROM proveedor WHERE idProveedor = :idProveedor;";
  
         
  $parametros = array(
      'idProveedor' => $idProveedor
  );
  
  // Ejecutar la consulta
  $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');
  
  if(!empty($datos)){
      $response = array('success' => true, 'datosProveedores'  => $datos);
      $respuesta_json->response_json($response);
  } else {
      $respuesta_json->handle_response_json(false, 'No hay registro!');
  }
}elseif($action == "getNumeroRegistros"){
 
  $parametros = array(
  
);

  $sql = "SELECT COUNT(*) as numRegistros
  FROM Proveedor;";
    // Ejecutar la consulta
    $numero_proveedores = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');
      
    $sql = "SELECT COUNT(*) as numRegistros
    FROM orden_compras";
      // Ejecutar la consulta
      $numeroOrdenCompras = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');     
      
      $sql = "SELECT COUNT(*) as numRegistros
      FROM orden_compras WHERE estado = 'en proceso'";
        // Ejecutar la consulta
        $numeroNeuvasOrdenCompras = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');     
      $response = [
          'numProveedores' => $numero_proveedores,
          'numOdenesOrdenesCompras' => $numeroOrdenCompras,
          'numNuevasOrdenes' => $numeroNeuvasOrdenCompras

          
      ];
  
      $response = array('success' => true, 'response' => $response); // Encerrar la cotización en un array
      $respuesta_json->response_json($response);
}
       //####################
} else {
  $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
