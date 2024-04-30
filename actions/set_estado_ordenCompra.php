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

$idOrdenCompra = DataSanitizer::sanitize_input($_POST['idOrdenCompra']);
$estado = DataSanitizer::sanitize_input($_POST['estado']);



  //si se envia formulario sin datos se marca un error
  if(empty($idOrdenCompra)){

    $respuesta_json->handle_response_json(false, 'Faltan datos para procesar solicitud');
  }
  
 $messageLength = "ingrese solo numeros";
  $response = DataValidator:: validateNumber($idOrdenCompra, $messageLength);
  if ($response !== true) {
      $respuesta_json->response_json($response);
 }
 $messageLength = "El dato debe tener más de 4 caracteres y menos de 10";
$response = DataValidator::validateLength($estado, 3, 25, $messageLength);
if ($response !== true) {
    $respuesta_json->response_json($response);
}
$messageLetters = "Ingrese solo letras en el dato";
$response = DataValidator::validateLettersOnly($estado, $messageLetters);
if ($response !== true) {
 $validacion = false;
 $respuesta_json->response_json($response);

}
  
$sql = "UPDATE orden_compras
SET estado = :estado
WHERE idOrdenCompra = :id;";

       
$parametros = array(
    'id'=>$idOrdenCompra,
    'estado'=> $estado
);

// Ejecutar la consulta
$consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);

if($consulta){
    $response = array('success' => true, 'message'=>'El estado de la orden de compra a canbiado a: '. $estado);
    $respuesta_json->response_json($response);
} else {
    $respuesta_json->handle_response_json(false, 'No hay registro!');
}
