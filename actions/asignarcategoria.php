<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/ProveedorModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';

$consulta = new ProveedorModel();
$validacion = true;
$response = array();


$id = DataSanitizer::sanitize_input($_POST['idProveedor']);    
$categoria = DataSanitizer::sanitize_input($_POST['categoria']);

$data = [$categoria, $id];

    //si se envia formulario sin datos se marca un error
if(DataValidator::validateVariables($data) === false){
      $response = array('success' => false, 'message' => 'Faltan datos');
}else{
    $messageN = "Ingrese solo numeros en el ID";
    $response = DataValidator::validateNumber($id, $messageN);
    if ($response !== true) {
     $validacion = false;
       echo json_encode($response);
       exit();
   }
   $messageL = "Ingrese solo letras en la categoría";
   $response = DataValidator::validateLettersOnly($categoria, $messageL);
   if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }
     if($validacion == true){//Si devuelve true, significa que el reCAPTCHA es válido y se puede continuar con el procesamiento del formulario
        $result = $consulta->assignCategory($categoria, $id);

           if($result == true){
            $response = array("success" => true, 'message' => 'Se asigno categoría al Proveedor!');
           }else{
            $response = array('success' => false, 'message' => 'No se pudo asignar categoría al Proveedor');
           }
 }
}

// Return response as JSON
echo json_encode($response);
