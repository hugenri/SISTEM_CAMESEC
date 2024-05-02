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

        
$sql = "SELECT s.*, sc.servicio AS nombre_servicio, c.razonSocial AS razon_social_cliente
FROM servicios s
JOIN orden_compras oc ON s.idOrdenCompra = oc.idOrdenCompra
JOIN cotizaciones co ON oc.idCotizacion = co.idCotizacion
JOIN solicitudes_cotizacion sc ON co.idSolicitudCotizacion = sc.id
JOIN cliente c ON sc.id_cliente = c.idCliente;
;";
       
$parametros = array(
    
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

if(!empty($datos)){
    $response = array('success' => true, 'dataServices'  => $datos);
    $respuesta_json->response_json($response);
} else {
    $respuesta_json->handle_response_json(false, 'No hay registro!');
}
