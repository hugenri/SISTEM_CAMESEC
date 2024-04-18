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


$consulta = new SolicitudCotizacionModel();
$cosulta_Producto = new ProductoModel();
$respuesta_json = new ResponseJson();


$response = array();

$action = 'addListProduct';// $_POST['action'];

   $id = DataSanitizer::sanitize_input($_POST['id']);
    $cantidad = DataSanitizer::sanitize_input($_POST['quantity']);

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
    // Intentar obtener los elementos del carrito
    $items = $cart->contents();
    
      if($items){
        $response['success'] = true;
        $response['items'] = array_values($items); // Convertir el array asociativo a un array indexado
		    $respuesta_json->response_json($response);

      } else {
        $response['success'] = false;
        $response['message'] = 'Error al obtener los elementos.';
		    $respuesta_json->response_json($response);

       }
    
     }   
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registros');
    }

      
