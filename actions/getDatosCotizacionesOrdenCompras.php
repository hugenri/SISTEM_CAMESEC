<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

require_once '../clases/Response_json.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';

$respuesta_json = new ResponseJson();
$response = array();

        
 
$sql = "SELECT cot.*, c.razonSocial AS razonSocialCliente, sc.servicio
FROM cotizaciones cot
INNER JOIN solicitudes_cotizacion sc ON cot.idSolicitudCotizacion = sc.id
INNER JOIN cliente c ON sc.id_cliente = c.idCliente
WHERE cot.estatus = 'aceptada'
AND cot.idCotizacion NOT IN (SELECT idCotizacion FROM orden_compras);
";


 $parametros = array(
  

 );

 $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros,true);
 
  if(empty($datos)){
      $respuesta_json->handle_response_json(false, 'No hay registro!');

  }else{
         $response = array("success" => true, 'dataCotizaciones' => $datos);

      $respuesta_json->response_json($response);

  }
