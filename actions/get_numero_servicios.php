
<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'empleado') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}


require_once '../clases/Response_json.php';
include_once '../clases/DataBase.php';


$respuesta_json = new ResponseJson();
$idEmpleado = $session->getSessionVariable('id_usuario');

$response = array();

$parametros = array(
    ':idEmpleado' => $idEmpleado
);

$sql = "SELECT COUNT(*) as numRegistros
FROM servicios 
WHERE  idEmpleado = :idEmpleado;";
  // Ejecutar la consulta
  $numeroServicios = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');
    
  $sql = "SELECT COUNT(*) as numRegistros
  FROM servicios 
  WHERE  idEmpleado = :idEmpleado AND estado = 'en curso';";
    // Ejecutar la consulta
    $numero_nuevos_servicios = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');     
    $response = [
        'numServicios' => $numeroServicios,
        'numNuevosServicios' => $numero_nuevos_servicios,
        
    ];

    $response = array('success' => true, 'response' => $response); // Encerrar la cotización en un array
    $respuesta_json->response_json($response);
