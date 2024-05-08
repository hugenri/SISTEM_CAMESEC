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
require_once '../model/SolicitudCotizacionModel.php';
require_once '../clases/email.php';
require_once '../clases/DataBase.php';


$respuesta_json = new ResponseJson();
$consulta = new CotizacionModel();
$solicitudCotizacion = new SolicitudCotizacionModel();

$validacion = true;
$response = null;


  $id_solicitud_cotizacion = DataSanitizer::sanitize_input($_POST['idSolicitudCotizacion']);
  $fecha = DataSanitizer::sanitize_input($_POST['fecha']);
  $observaciones = DataSanitizer::sanitize_input($_POST['observaciones']);
  $idCliente = DataSanitizer::sanitize_input($_POST['idCliente']);
  $descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
  $costoInstalacion = DataSanitizer::sanitize_input($_POST['costoInstalacion']);
  $descuento = DataSanitizer::sanitize_input($_POST['descuento']);

   // Sanitizar la entrada del descuento
   $descuento = isset($descuento) ? intval($descuento) : 0;


 
  $data = [$fecha, $observaciones, $idCliente, $descripcion,
          $id_solicitud_cotizacion, $costoInstalacion];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){
      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
      $respuesta_json->response_json($response);

    }
      
    $date = $fecha; 
    $messageDate = 'Fecha no válida. Formato: Y-m-d';
    $response = DataValidator::validateDateForMySQL($date, $messageDate);
    
    if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);
    }

    $datos = [$costoInstalacion];
    $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumbersFloat($datos, $messageLetters);
   if ($response !== true) {
    $validacion = false;
    $respuesta_json->response_json($response);

  }
  
    $datos_string_letras = [$descripcion, $observaciones];
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
      // Query para verificar existencia de cotización
  $sql = "SELECT * FROM cotizaciones WHERE idSolicitudCotizacion = :idSC";

  // Parámetros para la consulta preparada
  $parametros = array(
      ':idSC' => $id_solicitud_cotizacion
  );

  // Ejecutar la consulta
  $resultado = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');

  // Verificar si se encontró el cliente y devolver sus datos
  if (!empty($resultado)) {
    $validacion = false;
    $response = array('success' => false, 'message' => 'Existe una cotización');
    $respuesta_json->response_json($response);
    }    
   
    if ($validacion == true) {
      $datosItems = new Cart();
      $items = $datosItems->contents(); // Obtener los elementos del carrito
      $totales = calcularTotales($items, $costoInstalacion, $descuento);
      $subtotal = $totales['subtotal'];
      $iva = $totales['iva'];
      $total = $totales['total'];
      // Llamar a createCotizacion y obtener el ID de la cotización
      $id_cotizacion = $consulta->createCotizacion($fecha, $observaciones, $id_solicitud_cotizacion, $descripcion,
                                                   $subtotal, $total, $iva, $descuento, $costoInstalacion);
      // Verificar si la cotización se creó correctamente
      if ($id_cotizacion !== false) {
        
        if(!empty($items)){
           // Llamar a insertOrderItems con el ID de la cotización
        $orderitems = $consulta->insertOrderItems($id_cotizacion, $items);
		
          $datosItems->clear_cart(); // Si se registraron todas las ventas correctamente, vacía el carrito
        }
         
         
        $solicitudCotizacion->updateEstado($id_solicitud_cotizacion, 'cotizada');

        $datos_cliente = obtenerDatosCliente($idCliente);
        $emailCliente = $datos_cliente['email'];
        $nombre = $datos_cliente['nombre'].' '. $datos_cliente['apellidoPaterno'] . ' '. $datos_cliente['apellidoMaterno'] ;
        $razonSocial = $datos_cliente['razonSocial'];
		$response = array("success" => true, 'message' => 'Cotización registrada con éxito! Se a enviado el email al cliente!');
          $respuesta_json->response_json($response);
      /*
       // Verificar si se obtuvo el correo electrónico del cliente
       if ($emailCliente !== null) {
        $emailEnviado = email($emailCliente, $razonSocial, $nombre);
        if ($emailEnviado) {
          
          $response = array("success" => true, 'message' => 'Cotización registrada con éxito! Se a enviado el email al cliente!');
          $respuesta_json->response_json($response);
       } 
       }
	   $response = array("success" => true, 'message' => 'Cotización registrada con éxito! Se a enviado el email al cliente!');
          $respuesta_json->response_json($response);
         */
      } else {
          $response = array('success' => false, 'message' => 'Error en el registro');
          $respuesta_json->response_json($response);
      }
      }


//#################Funciones##################################

  function email($emailCliente, $razonSocial, $nombre) {
    // Contenido HTML para el correo electrónico
    $contenidoHTML = "
        <html>
        <head>
            <title>Cotización de Servicio</title>
        </head>
        <body>
            <p>Estimado(a) $nombre,</p>
            <p>Su cotización del servicio ha sido realizada.</p>
            <p>Por favor, ingrese al sitio web de GolemSistem para ver su cotización y aceptarla si es de su interés.</p>
            <p><a href='https://golemsiseg.com/sesion.php'>Acceder a GolemSiseg</a></p>
            <p>Gracias por su interés.</p>
        </body>
        </html>
    ";

    // Configurar los datos para enviar el correo electrónico
    $datosEmail = array(
        'email' => $emailCliente,
        'nombre' => $razonSocial,
        'contenidoHTML' => $contenidoHTML,
        'asunto' => 'Cotización de Servicio'
    );

    // Instanciar el objeto CorreoElectronico y enviar el correo
    $email = new CorreoElectronico();
    $emailEnviado = $email->enviarCorreos([$datosEmail]);

    return $emailEnviado;
}

function obtenerDatosCliente($idCliente) {
  

  // Query para obtener los datos del cliente
  $sql = "SELECT nombre, apellidoPaterno, apellidoMaterno, razonSocial, email FROM cliente WHERE idCliente = :idCliente";

  // Parámetros para la consulta preparada
  $parametros = array(
      ':idCliente' => $idCliente
  );

  // Ejecutar la consulta
  $resultado = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');

  // Verificar si se encontró el cliente y devolver sus datos
  if (!empty($resultado)) {
      return $resultado;
  } else {
      // En caso de que no se encuentre el cliente, puedes manejarlo según tus necesidades, como lanzar una excepción o devolver un valor predeterminado
      return null;
  }
}

function calcularTotales($items, $costoInstalacion, $descuento) {
  $subtotal = 0;
  $iva = 0;
  $total = 0;
  $total_descuento = 0;

  // Verificar si hay elementos en el carrito
  if (!empty($items)) {
      // Calcular el subtotal
      foreach ($items as $item) {
          $subtotal += $item['price'] * $item['qty'];
      }
  }

  // Agregar el costo de instalación al subtotal
  $subtotal += $costoInstalacion;

  // Calcular el total con descuento si se aplica
  $descuento = ($descuento > 0 && $descuento <= 100) ? $descuento : 0;

  
  if ($subtotal > 0) {

    if($descuento != 0){
      $total_descuento = ($subtotal/ 100) * $descuento;
    }
      $total = $subtotal - $total_descuento;
  } else {
    $total_descuento = ($total/ 100) * $descuento;

      // Si no hay elementos en el carrito, el total será igual al costo de instalación
      $total = $costoInstalacion - $total_descuento;
  }

  // Calcular el IVA si hay un subtotal mayor que cero
  if ($subtotal > 0) {
      $iva = ($subtotal - $descuento)* 0.16;
  }
  $iva = ($total - $descuento)* 0.16;
  // Sumar el IVA al total
  $total += $iva;

  return [
      'subtotal' => $subtotal,
      'iva' => $iva,
      'total' => $total
  ];
}
  