<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/SolicitudCotizacionModel.php';
require_once '../clases/Response_json.php';

$consulta = new SolicitudCotizacionModel();
$respuesta_json = new ResponseJson();

$validacion = true;
$response = array();

$sql = "SELECT sc.*, c.razonSocial, c.telefono,
        CONCAT(c.nombre, ' ', c.apellidoPaterno) AS nombreCliente
        FROM solicitudes_cotizacion sc 
        INNER JOIN cliente c ON sc.id_cliente = c.idCliente 
        WHERE sc.estado = 'en proceso';";

    // Si no se proporciona un ID, se asume que es una solicitud para obtener todas las cotizaciones
    $datos = $consulta->getSolicitudesCotizacion($sql);

           if(!empty($datos)){
            $response = array('success' => true, 'dataSolicitud'  => $datos);

            $respuesta_json->response_json($response);

        }else{
            $respuesta_json->handle_response_json(false, 'Error en la consulta');

        }
