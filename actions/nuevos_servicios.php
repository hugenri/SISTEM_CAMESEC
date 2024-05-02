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

/*        
$sql = "SELECT sc.id AS id_solicitud,
sc.servicio AS servicio,
cl.razonSocial AS razon_social_cliente,
cl.nombre AS nombre_cliente,
cl.apellidoPaterno AS apellido_paterno_cliente,
cl.apellidoMaterno AS apellido_materno_cliente,
cl.email AS email_cliente,
cl.telefono AS telefono_cliente, oc.idOrdenCompra
FROM solicitudes_cotizacion sc
JOIN cliente cl ON sc.id_cliente = cl.idCliente
JOIN cotizaciones co ON sc.id = co.idSolicitudCotizacion
JOIN orden_compras oc ON co.idCotizacion = oc.idCotizacion
WHERE oc.estado = 'finalizada' AND co.estatus = 'aceptada';";
*/

$sql = "SELECT 
sc.id AS id_solicitud,
sc.servicio AS servicio,
cl.razonSocial AS razon_social_cliente,
cl.nombre AS nombre_cliente,
cl.apellidoPaterno AS apellido_paterno_cliente,
cl.apellidoMaterno AS apellido_materno_cliente,
cl.email AS email_cliente,
cl.telefono AS telefono_cliente,
oc.idOrdenCompra
FROM solicitudes_cotizacion sc
JOIN 
cliente cl ON sc.id_cliente = cl.idCliente
JOIN 
cotizaciones co ON sc.id = co.idSolicitudCotizacion
JOIN 
orden_compras oc ON co.idCotizacion = oc.idCotizacion
WHERE 
oc.estado = 'finalizada' 
AND co.estatus = 'aceptada'
AND oc.idOrdenCompra NOT IN (SELECT idOrdenCompra FROM servicios WHERE idOrdenCompra IS NOT NULL);
";
       
$parametros = array(
    
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

if(!empty($datos)){
    $response = array('success' => true, 'datos'  => $datos);
    $respuesta_json->response_json($response);
} else {
    $respuesta_json->handle_response_json(false, 'No hay registro!');
}
