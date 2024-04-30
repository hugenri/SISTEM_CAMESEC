<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

require_once '../clases/Response_json.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';

$respuesta_json = new ResponseJson();
$response = array();

$idOrdenCompra =  DataSanitizer::sanitize_input($_POST['idOrdenCompra']);


  //si se envia formulario sin datos se marca un error
  if(empty($idOrdenCompra)){

    $respuesta_json->handle_response_json(false, 'Faltan datos para precesar solicitud');
  }
  
 $messageLength = "ingrese solo numeros";
  $response = DataValidator:: validateNumber($idOrdenCompra, $messageLength);
  if ($response !== true) {
      $respuesta_json->response_json($response);
 }
        
$sql = "SELECT pc.id, p.nombre AS nombre_producto, p.descripcion AS descripcion_producto, p.precio AS precio_unitario, pc.cantidad AS cantidad_comprar,
pr.razonSocial AS nombre_proveedor, pr.email AS email_proveedor, pr.telefono AS telefono_proveedor,
c.razonSocial AS nombre_cliente, c.email AS email_cliente, c.telefono AS telefono_cliente,
sc.servicio AS servicio_ofrecido
FROM orden_compras oc
INNER JOIN cotizaciones co ON oc.idCotizacion = co.idCotizacion
INNER JOIN productos_cotizacion pc ON co.idCotizacion = pc.idCotizacion
INNER JOIN producto p ON pc.id_producto = p.id
INNER JOIN proveedor pr ON p.idProveedor = pr.idProveedor
INNER JOIN solicitudes_cotizacion sc ON co.idSolicitudCotizacion = sc.id
INNER JOIN cliente c ON sc.id_cliente = c.idCliente
WHERE oc.idOrdenCompra = :idOrdenCompra;
;";

       
$parametros = array(
    'idOrdenCompra'=>$idOrdenCompra
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

if(!empty($datos)){
    $response = array('success' => true, 'datosOrdenCompra'  => $datos);
    $respuesta_json->response_json($response);
} else {
    $respuesta_json->handle_response_json(false, 'No hay registro!');
}
