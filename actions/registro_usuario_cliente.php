<?php


require_once '../model/ClienteModel.php';
require_once '../clases/dataSanitizer.php';
require_once '../clases/DataValidator.php';
require_once '../clases/ReCaptcha.php';
require_once '../clases/email.php';
require_once '../clases/clave.php';
require_once '../clases/Response_json.php';

$consulta = new ClienteModel();
$validacion = true;
$respuesta_json = new ResponseJson();


  $razonSocial = DataSanitizer::sanitize_input($_POST['razonSocial']);
  $email = DataSanitizer::sanitize_input($_POST['email']);
  $telefono = DataSanitizer::sanitize_input($_POST['telefono']);
  $calle = DataSanitizer::sanitize_input($_POST['calle']);
  $numero = DataSanitizer::sanitize_input($_POST['numero']);
  $colonia = DataSanitizer::sanitize_input($_POST['colonia']);
  $municipio = DataSanitizer::sanitize_input($_POST['municipio']);
  $estado = DataSanitizer::sanitize_input($_POST['estado']);
  $cp = DataSanitizer::sanitize_input($_POST['cp']);
  $nombre = DataSanitizer::sanitize_input($_POST['nombre']);
  $apellidoP = DataSanitizer::sanitize_input($_POST['apellidoPaterno']);
  $apellidoM = DataSanitizer::sanitize_input($_POST['apellidoMaterno']);

  $reCaptchaToken = $_POST['RCtoken']; //se obtiene el  token recaptcha
  $reCaptchaAction = $_POST['RCaction']; //se obtiene el  action del token recaptcha



$data = [$nombre, $apellidoP, $apellidoM, $email, $telefono,
            $calle, $numero, $colonia,$municipio, $estado, $cp];
   
        // Verificar si el ReCAPTCHA es válido
if (!ReCaptchaVerifier::verify($reCaptchaToken, $reCaptchaAction)) {
  $validacion = false;
  $respuesta_json->handle_response_json(false, 'El  reCAPTCHA no es válido');
} 
   
    //si se envia formulario sin datos se marca un error
 if(DataValidator::validateVariables($data) === false){
      $validacion = false;
      $respuesta_json->handle_response_json(false, "Faltan datos en el formulario");
    }
      
      $datos = [$nombre. $apellidoP, $apellidoM, $municipio, $estado];
      $messageLetters = "Ingrese solo letras en el dato";
     $response = DataValidator::validateLettersOnlyArray($datos, $messageLetters);
     if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);
    }

    $datos = [$nombre, $apellidoP, $apellidoM, $municipio, $estado];
      $messageLength = "El dato debe tener más de 3 caracteres y menos de 25";
     $response = DataValidator::validateLengthInArray($datos, 3, 25, $messageLength);
     if ($response !== true) {
      $validacion = false;
      $respuesta_json->response_json($response);

    }
    $datos = [$calle, $colonia];
    $messageLength = "El dato debe tener más de 3 caracteres y menos de 30";
   $response = DataValidator::validateLengthInArray($datos, 3, 30, $messageLength);
   if ($response !== true) {
    $validacion = false;
    $respuesta_json->response_json($response);

  }
    $datos = [$numero, $cp];
    $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumbersOnlyArray($datos, $messageLetters);
   if ($response !== true) {
    $validacion = false;
    $respuesta_json->response_json($response);

  }

      $messageEmail = "La dirección de correo electrónico no es válida";
      $response = DataValidator::validateEmail($email, $messageEmail);
      if ($response !== true) {
        $validacion = false;
        $respuesta_json->response_json($response);

      }
      $result = $consulta->clientExists($email);
          if($result == true){
            $validacion == false;
            $respuesta_json->handle_response_json(false, "Existe un usuario registrado! No se puede realizar el registro!");

        }
  $messageTelefono = "¡Ingrese un número de teléfono valido! Numero de diez dígitos.";
 $response = DataValidator::validatePhoneNumber($telefono, $messageTelefono);
 if ($response !== true) {
   $validacion = false;
   $respuesta_json->response_json($response);
 }
        
      if($validacion == true){//Si devuelve true, significa que el reCAPTCHA es válido y se puede continuar con el procesamiento del formulario
        $claveGenerada = new Clave();
       $password = $claveGenerada->generarClave();
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $consulta->createClient($razonSocial, $nombre, $apellidoP, $apellidoM, $calle, $numero, $colonia, 
         $municipio, $estado, $cp, $email, $telefono, $hashPassword);

         if($result === true){
          $respuesta_json->handle_response_json(true, 'Cliente registrado con exito!');
         }else{
          $respuesta_json->handle_response_json(false, 'Error en el registro');
         }
         } 


