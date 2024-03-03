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


$consulta = new CotizacionModel();
$validacion = true;
$response = array();

$id = DataSanitizer::sanitize_input($_POST['id']);
$fecha = DataSanitizer::sanitize_input($_POST['fecha']);
$observaciones = DataSanitizer::sanitize_input($_POST['observaciones']);
$idCliente = DataSanitizer::sanitize_input($_POST['idCliente']);
$descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
$cantidad = DataSanitizer::sanitize_input($_POST['cantidad']);
$precioUnitario = DataSanitizer::sanitize_input($_POST['precioUnitario']);
$importeTotal = DataSanitizer::sanitize_input($_POST['importeTotal']);
$idProducto = DataSanitizer::sanitize_input($_POST['idProducto']);
$idServicio = DataSanitizer::sanitize_input($_POST['idServicio']);
$idCatalogoCotizaciones = DataSanitizer::sanitize_input($_POST['idCatalogoCotizaciones']);

$data = [$id, $fecha, $observaciones, $idCliente, $descripcion,
    $cantidad, $precioUnitario, $importeTotal,
    $idProducto, $idServicio, $idCatalogoCotizaciones];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
    }else{
      
      $date = $fecha; 
    $messageDate = 'Fecha no válida. Formato: Y-m-d';
    $response = DataValidator::validateDateForMySQL($date, $messageDate);
    
    if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }
  
    $datos_string_letras = [$descripcion, $observaciones];
      $messageLetters = "Ingrese solo letras en el dato";
     $response = DataValidator::validateLettersOnlyArray($datos_string_letras, $messageLetters);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }

    $datos_string_lonlitud = [$descripcion, $observaciones];
      $messageLength = "El dato debe tener más de 8  y menos de 120 letras";
     $response = DataValidator::validateLengthInArray($datos_string_lonlitud, 8, 120, $messageLength);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }

    $datos_int = [$idCliente, $idProducto, $idServicio, $idCatalogoCotizaciones];
      $messageNumbers = "Ingrese solo numero sin decimal en el dato";
     $response = DataValidator::validateNumbersOnlyArray($datos_int, $messageNumbers);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }

    $datos_float = [$cantidad, $precioUnitario, $importeTotal];
    $messageNumbresFloat = "Ingrese solo numero, puede ser decimal en el dato";
   $response = DataValidator::validateNumbersFloat($datos_float, $messageNumbresFloat);
   if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }
      
    if($validacion == true){//Si es true

        $result = $consulta->updateCotizacion($id, $fecha, $observaciones, $idCliente, $descripcion,
        $cantidad, $precioUnitario, $importeTotal, $idProducto, $idServicio, $idCatalogoCotizaciones);

           if($result == true){
            $response = array("success" => true, 'message' => 'Se actualizaron los datos del servicio!');
           }else{
            $response = array('success' => false, 'message' => 'No se pudo actualizar los datos del servicio');
           }
 }

}

// Return response as JSON
echo json_encode($response);
 

