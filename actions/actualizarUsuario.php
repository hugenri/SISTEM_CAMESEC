<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}





include_once '../model/UsuarioModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';

$consulta = new UsuarioModel();
$validacion = true;
$response = array();

    $email = DataSanitizer::sanitize_input($_POST['email']);
    $nombre = DataSanitizer::sanitize_input($_POST['nombre']);
    $apellidoP = DataSanitizer::sanitize_input($_POST['apellidoPaterno']);
    $apellidoM = DataSanitizer::sanitize_input($_POST['apellidoMaterno']);
    $id = DataSanitizer::sanitize_input($_POST['id']);
    $rol = DataSanitizer::sanitize_input($_POST['rol']);

    $data = [$nombre, $apellidoP, $apellidoM, $email, $id, $rol];

    //si se envia formulario sin datos se marca un error

    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
    }else{

 $messageLetters = "Ingrese letras unicamente en";
 
 $datos = [$nombre. $apellidoP, $apellidoM, $rol];
      $messageLetters = "Ingrese solo letras en el dato";
     $response = DataValidator::validateLettersOnlyArray($datos, $messageLetters);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }


 $messageLength = "No es válida longitud del dato";
 $response = DataValidator::validateLength($rol, 5, 10, $messageLength);
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
        $result = $consulta->updateUser($id, $nombre, $apellidoP, $apellidoM, $email, strtolower($rol));

           if($result == true){
            $response = array("success" => true, 'message' => 'Se actualizaron los datos del usuario!');
           }else{
            $response = array('success' => false, 'message' => 'No se pudo actualizar los datos del usuario');
           }
 }

}

// Return response as JSON
echo json_encode($response);



