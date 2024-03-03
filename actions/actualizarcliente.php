<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}


include_once '../model/ClienteModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';

$consulta = new ClienteModel();
$validacion = true;
$response = array();


  
$id = DataSanitizer::sanitize_input($_POST['id']);    
$razonSocial = DataSanitizer::sanitize_input($_POST['razonSocial']);
$email = DataSanitizer::sanitize_input($_POST['email']);
$telefono = DataSanitizer::sanitize_input($_POST['telefono']);
$infoContacto = DataSanitizer::sanitize_input($_POST['informacionContacto']);
$calle = DataSanitizer::sanitize_input($_POST['calle']);
$numero = DataSanitizer::sanitize_input($_POST['numero']);
$colonia = DataSanitizer::sanitize_input($_POST['colonia']);
$municipio = DataSanitizer::sanitize_input($_POST['municipio']);
$estado = DataSanitizer::sanitize_input($_POST['estado']);
$cp = DataSanitizer::sanitize_input($_POST['cp']);
$otrosDetalles = DataSanitizer::sanitize_input($_POST['otrosDetalles']);
$nombre = DataSanitizer::sanitize_input($_POST['nombre']);
$apellidoP = DataSanitizer::sanitize_input($_POST['apellidoPaterno']);
$apellidoM = DataSanitizer::sanitize_input($_POST['apellidoMaterno']);


$data = [$nombre, $apellidoP, $apellidoM, $email, $telefono, $infoContacto,
$calle, $numero, $colonia,$municipio, $estado, $cp, $otrosDetalles];

    //si se envia formulario sin datos se marca un error
if(DataValidator::validateVariables($data) === false){
      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
}else{

  $datos = [$nombre. $apellidoP, $apellidoM, $municipio, $estado];
      $messageLetters = "Ingrese solo letras en el dato";
     $response = DataValidator::validateLettersOnlyArray($datos, $messageLetters);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }

    $datos = [$nombre, $apellidoP, $apellidoM, $municipio, $estado];
      $messageLength = "El dato debe tener más de 3 caracteres y menos de 25";
     $response = DataValidator::validateLengthInArray($datos, 3, 25, $messageLength);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }
	
	$datos = [$calle, $colonia];
    $messageLength = "El dato debe tener más de 3 caracteres y menos de 30";
   $response = DataValidator::validateLengthInArray($datos, 3, 30, $messageLength);
   if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }
  
    $datos = [$numero, $cp];
    $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumbersOnlyArray($datos, $messageLetters);
   if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }

      $messageEmail = "La dirección de correo electrónico no es válida";
      $response = DataValidator::validateEmail($email, $messageEmail);
      if ($response !== true) {
        $validacion = false;
          echo json_encode($response);
          exit();
      }
      
     $messageTelefono = "¡Ingrese un número de teléfono valido! Numero de diez dígitos.";
     $response = DataValidator::validatePhoneNumber($telefono, $messageTelefono);
     if ($response !== true) {
     $validacion = false;
     echo json_encode($response);
     exit();
     }
     
     if($validacion == true){//Si devuelve true, significa que el reCAPTCHA es válido y se puede continuar con el procesamiento del formulario
        $result = $consulta->updateClient($id, $razonSocial, $nombre, $apellidoP, $apellidoM, 
                                             $infoContacto,  $numero, $calle, $colonia, 
                                               $municipio, $estado, $cp, $email, $telefono,
                                               $otrosDetalles);

           if($result == true){
            $response = array("success" => true, 'message' => 'Se actualizaron los datos del cliente!');
           }else{
            $response = array('success' => false, 'message' => 'No se pudo actualizar los datos del cliente');
           }
 }

}

// Return response as JSON
echo json_encode($response);
 

