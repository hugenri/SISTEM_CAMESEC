<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

require_once '../clases/Response_json.php';
include_once '../clases/DataBase.php';

$respuesta_json = new ResponseJson();
$response = array();

        
$sql = "SELECT id, CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombre_completo FROM usuarios WHERE rol_usuario = 'empleado'
;";

       
$parametros = array(
    
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

if(!empty($datos)){
    $response = array('success' => true, 'datos'  => $datos);
    $respuesta_json->response_json($response);
} else {
    $respuesta_json->handle_response_json(false, 'No hay registro!');
}
