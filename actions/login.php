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

$consulta = new UsuarioModel();
$validacion = true;
$response = array();
$dataUser = '';
$dataCliente = '';

$reCaptchaToken = $_POST['RCtoken']; //se obtiene el  token recaptcha
$reCaptchaAction = $_POST['RCaction']; //se obtiene el  action del token recaptcha

    $email = DataSanitizer::sanitize_input($_POST['email']);
    $password = DataSanitizer::sanitize_input($_POST['password']);

    $data = [$email, $password];

    //si se envia formulario sin datos se marca un error

    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
      $validacion = false;
      echo json_encode($response);
      exit();
    }

     if (ReCaptchaVerifier::verify($reCaptchaToken, $reCaptchaAction)) {

        $messageEmail = "La dirección de correo electrónico no es válida";
        $response = DataValidator::validateEmail($email, $messageEmail);

        if ($response !== true) {
          $validacion = false;
            echo json_encode($response);
            exit();
        }
          // Consulta para usuarios
         $sqlUser = "SELECT * FROM usuarios WHERE email = :email;";
         $dataUser = $consulta->login($sqlUser, $email);

        // Consulta para clientes
        $sqlCliente = "SELECT * FROM cliente WHERE email = :email;";
        $dataCliente = $consulta->login($sqlCliente, $email);

        // Verificar si alguno de los conjuntos de datos contiene al usuario
        if (!empty($dataCliente) || !empty($dataUser)) {
         if($validacion == true){ //se puede continuar 
		   
          if (!empty($dataUser)) {
          if(!password_verify($password, $dataUser['password'])){
            $response = array('success' => false, 'message' => 'Contraseña incorrecta');
            echo json_encode($response);
           exit();
          }
       // Si el usuario existe y la contraseña proporcionada coincide con el hash almacenado en la base de datos
      $sessionData = array(
      'nombre' => $dataUser['nombre'],
      'apellidoPaterno' => $dataUser['apellidoPaterno'],
      'apellidoMaterno' => $dataUser['apellidoMaterno'],
      'rol_usuario' => $dataUser['rol_usuario']
      );
      
      $session->startSessionData($sessionData);
      $site = $session->checkAndRedirect();
        $response = array('success' => true, 'url' => $site);
        echo json_encode($response);
       exit();

   }
    
    if (!empty($dataCliente)) {
    if(!password_verify($password, $dataCliente['password'])){
            $response = array('success' => false, 'message' => 'Contraseña incorrecta');
            echo json_encode($response);
           exit();
          }
      // Si el usuario existe y la contraseña proporcionada coincide con el hash almacenado en la base de datos
     $sessionData = array(
      'id' => $dataCliente['idCliente'],
     'nombre' => $dataCliente['nombre'],
     'apellidoPaterno' => $dataCliente['apellidoPaterno'],
     'apellidoMaterno' => $dataCliente['apellidoMaterno'],
     'rol_usuario' => 'cliente'
     );
     
     $session->startSessionData($sessionData);
     $site = $session->checkAndRedirect();
       $response = array('success' => true, 'url' => $site);
       echo json_encode($response);
      exit();

      }else{
          $response = array('success' => false, 'message' => 'Contraseña incorrecta');
          echo json_encode($response);
        exit();
       } 
   
      } 
    }else {
    // Si el usuario no está registrado en ninguna de las tablas
    $response = array('success' => false, 'message' => 'Usuario no registrado');
    $validacion = false;
    echo json_encode($response);
    exit();
     }

  }else {
    // Código a ejecutar si el reCAPTCHA no es válido
    $response = array('success' => false, 'message' => 'El  reCAPTCHA no es válido');
    echo json_encode($response);
   exit();
  }




