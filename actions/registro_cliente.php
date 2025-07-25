<?php
header("Content-Type: application/json");

require_once '../model/ClienteModel.php';
require_once '../clases/dataSanitizer.php';
require_once '../clases/DataValidator.php';
require_once '../clases/ReCaptcha.php';
require_once '../clases/email.php';

$consulta = new ClienteModel();
$validacion = true;
$response = null;


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
  $otrosDetalles = 'ningun detalle';
  $nombre = DataSanitizer::sanitize_input($_POST['nombre']);
  $apellidoP = DataSanitizer::sanitize_input($_POST['apellidoPaterno']);
  $apellidoM = DataSanitizer::sanitize_input($_POST['apellidoMaterno']);
  $password = DataSanitizer::sanitize_input($_POST['password']);

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
      $result = $consulta->clientExists($email);
          if($result == true){
            $validacion == false;
          $response = array('success' => false, 'message' => 'Existe un usuario registrado! No se puede realizar el registro!');
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
 $mesagePass = "La contraseña no cumple con el formato: letras minúsculas, mayúsculas, números y caracteres especiales. Mayor a 20  y menor a 8 caracteres.";
  $response = DataValidator::validateFormatPassword($password, 8, 20, $mesagePass);
  if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }
        
      if($validacion == true){
        $claveGenerada = new Clave();
      
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $consulta->createClient($razonSocial, $nombre, $apellidoP, $apellidoM, $infoContacto, $calle, $numero, $colonia, 
         $municipio, $estado, $cp, $email, $telefono, $otrosDetalles, $hashPassword);

         if($result === true){
               $response = array("success" => true, 'message' => 'Cliente registrado con exito!');
         }else{
                $response = array('success' => false, 'message' => 'Error en el registro');

         }
     }
  }

 // Return response as JSON
echo json_encode($response);



