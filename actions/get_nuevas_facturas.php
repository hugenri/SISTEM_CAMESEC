<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
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

$action = $_POST['action'];

if(isset($action) && !empty($action)){

  if($action == "mostarNuevosFacturas"){
$parametros = array(

);

$sql = "SELECT DISTINCT
f.idFactura AS idFactura,
f.fecha AS fecha_factura,
c.idCotizacion AS idCotizacion,
cli.razonSocial AS razon_social_cliente,
CONCAT(cli.nombre, ' ', cli.apellidoPaterno, ' ', cli.apellidoMaterno) AS nombre_completo, 
cli.email AS email_cliente,
cli.telefono AS telefono_cliente, sc.servicio AS servicio_ofrecido
FROM 
facturas AS f
JOIN 
cotizaciones AS c ON f.idCotizacion = c.idCotizacion
JOIN 
solicitudes_cotizacion AS sc ON c.idSolicitudCotizacion = sc.id
JOIN 
cliente AS cli ON sc.id_cliente = cli.idCliente
WHERE 
f.estatus = 'pendiente' AND c.estatus = 'aceptada'
ORDER BY f.idFactura;";


    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);     
   if(!empty($datos)){

    $response = array('success' => true, 'datosFacturas' => $datos); // Encerrar la cotización en un array
    $respuesta_json->response_json($response);
   }else{
    $response = array('success' => false, 'message' => 'No tiene facturas por atender');
    $respuesta_json->response_json($response);
   }

}elseif($action == "mostar_datos_factura"){

  $idFactura = DataSanitizer::sanitize_input($_POST['idFactura']);


if($idFactura == ""){ //para verificar que los datos enviados por POST tenga un valor.
  $respuesta_json->handle_response_json(false, 'faltan datos!');

 } 

 $messageLetters = "Ingrese solo numeros en el dato";
 $response = DataValidator::validateNumber($idFactura, $messageLetters);
 if ($response !== true) {
     $respuesta_json->response_json($response);
 }

  $parametros = array(
      
      ':idFactura' => $idFactura
  );
  
$sql = "SELECT DISTINCT
f.idFactura AS idFactura,
f.fecha AS fecha_factura,
c.idCotizacion AS idCotizacion,
c.total, c.iva, c.costo_instalacion, c.subtotal, c.descuento
, cli.razonSocial AS razon_social_cliente,
CONCAT(cli.nombre, ' ', cli.apellidoPaterno, ' ', cli.apellidoMaterno) AS nombre_completo,
cli.calle AS calle_cliente,
cli.numero AS numero_cliente,
cli.colonia AS colonia_cliente,
cli.municipio AS municipio_cliente,
cli.estado AS estado_cliente,
cli.cp AS cp_cliente,
cli.email AS email_cliente,
cli.telefono AS telefono_cliente,
cli.rfc,
pc.id_producto AS id_producto_cotizacion,
p.nombre AS nombre_producto,
p.precio AS precio_producto,
pc.cantidad AS cantidad_producto, sc.servicio
FROM 
facturas AS f
JOIN 
cotizaciones AS c ON f.idCotizacion = c.idCotizacion
JOIN 
solicitudes_cotizacion AS sc ON c.idSolicitudCotizacion = sc.id
JOIN 
cliente AS cli ON sc.id_cliente = cli.idCliente
JOIN 
productos_cotizacion AS pc ON c.idCotizacion = pc.idCotizacion
JOIN 
producto AS p ON pc.id_producto = p.id
WHERE 
f.idFactura = :idFactura;";
  
  
      $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);     
     if(!empty($datos)){
  
      $response = array('success' => true, 'datosFactura' => $datos); // Encerrar la cotización en un array
      $respuesta_json->response_json($response);
     }else{
      $response = array('success' => false, 'message' => 'No tiene facturas por atender...');
      $respuesta_json->response_json($response);
     }
  
  }
//######################
} else {
    $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
