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

$idServicio = DataSanitizer::sanitize_input($_POST['idServicio']);
$estadoServicio = DataSanitizer::sanitize_input($_POST['estadoServicio']);
$data = [$idServicio, $estadoServicio];

//si se envia formulario sin datos se marca un error
if(DataValidator::validateVariables($data) === false){

  $response = array('success' => false, 'message' => 'Faltan datos');
  $respuesta_json->response_json($response);
}

$messageLength = "El dato debe tener solo letras letras";
$response = DataValidator::validateLettersOnly($estadoServicio, $messageLength);
if ($response !== true) {
    $respuesta_json->response_json($response);

}

$messageLetters = "Ingrese solo numeros en el dato";
$response = DataValidator::validateNumber($idServicio, $messageLetters);
if ($response !== true) {
    $respuesta_json->response_json($response);
}

$sql = "UPDATE servicios 
SET
estado = :estado
 WHERE idServicio = :idServicio;";

    
$parametros = array(
    ':idServicio' => $idServicio,
    ':estado' => $estadoServicio

);
  // Ejecutar la consulta
  $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
    if ($consulta) {
        $response = array('success' => true, 'message' => 'Se actualizo el estodo del servicio a: '. $estadoServicio); // Encerrar la cotización en un array
        $respuesta_json->response_json($response);
    } else {
        $response = array('success' => false, 'message' => 'No se actualizo el estado del servicio');
        $respuesta_json->response_json($response);
    }
      

 