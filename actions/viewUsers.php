<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}



include_once '../model/UsuarioModel.php';
$consulta = new UsuarioModel();
$response = array();

$userData = $consulta->getUsers();

    if(!empty($userData)) {
        $response = array('success' => true, 'dataUsers' => $userData);

    } else {
        $response = array('success' => false, 'message' => 'No hay datos');
    }
echo json_encode($response);



