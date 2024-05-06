
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

$parametros = array(
    
);


$sql = "SELECT COUNT(*) as numRegistros
FROM facturas
WHERE  estatus = 'pendiente';";
  // Ejecutar la consulta
  $numero_nuevas_facturas = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');
    
  $sql = "SELECT COUNT(*) as numRegistros
  FROM Facturas";
    // Ejecutar la consulta
    $numero_facturas = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');     
    $response = [
        'numFactuas' => $numero_facturas,
        'numNuevosFacturas' => $numero_nuevas_facturas,
        
    ];

    $response = array('success' => true, 'response' => $response); // Encerrar la cotización en un array
    $respuesta_json->response_json($response);
