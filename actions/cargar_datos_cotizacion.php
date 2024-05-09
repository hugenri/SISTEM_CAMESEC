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

        
$sql = "SELECT cot.*, c.razonSocial, sc.servicio
FROM cotizaciones cot
JOIN solicitudes_cotizacion sc ON cot.idSolicitudCotizacion = sc.id
JOIN cliente c ON sc.id_cliente = c.idCliente
WHERE cot.estatus = 'aceptada';
";

       
$parametros = array(
    
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

if(!empty($datos)){
    $response = array('success' => true, 'dataCotizacion'  => $datos);
    $respuesta_json->response_json($response);
} else {
    $respuesta_json->handle_response_json(false, 'No hay registro!');
}
