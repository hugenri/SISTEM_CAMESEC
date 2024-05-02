<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
require_once '../clases/Response_json.php';
include_once '../clases/DataBase.php';

$respuesta_json = new ResponseJson();
$response = array();

$idServicio = DataSanitizer::sanitize_input($_POST['idServicio']);
$estado = DataSanitizer::sanitize_input($_POST['estadoSelect']);


$data = [$estado, $idServicio];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $respuesta_json->handle_response_json(false, 'Faltan datos en el formulario!');

    }

    
    $messageLetters = "Ingrese solo letras en el dato";
   $response = DataValidator::validateLettersOnly($estado, $messageLetters);
   if ($response !== true) {
    $respuesta_json->response_json($response);

  }


  $messageLetters = "Ingrese solo numeros en el dato";
 $response = DataValidator::validateNumber($idServicio, $messageLetters);
 if ($response !== true) {
    $respuesta_json->response_json($response);

}

$sql = "UPDATE servicios SET estado = :estado WHERE idServicio = :idServicio;";
       
$parametros = array(
    'idServicio' => $idServicio,
    'estado'=> $estado
);

// Ejecutar la consulta
$consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);

if($consulta){
    $respuesta_json->handle_response_json(true, 'El estado del servicio se actualizo!');

} else {
    $respuesta_json->handle_response_json(false, 'No se pudo actualizar el estado del servicio!');
}
