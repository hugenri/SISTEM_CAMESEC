<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/ServicioModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';


$consulta = new ServicioModel();
$validacion = true;
$response = array();


  
// Obtener los datos del formulario y sanitizarlos
$idServicio = DataSanitizer::sanitize_input($_POST['id']);
//$idOrdenCompra = DataSanitizer::sanitize_input($_POST['idOrdenCompra']);
$detalles = DataSanitizer::sanitize_input($_POST['detalles']);
$idEmpleado = DataSanitizer::sanitize_input($_POST['responsable']);
$fecha = DataSanitizer::sanitize_input($_POST['fecha']);

$data = [$fecha, $detalles, $idServicio, $idEmpleado];

//si se envia formulario sin datos se marca un error
if(DataValidator::validateVariables($data) === false){

  $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
  echo json_encode($response);
   exit();
}else{
  
  $date = $fecha; 
  $messageDate = 'Fecha no válida. Formato: Y-m-d';
  $response = DataValidator::validateDateForMySQL($date, $messageDate);
  
  if ($response !== true) {
    $validacion = false;
    echo json_encode($response);
    exit();

  }


$messageLength = "El dato debe tener entre 8 y 150 letras";
$response = DataValidator::validateLength($detalles, 8, 150, $messageLength);
if ($response !== true) {
 $validacion = false;
   echo json_encode($response);
   exit();
}
$datos = [$idEmpleado, $idServicio];
$messageLetters = "Ingrese solo numeros en el dato";
$response = DataValidator::validateNumbersOnlyArray($datos, $messageLetters);
if ($response !== true) {
$validacion = false;
  echo json_encode($response);
  exit();
}

     
    if($validacion == true){//Si es true

        $result = $consulta->updateServicio($idServicio, $idEmpleado, $detalles, $fecha);

           if($result == true){
            $response = array("success" => true, 'message' => 'Se actualizaron los datos del servicio!');
           }else{
            $response = array('success' => false, 'message' => 'No se pudo actualizar los datos del servicio');
           }
 }

}

// Return response as JSON
echo json_encode($response);
 

