<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/RequisicionModel.php';
include_once '../clases/dataSanitizer.php';


$consulta = new RequisicionModel();
$response = array();


$id = DataSanitizer::sanitize_input($_POST['id']);

if($id == ""){ //para verificar que los datos enviados por POST tenga un valor.

	$response = array('success' => false, 'message' => 'Faltan datos');
 } else{
	
	      $result = $consulta->deleteRequisicion($id); //se realiza la consulta SQL a MYSQL
	  
	if($result == true){//si elimino
	   $response = array('success' => true, 'message' => 'Requisición  eliminada!');
	   
	}else{
		$response = array('success' => false, 'message' => 'La requisición no se pudo eliminar');
	}
}

//se retorna $response como JSON
echo json_encode($response);
