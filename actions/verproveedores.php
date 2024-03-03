<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}


include_once '../model/ProveedorModel.php';

$consulta = new ProveedorModel();
$response = array();
$dataprovider = $consulta->getProvider();

    if(!empty($dataprovider)) {
        $response = array('success' => true, 'dataprovider' => $dataprovider);

    } else {
        $response = array('success' => false, 'message' => 'No hay datos');
    }

echo json_encode($response);



