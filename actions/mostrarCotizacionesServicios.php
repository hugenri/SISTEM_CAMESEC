<?php


include_once '../model/SolicitudCotizacionModel.php';
include_once '../clases/dataSanitizer.php';

$consulta = new SolicitudCotizacionModel();
$response = array();
$id_cliente = 4;
    // Si no se proporciona un ID, se asume que es una solicitud para obtener todas las cotizaciones
    $dataCotizaciones = $consulta->getSolicitudCotizaciones($id_cliente);

    if (!empty($dataCotizaciones)) {
        $response = array('success' => true, 'cotizaciones' => $dataCotizaciones); // Encerrar la cotización en un array
    } else {
        $response = array('success' => false, 'message' => 'No tiene cotizaciones');
    }
    
  // Enviar la respuesta como JSON
  header('Content-Type: application/json');
  echo json_encode($response);
  exit();
?>
