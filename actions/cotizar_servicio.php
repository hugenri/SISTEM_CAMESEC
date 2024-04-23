<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'cliente') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}



include_once '../model/SolicitudCotizacionModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
require_once '../clases/Response_json.php';


$consulta = new SolicitudCotizacionModel();
$respuesta_json = new ResponseJson();

$validacion = true;
$response = array();

$servicio = DataSanitizer::sanitize_input($_POST['servicio']);    
$fecha = DataSanitizer::sanitize_input($_POST['fecha']);
$idCliente = $session->getSessionVariable('id_cliente');
$estado = 'en proceso';


$data = [$servicio, $fecha, $idCliente];

    //si se envia formulario sin datos se marca un error
if(DataValidator::validateVariables($data) === false){
      $respuesta_json->handle_response_json(false, 'Faltan datos');

}else{

    $result = $consulta->getSolicitud_cotizacion_Servicio($servicio, $idCliente);
    if($result){
        $validacion = false;
        $respuesta_json->handle_response_json(false, 'Ya tiene una solicitud de cotización en proceso del servicio.');

    }
     if($validacion == true){//Si devuelve true, significa que el reCAPTCHA es válido y se puede continuar con el procesamiento del formulario
        $result = $consulta->createSolicitudCotizacion($servicio, $idCliente, $fecha, $estado);

           if($result == true){
            $respuesta_json->handle_response_json(true, 'La solicitud de cotización se ha registrado.');

        }else{
            $respuesta_json->handle_response_json(false, 'La solicitud de cotización no se pudo registrar.');

        }
 }

}

// Return response as JSON
echo json_encode($response);
 

