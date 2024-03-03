<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/ServicioModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';

$consulta = new ServicioModel();
$validacion = true;
$response = null;

  $nombre = DataSanitizer::sanitize_input($_POST['nombre']);
  $descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
  $tarifa = DataSanitizer::sanitize_input($_POST['tarifa']);
  $disponibilidad = DataSanitizer::sanitize_input($_POST['disponibilidad']);
  $idCotizacion = DataSanitizer::sanitize_input($_POST['idCotizacion']);
  $idRequisicion = DataSanitizer::sanitize_input($_POST['idRequisicion']);
  $idOrdenCompra = DataSanitizer::sanitize_input($_POST['idOrdenCompra']);

   $data = [$nombre, $descripcion, $tarifa, $disponibilidad, $idCotizacion,
            $idRequisicion, $idOrdenCompra];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
    }else{
      
    $datos = [$nombre, $descripcion, $disponibilidad];
    $messageLetters = "Ingrese solo letras en el dato";
     $response = DataValidator::validateLettersOnlyArray($datos, $messageLetters);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }
    
    $datos = [$nombre, $disponibilidad];
    $messageLength = "El dato debe tener entre 5 y 30 letras";
     $response = DataValidator::validateLengthInArray($datos, 5, 30, $messageLength);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }

    $messageLength = "El dato debe tener entre 8 y 150 letras";
    $response = DataValidator::validateLength($descripcion, 8, 150, $messageLength);
    if ($response !== true) {
     $validacion = false;
       echo json_encode($response);
       exit();
   }
    $datos = [$idCotizacion, $idOrdenCompra, $idOrdenCompra];
    $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumbersFloat($datos, $messageLetters);
   if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }
  
  
    $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumberFloat($tarifa, $messageLetters);
   if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }

      if($validacion == true){//Si es true,  se puede continuar 

        $result = $consulta->createService($nombre, $descripcion, $tarifa, $disponibilidad,
                                             $idCotizacion, $idRequisicion, $idOrdenCompra);
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

