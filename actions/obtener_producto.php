<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/ProductoModel.php';
include_once '../clases/Response_json.php';
include_once '../clases/DataSanitizer.php';
include_once '../clases/DataValidator.php';

$cosulta_Producto = new ProductoModel();
$respuesta_json = new ResponseJson();

$id = DataSanitizer::sanitize_input($_POST['id']);
if($id == ""){ //para verificar que los datos enviados por POST tenga un valor.

	$response = array('success' => false, 'message' => 'Faltan datos');
    $respuesta_json->response_json($response);
}
    $validacion_datos = [$id];
    $messageLetters = "Ingrese solo numeros en el dato";
    $response = DataValidator::validateNumbersOnlyArray($validacion_datos, $messageLetters);
    if ($response !== true) {
        $respuesta_json->response_json($response);
    }

    $datos = $cosulta_Producto->getProducto($id);
    if(!empty($datos)){
        $response = array('success' => true, 'producto'  => $datos);
        $respuesta_json->response_json($response);
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registros');
    }
