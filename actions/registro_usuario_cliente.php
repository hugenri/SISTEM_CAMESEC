<?php


require_once '../model/ClienteModel.php';
require_once '../clases/dataSanitizer.php';
require_once '../clases/DataValidator.php';
require_once '../clases/ReCaptcha.php';
require_once '../clases/email.php';
require_once '../clases/clave.php';

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
  $nombre = DataSanitizer::sanitize_input($_POST['nombre']);
  $apellidoP = DataSanitizer::sanitize_input($_POST['apellidoPaterno']);
  $apellidoM = DataSanitizer::sanitize_input($_POST['apellidoMaterno']);
  $otrosDetalles = 'sin detalles';

  $reCaptchaToken = $_POST['RCtoken']; //se obtiene el  token recaptcha
  $reCaptchaAction = $_POST['RCaction']; //se obtiene el  action del token recaptcha

$data = [$nombre, $apellidoP, $apellidoM, $email, $telefono, $infoContacto,
            $calle, $numero, $colonia,$municipio, $estado, $cp, $otrosDetalles];
    
        // Verificar si el ReCAPTCHA es válido
if (!ReCaptchaVerifier::verify($reCaptchaToken, $reCaptchaAction)) {
  $validacion = false;
  handleResponse(false, 'El  reCAPTCHA no es válido');
}        
    //si se envia formulario sin datos se marca un error
 if(DataValidator::validateVariables($data) === false){
      $validacion = false;
      handleResponse(false, "Faltan datos en el formulario");
    }
      
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
      response($response);

    }
    $datos = [$calle, $colonia];
    $messageLength = "El dato debe tener más de 3 caracteres y menos de 30";
   $response = DataValidator::validateLengthInArray($datos, 3, 30, $messageLength);
   if ($response !== true) {
    $validacion = false;
    response($response);

  }
    $datos = [$numero, $cp];
    $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumbersOnlyArray($datos, $messageLetters);
   if ($response !== true) {
    $validacion = false;
    response($response);

  }

      $messageEmail = "La dirección de correo electrónico no es válida";
      $response = DataValidator::validateEmail($email, $messageEmail);
      if ($response !== true) {
        $validacion = false;
        response($response);

      }
      $result = $consulta->clientExists($email);
          if($result == true){
            $validacion == false;
          handleResponse(false, "Existe un usuario registrado! No se puede realizar el registro!");

        }
  $messageTelefono = "¡Ingrese un número de teléfono valido! Numero de diez dígitos.";
 $response = DataValidator::validatePhoneNumber($telefono, $messageTelefono);
 if ($response !== true) {
   $validacion = false;
   response($response);
 }
        
      if($validacion == true){//Si devuelve true, significa que el reCAPTCHA es válido y se puede continuar con el procesamiento del formulario
        $claveGenerada = new Clave();
       $password = $claveGenerada->generarClave();
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $consulta->createClient($razonSocial, $nombre, $apellidoP, $apellidoM, $infoContacto, $calle, $numero, $colonia, 
         $municipio, $estado, $cp, $email, $telefono, $otrosDetalles, $hashPassword);

         if($result === true){
               handleResponse(true, 'Cliente registrado con exito!');
         }else{
                handleResponse(false, 'Error en el registro');
         }
         } 

function handleResponse($success, $message) {
  $response = ['success' => $success, 'message' => $message];
  echo json_encode($response);
  exit();
}
function response($response) {
  echo json_encode($response);
  exit();
}

/*
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../model/UsuarioModel.php';
include_once '../clases/ReCaptcha.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/email.php';
include_once '../clases/clave.php';


$registro = new UsuarioModel();
$validacion = true;
$response = array();

    $nombre = DataSanitizer::sanitize_input($_POST['nombre']);
    $apellidoP = DataSanitizer::sanitize_input($_POST['apellidoPaterno']);
    $apellidoM = DataSanitizer::sanitize_input($_POST['apellidoMaterno']);
    $email = DataSanitizer::sanitize_input($_POST['email']);


    $reCaptchaToken = $_POST['RCtoken']; //se obtiene el  token recaptcha
    $reCaptchaAction = $_POST['RCaction']; //se obtiene el  action del token recaptcha

    $data = [$nombre, $apellidoP, $apellidoM, $email];

    

    //si se envia formulario sin datos se marca un error

    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');

    }else{

   //se verifica el token de reCAPTCHA con la acción recibida por POST

   if (ReCaptchaVerifier::verify($reCaptchaToken, $reCaptchaAction)) {

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

    

     if($validacion == true){//Si devuelve true, significa que el reCAPTCHA es válido y se puede continuar con el procesamiento del formulario
         $datos= $registro->verifyUserExists($nombre, $apellidoP, $apellidoM, $email);

         if(!empty($datos)){

         $response = array('success' => false, 'message' => 'Existe un usuario registrado! No se puede realizar el registro!');

		 }else{
      $claveGenerada = new Clave();
       $password = $claveGenerada->generarClave();
            $hash = password_hash($password, PASSWORD_DEFAULT);

        $resultado = $registro->createUser($nombre, $apellidoP, $apellidoM, $email, $hash);
        if($resultado === true){
          $enlaceAcceso = 'https://golemsiseg.com/sesion.php';
             // Después de la inserción exitosa en la base de datos
            $correoElectronico = new CorreoElectronico();
             $envioPassword = $correoElectronico->enviarCorreoRegistroExitoso($email, $nombre, $password, $enlaceAcceso);
             if ($envioPassword) {
              $response = array("success" => true, 'message' => 'Usuario registrado con éxito. Se ha enviado un correo electrónico.');
          } else {
              $response = array('success' => true, 'message' => 'Usuario registrado con éxito. No se pudo enviar el correo electrónico.');
          }        }else{
               $response = array('success' => false, 'message' => 'Error en el registro');
        }

       }
    }

}else {
        // Código a ejecutar si el reCAPTCHA no es válido
        $response = array('success' => false, 'message' => 'El  reCAPTCHA no es válido');
    }
    
 }
 
 
 $response = array("success" => true, 'message' => 'Usuario registrado con éxito. Se ha enviado un correo electrónico.');

// Return response as JSON
echo json_encode($response);
*/