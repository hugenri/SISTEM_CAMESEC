<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}


include_once '../model/SolicitudCotizacionModel.php';
require_once '../clases/Response_json.php';

$consulta = new SolicitudCotizacionModel();
$respuesta_json = new ResponseJson();

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
$sql = "SELECT * 
FROM solicitudes_cotizacion;";
    $datos = $consulta->getSolicitudesCotizacion($sql);
    if(!empty($datos)){
        $response = array('success' => true, 'dataSolicitud'  => $datos);

        $respuesta_json->response_json($response);

    }else{
        $respuesta_json->handle_response_json(false, 'No hay registros');

    }
} else {
    $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}   
