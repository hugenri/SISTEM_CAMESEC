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

$reCaptchaToken = $_POST['RCtoken']; //se obtiene el  token recaptcha
$reCaptchaAction = $_POST['RCaction']; //se obtiene el  action del token recaptcha

    $email = DataSanitizer::sanitize_input($_POST['email']);
    $password = DataSanitizer::sanitize_input($_POST['password']);

    $data = [$email, $password];

    //si se envia formulario sin datos se marca un error

    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');

    

    }else{

      if (ReCaptchaVerifier::verify($reCaptchaToken, $reCaptchaAction)) {

        $messageEmail = "La dirección de correo electrónico no es válida";

        $response = DataValidator::validateEmail($email, $messageEmail);

        if ($response !== true) {
          $validacion = false;
            echo json_encode($response);
            exit();
        }

        $result = $consulta->userExists($email);
        if($result != true){
            // Si el usuario no existe o la contraseña es incorrecta
           $response = array('success' => false, 'message' => 'Usuario no registrado');
           $validacion = false;
           echo json_encode($response);
           exit();
          }

     if($validacion == true){//Si devuelve true, significa que el reCAPTCHA es válido y se puede continuar con el procesamiento del formulario
		$datos = $consulta->login($email); // Realiza la consulta SQL a MySQL para obtener los datos del usuario por su correo electrónico

if (!empty($datos) && password_verify($password, $datos['password'])) {

   // Si el usuario existe y la contraseña proporcionada coincide con el hash almacenado en la base de datos
	$sessionData = array(
        'nombre' => $datos['nombre'],
        'apellidoPaterno' => $datos['apellidoPaterno'],
        'apellidoMaterno' => $datos['apellidoMaterno'],
        'rol_usuario' => $datos['rol_usuario']
        );
        
        $session->startSessionData($sessionData);
        $site = $session->checkAndRedirect();
          $response = array('success' => true, 'url' => $site);

}else{
    $response = array('success' => false, 'message' => 'Contraseña incorrecta');

} 
	 } 

}else {

    // Código a ejecutar si el reCAPTCHA no es válido
    $response = array('success' => false, 'message' => 'El  reCAPTCHA no es válido');

}

    }

//header('Content-Type: application/json; charset=utf-8');

// Return response as JSON
echo json_encode($response);





