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


include_once '../clases/dataSanitizer.php';
require_once '../clases/Response_json.php';
include_once '../clases/DataBase.php';
include_once '../clases/DataValidator.php';


$respuesta_json = new ResponseJson();

$response = array();
$idEmpleado = $session->getSessionVariable('id_usuario');
$action = $_POST['action'];

if(isset($action) && !empty($action)){
if($action == "mostar_servicios"){
$sql = "SELECT
c.razonSocial, 
sc.servicio AS servicio_ofrecido, s.idServicio, s.detalles,
s.fecha, s.idEmpleado, s.estado
FROM servicios s
JOIN orden_compras oc ON s.idOrdenCompra = oc.idOrdenCompra
INNER JOIN cotizaciones co ON oc.idCotizacion = co.idCotizacion
INNER JOIN productos_cotizacion pc ON co.idCotizacion = pc.idCotizacion
INNER JOIN producto p ON pc.id_producto = p.id
INNER JOIN solicitudes_cotizacion sc ON co.idSolicitudCotizacion = sc.id
INNER JOIN cliente c ON sc.id_cliente = c.idCliente
WHERE s.estado = 'en curso' AND s.idEmpleado = :idEmpleado;";
    
$parametros = array(
    ':idEmpleado' => $idEmpleado
);
  // Ejecutar la consulta
  $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    if (!empty($datos)) {
        $response = array('success' => true, 'servicios' => $datos); // Encerrar la cotización en un array
        $respuesta_json->response_json($response);
    } else {
        $response = array('success' => false, 'message' => 'No hay servicios');
        $respuesta_json->response_json($response);
    }
      
  }elseif($action == "mostar_datos_servicio"){

    $idServicio =  DataSanitizer::sanitize_input($_POST['idServicio']);
  
  
  if($idServicio == ""){ //para verificar que los datos enviados por POST tenga un valor.
    $respuesta_json->handle_response_json(false, 'faltan datos!');
  
   } 
  
   $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumber($idServicio, $messageLetters);
   if ($response !== true) {
       $respuesta_json->response_json($response);
   }
  
    $parametros = array(
        ':idEmpleado' => $idEmpleado,
        ':idServicio' => $idServicio
    );
    
  $sql = "SELECT p.nombre AS nombre_producto,
  pc.cantidad AS cantidad_producto, CONCAT(c.nombre, ' ',
  c.apellidoPaterno, ' ', c.apellidoMaterno) AS nombre_completo,
   c.razonSocial AS nombre_empresa, c.email AS email_cliente,
   c.telefono AS telefono_cliente,
   c.calle, c.numero, c.colonia, c.cp, c.estado, c.municipio,
   sc.servicio AS servicio_ofrecido , s.idServicio, s.detalles,
   s.fecha, s.idEmpleado
   FROM servicios s
   JOIN orden_compras oc ON s.idOrdenCompra = oc.idOrdenCompra
   INNER JOIN cotizaciones co ON oc.idCotizacion = co.idCotizacion
   INNER JOIN productos_cotizacion pc ON co.idCotizacion = pc.idCotizacion
   INNER JOIN producto p ON pc.id_producto = p.id
   INNER JOIN solicitudes_cotizacion sc ON co.idSolicitudCotizacion = sc.id
   INNER JOIN cliente c ON sc.id_cliente = c.idCliente
   WHERE  s.idEmpleado = :idEmpleado AND idServicio = :idServicio;";
    
    
        $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);     
       if(!empty($datos)){
    
        $response = array('success' => true, 'datosServicio' => $datos); // Encerrar la cotización en un array
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
