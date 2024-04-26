<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
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


$data = [$email, $password, $passwordC ];

//si se envia formulario sin datos se marca un error

if(DataValidator::validateVariables($data) === false){

  $response = array('success' => false, 'message' => 'Faltan datos en el formulario');



}else{

  

  $messageEmail = "La dirección de correo electrónico no es válida";

  $response = DataValidator::validateEmail($email, $messageEmail);

  if ($response !== true) {

    $validacion = false;

      echo json_encode($response);

      exit();

  }
 $sql = "SELECT * FROM cliente WHERE email = :email;";
 $parametros = array(

    'email' => $email,

);
// Ejecutar la consulta
$consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');

        if(empty($consulta)){

            // Si el usuario no existe 

           $response = array('success' => false, 'message' => 'Cliente no registrado');

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

       $newPassword = password_hash($password, PASSWORD_DEFAULT); // Hasheo de la nueva contraseña
       $sql =  "UPDATE cliente
       SET password = :newpassword
       WHERE email = :email;";

       $parametros = array(

        'email' => $email,
        ':newpassword' => $newPassword,
       
    
    );
    // Ejecutar la consulta
    $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);

           if($consulta == true){

            $response = array("success" => true, 'message' => 'Se restableció la contraseña con éxito!');



           }else{

            $response = array('success' => false, 'message' => 'No se pudo restablecer la contraseña');



           }

        }



 

}



// Return response as JSON

echo json_encode($response);



