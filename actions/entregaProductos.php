<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'empleado') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

 // Función para manejar errores fatales y convertirlos en una respuesta JSON
 function handleFatalError() {
    $error = error_get_last();
    if ($error !== null) {
        // Limpiar el búfer de salida
        if (ob_get_contents()) ob_clean();
        
        http_response_code(500);
        header('Content-Type: application/json');
        $errorData = [
            'error' => 'Error fatal',
            'message' =>  $error['message']
        ];
        exit(json_encode($errorData));
    }
}

// Registra la función para manejar errores fatales
register_shutdown_function('handleFatalError');

 
 

require_once '../clases/Response_json.php';
include_once '../clases/DataBase.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';


$respuesta_json = new ResponseJson();
$idEmpleado = $session->getSessionVariable('id_usuario');

$response = array();

$action =  $_POST['action'];

if(isset($action) && !empty($action)){
  if($action == "mostarEntregas"){
$parametros = array(
    ':idEmpleado' => $idEmpleado
);

$sql = "SELECT DISTINCT
    c.razonSocial AS nombre_empresa,
    CONCAT(c.nombre, ' ', c.apellidoPaterno, ' ', c.apellidoMaterno) AS nombre_completo,
    c.email AS email_cliente,
    c.telefono AS telefono_cliente,
    c.estado,
    c.municipio, e.id_entrega, e.fecha_entrega
FROM
    cliente c
JOIN
    ventas v ON c.idCliente = v.id_cliente
JOIN
    entregas e ON v.id_venta = e.id_venta
JOIN
    usuarios emp ON  e.responsable = emp.id
WHERE
    e.estado = 'enviado' AND e.responsable = :idEmpleado;
";


    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);     
   if(!empty($datos)){

    $response = array('success' => true, 'datos' => $datos); // Encerrar la cotización en un array
    $respuesta_json->response_json($response);
   }else{
    $response = array('success' => false, 'message' => 'No tiene entregas de productos por atender');
    $respuesta_json->response_json($response);
   }

}elseif($action == "mostar_datos_entrega"){

  $id_entrega =  DataSanitizer::sanitize_input($_POST['id_entrega']);


if($id_entrega == ""){ //para verificar que los datos enviados por POST tenga un valor.
  $respuesta_json->handle_response_json(false, 'faltan datos!');

 } 

 $messageLetters = "Ingrese solo numeros en el dato";
 $response = DataValidator::validateNumber($id_entrega, $messageLetters);
 if ($response !== true) {
     $respuesta_json->response_json($response);
 }

  $parametros = array(
      ':responsable' => $idEmpleado,
      ':id_entrega' => $id_entrega
  );
  
$sql = "SELECT DISTINCT 
    p.nombre AS nombre_producto,
    vp.cantidad AS cantidad_producto,
    CONCAT(c.nombre, ' ', c.apellidoPaterno, ' ', c.apellidoMaterno) AS nombre_completo,
    c.razonSocial AS nombre_empresa,
    c.email AS email_cliente,
    c.telefono AS telefono_cliente, c.calle, 
    c.numero,  c.colonia, c.cp, c.estado, 
    c.municipio, e.detalle, e.id_entrega
FROM 
    cliente c
JOIN 
    ventas v ON c.idCliente = v.id_cliente
JOIN 
    ventas_productos vp ON v.id_venta = vp.id_venta
JOIN 
    producto p ON vp.id_producto = p.id
JOIN 
    entregas e ON v.id_venta = e.id_venta
WHERE 
    e.estado = 'enviado' AND e.responsable = :responsable AND e.id_entrega = :id_entrega;";
  
  
      $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);     
     if(!empty($datos)){
  
      $response = array('success' => true, 'datosServicio' => $datos); // Encerrar la cotización en un array
      $respuesta_json->response_json($response);
     }else{
      $response = array('success' => false, 'message' => 'No tiene entregas de productos por atender...');
      $respuesta_json->response_json($response);
     }
  
  }elseif($action == "cambiar_estado"){
    
$id_entrega = DataSanitizer::sanitize_input($_POST['id_entrega']);
$estado = DataSanitizer::sanitize_input($_POST['estado']);
$data = [$id_entrega, $estado];

//si se envia formulario sin datos se marca un error
if(DataValidator::validateVariables($data) === false){

  $response = array('success' => false, 'message' => 'Faltan datos');
  $respuesta_json->response_json($response);
}

$messageLength = "El dato debe tener solo letras letras";
$response = DataValidator::validateLettersOnly($estado, $messageLength);
if ($response !== true) {
    $respuesta_json->response_json($response);

}

$messageLetters = "Ingrese solo numeros en el dato";
$response = DataValidator::validateNumber($id_entrega, $messageLetters);
if ($response !== true) {
    $respuesta_json->response_json($response);
}

$sql = "UPDATE entregas 
SET
estado = :estado
 WHERE id_entrega = :id_entrega;";

    
$parametros = array(
    ':id_entrega' => $id_entrega,
    ':estado' => $estado

);
  // Ejecutar la consulta
  $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
    if ($consulta) {
        $response = array('success' => true, 'message' => 'Se actualizo el estodo de la entrega a: '. $estado); // Encerrar la cotización en un array
        $respuesta_json->response_json($response);
    } else {
        $response = array('success' => false, 'message' => 'No se actualizo el estado de la entrega');
        $respuesta_json->response_json($response);
    }
      

  }elseif($action == "mostar_datos"){

  
  
    $parametros = array(
        ':responsable' => $idEmpleado
    );
    
  $sql = "SELECT DISTINCT 
     c.razonSocial AS nombre_empresa,
    CONCAT(c.nombre, ' ', c.apellidoPaterno, ' ', c.apellidoMaterno) AS nombre_completo,
     e.id_entrega, e.fecha_entrega, e.estado
  FROM 
      cliente c
  JOIN 
      ventas v ON c.idCliente = v.id_cliente
  JOIN 
      ventas_productos vp ON v.id_venta = vp.id_venta
  JOIN 
      producto p ON vp.id_producto = p.id
  JOIN 
      entregas e ON v.id_venta = e.id_venta
  WHERE 
     e.responsable = :responsable ;";
    
    
        $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);     
       if(!empty($datos)){
    
        $response = array('success' => true, 'datos' => $datos); // Encerrar la cotización en un array
        $respuesta_json->response_json($response);
       }else{
        $response = array('success' => false, 'message' => 'No tiene servicios por atender...');
        $respuesta_json->response_json($response);
       }
  }elseif($action == "verEntrega"){

    $id_entrega = DataSanitizer::sanitize_input($_POST['id_entrega']);
  
  
  if($id_entrega == ""){ //para verificar que los datos enviados por POST tenga un valor.
    $respuesta_json->handle_response_json(false, 'faltan datos!');
  
   } 
  
   $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumber($id_entrega, $messageLetters);
   if ($response !== true) {
       $respuesta_json->response_json($response);
   }
  
    $parametros = array(
        ':responsable' => $idEmpleado,
        ':id_entrega' => $id_entrega
    );
    
  $sql = "SELECT DISTINCT 
      p.nombre AS nombre_producto,
      vp.cantidad AS cantidad_producto,
      CONCAT(c.nombre, ' ', c.apellidoPaterno, ' ', c.apellidoMaterno) AS nombre_completo,
      c.razonSocial AS nombre_empresa,
      c.email AS email_cliente,
      c.telefono AS telefono_cliente, c.calle, 
      c.numero,  c.colonia, c.cp, c.estado, 
      c.municipio, e.detalle, e.id_entrega
  FROM 
      cliente c
  JOIN 
      ventas v ON c.idCliente = v.id_cliente
  JOIN 
      ventas_productos vp ON v.id_venta = vp.id_venta
  JOIN 
      producto p ON vp.id_producto = p.id
  JOIN 
      entregas e ON v.id_venta = e.id_venta
  WHERE 
       e.responsable = :responsable AND e.id_entrega = :id_entrega;";
    
    
        $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);     
       if(!empty($datos)){
    
        $response = array('success' => true, 'datos' => $datos); // Encerrar la cotización en un array
        $respuesta_json->response_json($response);
       }else{
        $response = array('success' => false, 'message' => 'No tiene servicios por atender...');
        $respuesta_json->response_json($response);
       }
    }
//######################
} else {
    $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
