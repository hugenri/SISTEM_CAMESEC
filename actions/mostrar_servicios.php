<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'empleado') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}


include_once '../clases/dataSanitizer.php';
require_once '../clases/Response_json.php';
include_once '../clases/DataBase.php';
include_once '../clases/DataValidator.php';


$respuesta_json = new ResponseJson();

$response = array();


     $sql = "SELECT * 
     FROM servicios;";
    
$parametros = array(
    //no hay parametros, se manda vacio
);
  // Ejecutar la consulta
  $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    if (!empty($datos)) {
        $response = array('success' => true, 'servicios' => $datos); // Encerrar la cotización en un array
        $respuesta_json->response_json($response);
    } else {
        $response = array('success' => false, 'message' => 'No hay servicios');
        $respuesta_json->response_json($response);
    }
      

 