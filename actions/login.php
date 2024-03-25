<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
$site = $session->checkAndRedirect();
if($session->getSessionVariable('rol_usuario') == 'admin' || $session->getSessionVariable('rol_usuario') == 'usuario' ){

  header('location:' . $site);
}


include_once '../model/UsuarioModel.php';
include_once '../clases/ReCaptcha.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/Login_functions.php';


$consulta = new UsuarioModel();
$function = new Login_functions();
$validacion = true;
$response = array();
$dataUser = '';
$dataCliente = '';

$reCaptchaToken = $_POST['RCtoken']; //se obtiene el  token recaptcha
$reCaptchaAction = $_POST['RCaction']; //se obtiene el  action del token recaptcha

    $email = DataSanitizer::sanitize_input($_POST['email']);
    $password = DataSanitizer::sanitize_input($_POST['password']);

    $data = [$email, $password];

    // Validar los datos del formulario
if (!DataValidator::validateVariables($data)) {
  $function->handleError('Faltan datos en el formulario');
}

     // Verificar si el ReCAPTCHA es válido
if (!ReCaptchaVerifier::verify($reCaptchaToken, $reCaptchaAction)) {
  $function->handleError('El ReCAPTCHA no es válido');
   }
    
      // Validar el formato del correo electrónico
      if (!DataValidator::validateEmail($email, 'error')) {
        $function->handleError('La dirección de correo electrónico no es válida');
      }
      
      // Consultar la base de datos para usuarios y clientes
      $dataUser = $consulta->login("SELECT * FROM usuarios WHERE email = :email", $email);
      $dataCliente = $consulta->login("SELECT * FROM cliente WHERE email = :email", $email);
      
   // Verificar si alguno de los conjuntos de datos contiene al usuario
   if (!empty($dataCliente) || !empty($dataUser)) {
      // Autenticar al usuario
      $function->authenticateUser($dataUser, $dataCliente, $password);
} else {
  // Si el usuario no está registrado en ninguna de las tablas
  $function->handleError('Usuario no registrado');
}

