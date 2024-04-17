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
} else {
    $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}   
if($action == 'addToListProduct'){
$id = 3;//DataSanitizer::sanitize_input($_POST['id']);
    $cantidad = 3;// DataSanitizer::sanitize_input($_POST['quantity']);

    $datos = [$id, $cantidad];
    $messageLetters = "Ingrese solo numeros en el dato";
    $response = DataValidator::validateNumbersOnlyArray($datos, $messageLetters);
    if ($response !== true) {
        $respuesta_json->response_json($response);
    }

   // Obtener detalles del producto
   $itemData = $cosulta_Producto->getProducto($id);
       if(!empty($itemData)){
     $cart = new Cart();
 
     // Ajustar el formato para que coincida con las expectativas de la función insert
     $productForCart = array(
         'id' => $itemData['id'],
         'name' => $itemData['nombre'],  // Ajusta esto según la estructura de tu tabla
         'imagen' => $itemData['imagen'], 
         'price' => $itemData['precio'], // Ajusta esto según la estructura de tu tabla
         'qty' => $cantidad,  // Puedes ajustar la cantidad predeterminada según tus necesidades
     );
 
     // Intentar agregar el producto al carrito
     $insertItem = $cart->insert($productForCart);
 
     $response = array(); // Inicializar $response
 
     if($insertItem){
         $Items = $cart->getRowCount();
         $response['success'] = true;
         $response['message'] = 'El producto se agregó correctamente al carrito.';
         $response['cartItems'] = $Items;
         
        $respuesta_json->response_json($response);
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registros');
    }

       }
}elseif($action == 'elimonarProducto'){
    $cart = new Cart;

    $rowid = $_POST['rowid'];
    // Intentar obtener los elementos del carrito
    $removeCartItem = $cart->remove($rowid);
    
    if($removeCartItem){
        $response['succes'] = true;
            $response['message'] = 'El el elemento  fue eliminado.';
    
        
    } else {
        $response['succes'] = false;
        $response['message'] = 'Error al eliminar el elemento.';
    }
    // Enviar la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
   }

}
