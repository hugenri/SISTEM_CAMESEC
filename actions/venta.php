<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'cliente') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

include '../clases/Cart.php';
include '../model/VentaModel.php';

$response = array();
$action = $_POST['action'];

if(isset($action) && !empty($action)){
    if($action == 'addToCart' && !empty($_POST['id']) && !empty($_POST['quantity'])){
	   $ventaModel = new VentaModel();
    $productID = $_POST['id'];
		$cantidad = $_POST['quantity'];
     // Obtener detalles del producto
     $itemData = $ventaModel->getProductoId($productID);
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
         $cartItems = $cart->getRowCount();
         $response['status'] = 'success';
         $response['message'] = 'El producto se agregó correctamente al carrito.';
         $response['cartItems'] = $cartItems;
         
     } else {
         $response['status'] = 'error';
         $response['message'] = 'Error al agregar el producto al carrito.';
         
     }
    // Enviar la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
	
   }elseif ($action == 'mostarProductos') {
    $ventaModel = new  VentaModel();
    $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';
     // Obtener productos utilizando el método correspondiente de VentaModel
     $products = $ventaModel->getProductos($searchTerm);
    
     // Enviar la respuesta como JSON
     header('Content-Type: application/json');
     echo json_encode($products);
     exit();
   }elseif ($action == 'getRowCount') {
    $cart = new Cart();
			$cartItems = $cart->getRowCount();
			
        $response['status'] = 'success';
		    $response['cartItems'] = $cartItems;
         // Enviar la respuesta como JSON
       header('Content-Type: application/json');
       echo json_encode($response);
       exit();
   }elseif ($action == 'carrito') {
    $cart = new Cart();
    
    // Intentar obtener los elementos del carrito
    $cartItems = $cart->contents();
    
    if($cartItems){
        $response['status'] = 'success';
        $response['cart'] = array_values($cartItems); // Convertir el array asociativo a un array indexado
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al obtener los elementos del carrito.';
    }
    
    // Enviar la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
   }elseif($action == 'elimonarProductoCart'){
    $cart = new Cart;

    $rowid = $_POST['rowid'];
    // Intentar obtener los elementos del carrito
    $removeCartItem = $cart->remove($rowid);
    
    if($removeCartItem){
        $response['status'] = 'success';
            $response['message'] = 'El el elemento del carrito fue eliminado.';
    
        
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al eliminar el elemento del carrito.';
    }
    // Enviar la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
   }elseif($action == 'vaciar_carrito'){
    $cart = new Cart;
    // Intentar obtener los elementos del carrito
    $removeCartItem = $cart->clear_cart();
    
    if($removeCartItem){
        $response['status'] = 'success';
        $response['message'] = 'El carrito fue vaciado.';
        
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al eliminar los productos del carrito.';
    }
    // Enviar la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();

   }elseif ($action == 'registarVentaProducto') {
    // Crear una instancia del modelo de venta
     $ventaModel = new VentaModel();

    // Llamar a la función registrarVenta con los datos necesarios
     $idProducto = $_POST['id'];
     $idCliente = $session->getSessionVariable('id_cliente');
     $cantidad = $_POST['cantidad'];
     $total = $_POST['total'];
     $fecha = $_POST['fecha'];
    
   $idVenta = $ventaModel->registrarVenta($idProducto, $idCliente, $fecha,  $cantidad, $total);


   if($idVenta){
    $response['status'] = 'success';
        $response['message'] = 'La venta se registró correctamente';

    } else {
    $response['status'] = 'error';
    $response['message'] = 'Error al registrar la venta.';
    }
        // Enviar la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
    
   }elseif ($action == 'registarCartVenta') {
     // Crear una instancia del modelo de venta
      $ventaModel = new VentaModel();

      // Obtener los datos del carrito de la sesión
      $cart = new Cart();

    // Verificar si el carrito tiene datos
    if ($cart->getRowCount() > 0) {
    $cartItems = $cart->contents();
    
    //$total = $cart->calculateTotal();
    $fecha = date('Y-m-d'); // Fecha actual
    $id_cliente = $session->getSessionVariable('id_cliente');
    // Registrar la venta del producto en la base de datos
    $idVenta =  $ventaModel->insertOrderItems($id_cliente, $fecha, $cartItems);

    if ($idVenta) {
        // Si se registraron todas las ventas correctamente, vacía el carrito
        $cart->clear_cart();

        // Envía una respuesta de éxito
        $response['status'] = 'success';
        $response['message'] = 'Las ventas se registraron correctamente.';
     }else {
        // Si ocurrió un error al registrar la venta de un producto, envía una respuesta de error
        $response['status'] = 'error';
        $response['message'] = 'Error al registrar la venta del producto.';
      }
   } else {
    // Si el carrito está vacío, envía una respuesta de error
    $response['status'] = 'error';
    $response['message'] = 'El carrito está vacío.';
   }

   // Enviar la respuesta como JSON
   header('Content-Type: application/json');
   echo json_encode($response);
   exit();
  }

}
