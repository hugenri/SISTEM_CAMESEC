<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/ProductoModel.php';
include_once '../clases/dataSanitizer.php';

$consulta = new ProductoModel();
$response = array();


if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = DataSanitizer::sanitize_input($_POST['id']);
    $dato = $consulta->getDetalles($id);

    if (!empty($dato)) {
        $response = array('success' => true, 'detalles' => $dato);
    } else {
        $response = array('success' => false, 'message' => 'No hay datos para el ID proporcionado');
    }

    echo json_encode($response);
}else{    
$dataclients = $consulta->getProducts();

    if(!empty($dataclients)) {
        $response = array('success' => true, 'dataProduct' => $dataclients);

    } else {
        $response = array('success' => false, 'message' => 'No hay datos');
    }

echo json_encode($response);

}

