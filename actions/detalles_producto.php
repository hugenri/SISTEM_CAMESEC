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

$id = DataSanitizer::sanitize_input($_POST['id']);

$datos = [$id];
$messageLetters = "Ingrese solo numeros en el dato";
$response = DataValidator::validateNumbersOnlyArray($datos, $messageLetters);
if ($response !== true) {
$validacion = false;
$respuesta_json->response_json($response);

}

$respuesta_json = new ResponseJson();

    $sql = "SELECT * FROM   producto WHERE id = :id;";

$parametros = array(
    ':id' => $id,
    
);
// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');

if(!empty($datos)){
    $response = array("success" => true, 'datosProducto'=> $datos);
    $respuesta_json->response_json($response);

} else {
    $respuesta_json->handle_response_json(false, 'No hay datos!');
}