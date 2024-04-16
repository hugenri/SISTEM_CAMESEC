<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

// Función para manejar errores fatales y convertirlos en una respuesta JSON
function handleFatalError() {
    $error = error_get_last();
    if ($error !== null) {
        // Limpiar el búfer de salida
        if (ob_get_contents()) ob_clean();
        
        http_response_code(500);
        header('Content-Type: application/json');
        $errorData = [
            'error' => 'Error fatal',
            'message' =>  $error['message']
        ];
        exit(json_encode($errorData));
    }
}

// Registra la función para manejar errores fatales
register_shutdown_function('handleFatalError');

include_once '../model/SolicitudCotizacionModel.php';
include_once '../model/ProductoModel.php';
require_once '../clases/Response_json.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/Cart.php';


$consulta = new SolicitudCotizacionModel();
$cosulta_Producto = new ProductoModel();
$respuesta_json = new ResponseJson();

$response = array();


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
    