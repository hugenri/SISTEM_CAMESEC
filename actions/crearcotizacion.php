<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/CotizacionModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
require_once '../clases/Response_json.php';
require_once '../clases/Cart.php';


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

$respuesta_json = new ResponseJson();
$consulta = new CotizacionModel();
$validacion = true;
$response = null;



  $id_solicitud_cotizacion = DataSanitizer::sanitize_input($_POST['idSolicitudCotizacion']);
  $fecha = DataSanitizer::sanitize_input($_POST['fecha']);
  $observaciones = DataSanitizer::sanitize_input($_POST['observaciones']);
  $idCliente = DataSanitizer::sanitize_input($_POST['idCliente']);
  $descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
  $servicio = DataSanitizer::sanitize_input($_POST['nombreServicio']);
  $costoInstalacion = DataSanitizer::sanitize_input($_POST['costoInstalacion']);
  $descuento = DataSanitizer::sanitize_input($_POST['descuento']);


 
  $data = [$fecha, $observaciones, $idCliente, $descripcion,
          $id_solicitud_cotizacion, $costoInstalacion, $descuento];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){
      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
      $respuesta_json->response_json($response);

    }else{
      
    $date = $fecha; 
    $messageDate = 'Fecha no válida. Formato: Y-m-d';
    $response = DataValidator::validateDateForMySQL($date, $messageDate);
    
    if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);
    }

    $datos = [$costoInstalacion, $descuento];
    $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumbersFloat($datos, $messageLetters);
   if ($response !== true) {
    $validacion = false;
    $respuesta_json->response_json($response);

  }
  
    $datos_string_letras = [$descripcion, $observaciones, $servicio];
      $messageLetters = "Ingrese solo letras en el dato";
     $response = DataValidator::validateLettersOnlyArray($datos_string_letras, $messageLetters);
     if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);

    }

    $datos_string_lonlitud = [$descripcion, $observaciones];
      $messageLength = "El dato debe tener más de 8  y menos de 120 letras";
     $response = DataValidator::validateLengthInArray($datos_string_lonlitud, 8, 120, $messageLength);
     if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);

    }

    $datos_int = [$idCliente,$id_solicitud_cotizacion];
      $messageNumbers = "Ingrese solo numero sin decimal en el dato";
     $response = DataValidator::validateNumbersOnlyArray($datos_int, $messageNumbers);
     if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);

    }    
    if ($validacion == true) {
      $datos = new Cart();
      $items = $datos->contents(); // Obtener los elementos del carrito
      $totales = calcularTotales($items, $costoInstalacion, $descuento);
      $subtotal = $totales['subtotal'];
      $iva = $totales['iva'];
      $total = $totales['total'];
      // Llamar a createCotizacion y obtener el ID de la cotización
      $id_cotizacion = $consulta->createCotizacion($fecha, $observaciones, $idCliente, $descripcion,
                                                   $subtotal, $total, $iva, $descuento, $costoInstalacion, $servicio);
      // Verificar si la cotización se creó correctamente
      if ($id_cotizacion !== false) {
          // Llamar a insertOrderItems con el ID de la cotización
          $orderitems = $consulta->insertOrderItems($id_cotizacion, $items);
          $response = array("success" => true, 'message' => 'Cotización registrada con éxito!');
          $respuesta_json->response_json($response);
      } else {
          $response = array('success' => false, 'message' => 'Error en el registro');
          $respuesta_json->response_json($response);
      }
  }
  
  }

function calcularTotales($items, $costoInstalacion, $descuento) {
  $subtotal = 0;
  $iva = 0;
  $total = 0;

  // Calcular el subtotal
  foreach ($items as $item) {
      $subtotal += $item['price'] * $item['qty'];
  }

  // Agregar el costo de instalación al subtotal
  $subtotal += $costoInstalacion;

  // Calcular el total con descuento
  $descuento = ($descuento > 0 && $descuento <= 100) ? $descuento : 0;
  $total = $subtotal - ($subtotal * ($descuento / 100));

  // Calcular el IVA (asumiendo un 16%)
  $iva = $subtotal * 0.16;

  // Sumar el IVA al total
  $total += $iva;

  return [
      'subtotal' => $subtotal,
      'iva' => $iva,
      'total' => $total
  ];
}