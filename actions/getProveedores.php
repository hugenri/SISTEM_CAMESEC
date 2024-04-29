<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}


include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';
require_once '../clases/Response_json.php';

$respuesta_json = new ResponseJson();
$response = null;

// Se establece la sentencia de la consulta SQL
$sql = "SELECT idProveedor, razonSocial from proveedor;";

$parametros = array(
 
);

$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros,true);

 if(!empty($datos)){
   $response = array("success" => true, 'datosProveedor' => $datos);

     $respuesta_json->response_json($response);

 }else{
        $respuesta_json->handle_response_json(false, 'No hay registro!');

 }
