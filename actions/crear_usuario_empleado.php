<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

require_once '../clases/Response_json.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';


$respuesta_json = new ResponseJson();

$response = array();
$validacion = true;


$email = DataSanitizer::sanitize_input($_POST['email']);
$password = DataSanitizer::sanitize_input($_POST['password']);
$passwordC = DataSanitizer::sanitize_input($_POST['passwordC']);
$nombre = DataSanitizer::sanitize_input($_POST['nombre']);
$apellidoP = DataSanitizer::sanitize_input($_POST['apellidoPaterno']);
$apellidoM = DataSanitizer::sanitize_input($_POST['apellidoMaterno']);
$rol_usuario = DataSanitizer::sanitize_input($_POST['rolUsuario']);

$data = [$nombre, $apellidoP, $apellidoM, $email, $password, $passwordC];

//si se envia formulario sin datos se marca un error

if(DataValidator::validateVariables($data) === false){
    
        $respuesta_json->handle_response_json(false, 'Faltan datos');
        
     } 
        
       

$datos = [$nombre. $apellidoP, $apellidoM];
$messageLetters = "Ingrese solo letras en el dato";
$response = DataValidator::validateLettersOnlyArray($datos, $messageLetters);
if ($response !== true) {
$validacion = false;
$respuesta_json->response_json($response);

}

$datos = [$nombre, $apellidoP, $apellidoM];
$messageLength = "El dato debe tener más de 3 caracteres y menos de 25";
$response = DataValidator::validateLengthInArray($datos, 3, 25, $messageLength);
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

$mesagePass = "La contraseña no cumple con el formato: letras minúsculas, mayúsculas, números y caracteres especiales. Mayor a 20  y menor a 8 caracteres.";
$response = DataValidator::validateFormatPassword($password, 8, 20, $mesagePass);
if ($response !== true) {
$validacion = false;
$respuesta_json->response_json($response);

}

$mesageConfir = "La contraseña no coincide  con la confirmación";
$response = DataValidator::compareStrings($password, $passwordC, $mesageConfir);

if ($response !== true) {
$validacion = false;
$respuesta_json->response_json($response);

}
if($validacion == true){

    $sql = "SELECT * FROM usuarios WHERE email = :email;";

$parametros = array(
 ':email' => $email
);
// Ejecutar la consulta
$consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');

  if(!empty($consulta)){
    $respuesta_json->handle_response_json(false, 'Existe un usuario registrado con el email!');

  }
   $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, apellidoPaterno, apellidoMaterno, rol_usuario, email, password)
       VALUES (:nombre, :apellidoPaterno, :apellidoMaterno, :rol_usuario, :email, :password);";

$parametros = array(

    ':nombre' => $nombre,
    ':apellidoPaterno' => $apellidoP,
    ':apellidoMaterno' => $apellidoM,
    ':rol_usuario' => $rol_usuario,
    ':email' => $email,
    ':password' =>  $hash_password

);
// Ejecutar la consulta
$consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);

if($consulta){
    $respuesta_json->handle_response_json(true, 'Usuario registrado correctamente!');

} else {
    $respuesta_json->handle_response_json(false, 'No su pudo registrar el usuario!');
}
}