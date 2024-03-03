<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}



include_once '../model/ClienteModel.php';

$consulta = new ClienteModel();
$response = array();
$dataclients = $consulta->getClients();

    if(!empty($dataclients)) {
        $response = array('success' => true, 'dataclients' => $dataclients);

    } else {
        $response = array('success' => false, 'message' => 'No hay datos');
    }

echo json_encode($response);



