<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}




include_once '../model/SolicitudCotizacionModel.php';
include_once '../model/ProductoModel.php';
require_once '../clases/Response_json.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/Cart.php';
include_once '../clases/DataBase.php';


$consulta = new SolicitudCotizacionModel();
$cosulta_Producto = new ProductoModel();
$respuesta_json = new ResponseJson();

$response = array();

$action = $_POST['action'];

if(isset($action) && !empty($action)){
	if($action == 'mostarSolicitudes'){
        $sql = "SELECT 
        sc.*,
        c.razonSocial AS cliente_razon_social
    FROM
        solicitudes_cotizacion sc
    LEFT JOIN
        cliente c ON sc.id_cliente = c.idCliente
    WHERE
        sc.estado = 'en proceso';";

    $datos = $consulta->getSolicitudesCotizacion($sql);

    if(!empty($datos)){
        $response = array('success' => true, 'dataSolicitud'  => $datos);

        $respuesta_json->response_json($response);

    }else{
        $respuesta_json->handle_response_json(false, 'No hay registros');

    }
}elseif($action == 'addToListProduct'){
    
        $respuesta_json->handle_response_json(false, 'No hay registros');

/******************* */
}elseif($action == 'eliminarItems'){
    $items = new Cart();
    
    $items->clear_cart();
    
    if($items->getRowCount() == 0){
        $response['succes'] = true;
      $response['message'] = 'Los items  fueron eliminados...';
        
    } else {
        $response['succes'] = false;
        $response['message'] = 'Error al eliminar los items.';
    }
    $respuesta_json->response_json($response);
}elseif ($action == 'eliminarItem') {
    $items = new Cart;

    $rowid = $_POST['rowid'];
    // Intentar obtener los elementos del carrito
    $removeCartItem = $items->remove($rowid);
    
    if($removeCartItem){
        // Intentar obtener los elementos del carrito
        $datos = $items->contents();
        if($datos){
            $response['success'] = true;
            $response['items'] = array_values($datos); // Convertir el array asociativo a un array indexado
            $respuesta_json->response_json($response);
    
          } else {
            $response['success'] = false;
            $response['message'] = 'Error al obtener los elementos.';
            $respuesta_json->response_json($response);
    
           }
        
    } else {
        $response['succes'] = false;
        $response['message'] = 'Error al eliminar el elemento.';
        $respuesta_json->response_json($response);

    }
    /*********************** */
}elseif ($action == "eliminar") {
    $id = DataSanitizer::sanitize_input($_POST['id']);

    if($id == ""){
        $respuesta_json->handle_response_json(false, 'Faltan datos');

    }
    
    $messageNumbers = "Ingrese solo numero sin decimal en el dato";
   $response = DataValidator::validateNumber($id, $messageNumbers);
   if ($response !== true) {
    $respuesta_json->response_json($response);

  }
    $sql = "DELETE FROM solicitudes_cotizacion
    WHERE id = :id;";
    

$parametros = array(
':id' => $id
);

// Ejecutar la consulta
$consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);

if($consulta){
    $respuesta_json->handle_response_json(true, 'El registro de la solicitud de cotización fue eliminado!');

} else {
    $respuesta_json->handle_response_json(false, 'El registro no se pudo eliminar');
}

}elseif ($action == "getDatosSolicitudCotizacion") {


    $idSolicitudCotiacion =  DataSanitizer::sanitize_input($_POST['idSolicitud']);

    if($idSolicitudCotiacion == ""){
        $respuesta_json->handle_response_json(false, 'Faltan datos');

    }
    
    $messageNumbers = "Ingrese solo numero sin decimal en el dato";
   $response = DataValidator::validateNumber($idSolicitudCotiacion, $messageNumbers);
   if ($response !== true) {
    $respuesta_json->response_json($response);

  }
    $sql = "SELECT 
    sc.*,
    cli.razonSocial AS cliente_razon_social , CONCAT(cli.nombre, ' ', cli.apellidoPaterno) AS nombreCliente,
    cli.telefono, cli.idCliente
FROM
    solicitudes_cotizacion sc
LEFT JOIN
    cliente cli ON sc.id_cliente = cli.idCliente
WHERE
    sc.id = :idSolicitudCotizacion;";
    

$parametros = array(
'idSolicitudCotizacion' => $idSolicitudCotiacion
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');

if(!empty($datos)){
    $response = array('success' => true, 'dataSolicitud'  => $datos);

    $respuesta_json->response_json($response);

}else{
    $respuesta_json->handle_response_json(false, 'No hay registros!');

}
}

} else {
    $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  