<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}



include_once '../model/AdminModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';

$consulta = new adminModel();
$validacion = true;
$response = null;

    $email = DataSanitizer::sanitize_input($_POST['email']);
    $password = DataSanitizer::sanitize_input($_POST['password']);
    $passwordC = DataSanitizer::sanitize_input($_POST['passwordC']);
    $nombre = DataSanitizer::sanitize_input($_POST['nombre']);
    $apellidoP = DataSanitizer::sanitize_input($_POST['apellidoPaterno']);
    $apellidoM = DataSanitizer::sanitize_input($_POST['apellidoMaterno']);

   

   $data = [$nombre, $apellidoP, $apellidoM, $email, $password, $passwordC];

    //si se envia formulario sin datos se marca un error

    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
    }else{

      $datos = [$nombre. $apellidoP, $apellidoM];
      $messageLetters = "Ingrese solo letras en el dato";
     $response = DataValidator::validateLettersOnlyArray($datos, $messageLetters);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }

    $datos = [$nombre, $apellidoP, $apellidoM];
      $messageLength = "El dato debe tener más de 3 caracteres y menos de 25";
     $response = DataValidator::validateLengthInArray($datos, 3, 25, $messageLength);
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

  $mesagePass = "La contraseña no cumple con el formato: letras minúsculas, mayúsculas, números y caracteres especiales. Mayor a 20  y menor a 8 caracteres.";
  $response = DataValidator::validateFormatPassword($password, 8, 20, $mesagePass);
  if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }

  $mesageConfir = "La contraseña no coincide  con la confirmación";
  $response = DataValidator::compareStrings($password, $passwordC, $mesageConfir);

  if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }

  

      if($validacion == true){//Si devuelve true, significa que el reCAPTCHA es válido y se puede continuar con el procesamiento del formulario
          $result = $consulta->userExists($email);

          if($result == true){

          $response = array('success' => false, 'message' => 'Existe un usuario registrado! No se puede realizar el registro!');

      }else{

             $hash = password_hash($password, PASSWORD_DEFAULT);

         $result = $consulta->createAdmin($nombre, $apellidoP, $apellidoM, $email, $hash , 'admin');

         if($result === true){
               $response = array("success" => true, 'message' => 'Administrador registrado con exito!');

         }else{
                $response = array('success' => false, 'message' => 'Error en el registro');

         }

        }

     }

  }

 // Return response as JSON

 echo json_encode($response);

 

 

