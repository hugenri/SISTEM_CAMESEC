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
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/Cart.php';


$respuesta_json = new ResponseJson();

$response = array();

$action = $_POST['action'];

if(isset($action) && !empty($action)){

  if($action == "cargarDatosCotizacion"){

    $idCotizacion = DataSanitizer::sanitize_input($_POST['idCotizacion']);


    if($idCotizacion == ""){ //para verificar que los datos enviados por POST tenga un valor.
      $respuesta_json->handle_response_json(false, 'faltan datos!');
    
     } 
    
     $messageLetters = "Ingrese solo numeros en el dato";
     $response = DataValidator::validateNumber($idCotizacion, $messageLetters);
     if ($response !== true) {
         $respuesta_json->response_json($response);
     }
    $sql = "SELECT co.*, p.nombre AS nombreProducto, p.imagen, p.precio, pc.*,
    cli.razonSocial AS empresa, CONCAT(cli.nombre, ' ', cli.apellidoPaterno) AS nombreCliente,
    cli.telefono,
    sc.servicio, sc.id_cliente
    FROM cotizaciones co
    INNER JOIN productos_cotizacion pc ON co.idCotizacion = pc.idCotizacion
    INNER JOIN producto p ON pc.id_producto = p.id
    INNER JOIN solicitudes_cotizacion sc ON co.idSolicitudCotizacion = sc.id
    INNER JOIN cliente cli ON sc.id_cliente = cli.idCliente
    WHERE co.idCotizacion = :idCotizacion;";

    $parametros = array(
      
        'idCotizacion' => $idCotizacion
    );
    
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);     
    if(!empty($datos)){
    
      foreach ($datos as $producto) {
        $id_producto = $producto['id_producto'];
      }
     // Instanciar la clase Cart
     $items = new Cart();
     if(!empty($id_producto)){

       // Obtener la cantidad de elementos del carrito
    $cantidad = $items->getRowCount();
    
    if ($cantidad > 0) {
      $items->clear_cart();
    }
        foreach ($datos as $producto) {
        // Crear un array con los detalles del producto actual
        $productoActual = array(
        'id' => $producto['id_producto'],
        'name' => $producto['nombreProducto'],
        'imagen' => $producto['imagen'],
        'price' => $producto['precio'],
        'qty' => $producto['cantidad'],
    );

    // Insertar el producto actual en el carrito
    $resultado = $items->insert($productoActual);
    if($resultado === FALSE){
      $respuesta_json->handle_response_json(false, 'No se guardaron los datos de los productos');

    }
        } 
      }

     $response = array('success' => true, 'datosCotizacion' => $datos); // Encerrar la cotización en un array
     $respuesta_json->response_json($response);
  
  }else{
     $response = array('success' => false, 'message' => 'No hay datos...');
     $respuesta_json->response_json($response);
    }

  }elseif($action == "cargarDatosProductos"){   

    $items = new Cart(); // Crear una instancia de la clase Cart
    
    // Intentar obtener los elementos del carrito
    $producs = $items->contents();
    
    // Obtener la cantidad de elementos del carrito
    $cantidad = $items->getRowCount();
    
    if ($cantidad > 0) {
        $response = array('success' => true, 'productos' => array_values($producs));
        $respuesta_json->response_json($response);
    } else {
        $response = array('success' => false, 'message' => 'No hay datos...');
        $respuesta_json->response_json($response);
    }
    
  }

//######################
} else {
    $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
