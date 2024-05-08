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

  $idCotizacion = DataSanitizer::sanitize_input($_POST['idCotizacion']);
 $id_solicitud_cotizacion = DataSanitizer::sanitize_input($_POST['idSolicitudCotizacion']);
  $fecha = DataSanitizer::sanitize_input($_POST['fecha']);
  $observaciones = DataSanitizer::sanitize_input($_POST['observaciones']);
  $descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
  $costoInstalacion = DataSanitizer::sanitize_input($_POST['costoInstalacion']);
  $descuento = DataSanitizer::sanitize_input($_POST['descuento']);
  $subtotal = DataSanitizer::sanitize_input($_POST['subtotal']);
  $totalDescuento = DataSanitizer::sanitize_input($_POST['totalDescuento']);
  $iva = DataSanitizer::sanitize_input($_POST['iva']);
  $total = DataSanitizer::sanitize_input($_POST['total']);
  $idCliente = DataSanitizer::sanitize_input($_POST['idCliente']);

   $descuento = isset($descuento) ? intval($descuento) : 0;
   $totalDescuento = isset($totalDescuento) ? intval($totalDescuento) : 0;



 
  $data = [$fecha, $observaciones, $descripcion,
          $id_solicitud_cotizacion, $costoInstalacion, $idCotizacion, $subtotal,
         $iva, $total, $totalDescuento, $descuento, $idCliente];
          //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $respuesta_json->handle_response_json(false, "Faltal datos");
    }
  
    $date = $fecha; 
    $messageDate = 'Fecha no válida. Formato: Y-m-d';
    $response = DataValidator::validateDateForMySQL($date, $messageDate);
    
    if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);
    }

    $datos = [$costoInstalacion, $iva, $total, $subtotal];
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
      $messageLength = "El dato debe tener más de 8  y menos de 150 letras";
     $response = DataValidator::validateLengthInArray($datos_string_lonlitud, 8, 150, $messageLength);
     if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);

    }
   
    $datos_int = [$idCotizacion, $id_solicitud_cotizacion, $idCliente];
      $messageNumbers = "Ingrese solo numero sin decimal en el dato";
     $response = DataValidator::validateNumbersOnlyArray($datos_int, $messageNumbers);
     if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);
     }
    //########################################
   
    if ($validacion == true) {
      $datosItems = new Cart();
      $items = $datosItems->contents(); // Obtener los elementos del carrito
      $estatus = "enviada";
      // Llamar a createCotizacion y obtener el ID de la cotización
      $consulta_resultado = actualizar($idCotizacion, $fecha, $observaciones,  $id_solicitud_cotizacion, $descripcion, $subtotal, 
                                 $total, $iva, $descuento, $costoInstalacion, $estatus);

 // Verificar si la cotización se creó correctamente
      if ($consulta_resultado) {
        $numeroItems = $datosItems->getRowCount();

        if($numeroItems > 0){

         $consulta->actualizarProductos($idCotizacion, $items);
		
          $datosItems->clear_cart(); // Si se registraron todas las ventas correctamente, vacía el carrito
        
        }

        $solicitudCotizacion->updateEstado($id_solicitud_cotizacion, 'cotizada');

        $datos_cliente = obtenerDatosCliente($idCliente);
        $emailCliente = $datos_cliente['email'];
        $nombre = $datos_cliente['nombre'].' '. $datos_cliente['apellidoPaterno'] . ' '. $datos_cliente['apellidoMaterno'] ;
        $razonSocial = $datos_cliente['razonSocial'];
		    
       // Verificar si se obtuvo el correo electrónico del cliente
       if ($emailCliente !== null) {
        $emailEnviado = email($emailCliente, $razonSocial, $nombre);
        if ($emailEnviado) {
          
              $respuesta_json->handle_response_json(true, 'Cotización actualizada con éxito! Se a enviado el email al cliente!');

       } 
       }
     $respuesta_json->handle_response_json(true, 'Cotización actualizada con éxito! Se a enviado el email al cliente!');
      } else {
          $respuesta_json->handle_response_json(true, 'Error en la actualización!');

      }
      }
     

//#################Funciones##################################
function actualizar($idCotizacion, $fecha, $observaciones, $idSolicitudCotizacion, $descripcion, $subtotal, $total, $iva, $descuento, $costoInstalacion, $estatus) {

  // Consulta SQL
  $sql = "UPDATE cotizaciones
          SET fecha = :fecha,
              observaciones = :observaciones,
              idSolicitudCotizacion = :idSolicitudCotizacion,
              descripcion = :descripcion,
              subtotal = :subtotal,
              total = :total,
              iva = :iva,
              descuento = :descuento,
              costo_instalacion = :costo_instalacion,
              estatus = :estatus
          WHERE idCotizacion = :idCotizacion";

  // Parámetros para la consulta preparada
  $parametros = array(
      ':idCotizacion' => $idCotizacion,
      ':fecha' => $fecha,
      ':observaciones' => $observaciones,
      ':idSolicitudCotizacion' => $idSolicitudCotizacion,
      ':descripcion' => $descripcion,
      ':subtotal' => $subtotal,
      ':total' => $total,
      ':iva' => $iva,
      ':descuento' => $descuento,
      ':costo_instalacion' => $costoInstalacion,
      ':estatus' => $estatus
  );

  // Ejecutar la consulta
  $resultado = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);

return $resultado;
}


  function email($emailCliente, $razonSocial, $nombre) {
    // Contenido HTML para el correo electrónico
    $contenidoHTML = "
        <html>
        <head>
            <title>Cotización de Servicio</title>
        </head>
        <body>
            <p>Estimado(a) $nombre,</p>
            <p>Su cotización del servicio ha sido actualizada.</p>
            <p>Por favor, ingrese al sitio web de GolemSistem para ver su cotización actualizada  y aceptarla si es de su interés.</p>
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

