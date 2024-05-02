<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
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

include_once '../model/ServicioModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';

$consulta = new ServicioModel();
$validacion = true;
$response = null;


  $fecha = DataSanitizer::sanitize_input($_POST['fecha']);
  $idEmpleado = DataSanitizer::sanitize_input($_POST['responsable']);
  $detalles = DataSanitizer::sanitize_input($_POST['detalles']);
  $idOrdenCompra = DataSanitizer::sanitize_input($_POST['idOrdenCompra']);
  $estado = 'en curso';
  

   $data = [$fecha, $detalles, $idOrdenCompra, $idEmpleado];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
      echo json_encode($response);
       exit();
    }else{
      
      $date = $fecha; 
      $messageDate = 'Fecha no válida. Formato: Y-m-d';
      $response = DataValidator::validateDateForMySQL($date, $messageDate);
      
      if ($response !== true) {
        $validacion = false;
        echo json_encode($response);
        exit();

      }
    

    $messageLength = "El dato debe tener entre 8 y 150 letras";
    $response = DataValidator::validateLength($detalles, 8, 150, $messageLength);
    if ($response !== true) {
     $validacion = false;
       echo json_encode($response);
       exit();
   }
    $datos = [$idEmpleado, $idOrdenCompra];
    $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumbersOnlyArray($datos, $messageLetters);
   if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }
  
  

      if($validacion == true){//Si es true,  se puede continuar 

        $result = $consulta->createService($fecha, $detalles, $idEmpleado, $estado, $idOrdenCompra);
        $result = true;
         if($result === true){
             $response = array("success" => true, 'message' => 'Servicio registrado con exito!');
         }else{
                $response = array('success' => false, 'message' => 'Error en el registro');

         }
     }
  }

 // Return response as JSON
echo json_encode($response);

