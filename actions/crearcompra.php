<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/CompraModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';

$consulta = new CompraModel();
$validacion = true;
$response = null;
/*
$fecha = DataSanitizer::sanitize_input($_POST['fecha']);
$observaciones = DataSanitizer::sanitize_input($_POST['observaciones']);
$idProveedor = DataSanitizer::sanitize_input($_POST['idProveedor']);
$idRequisicion = DataSanitizer::sanitize_input($_POST['idRequisicion']);
$idCatalogoOrdenCompra = DataSanitizer::sanitize_input($_POST['idCatalogoOrdenCompra']);
*/
$fecha = '2023-09-08';
$observaciones = 'ghghgfhggfdfgdfgdfgdfg';
$idProveedor = 456546;
$idRequisicion = 463446;
$idCatalogoOrdenCompra = 5754645;


$data = [$fecha, $observaciones, $idProveedor, $idRequisicion, $idCatalogoOrdenCompra];


    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
    }else{
      $date = $fecha; 
      $messageDate = 'Fecha no válida. Formato: Y-m-d';
      $response = DataValidator::validateDateForMySQL($date, $messageDate);
      
      if ($response !== true) {
        $validacion = false;
          echo json_encode($response);
          exit();
      }
    
      
        $messageLetters = "Ingrese solo letras en el dato";
       $response = DataValidator::validateLettersOnly($observaciones, $messageLetters);
       if ($response !== true) {
        $validacion = false;
          echo json_encode($response);
          exit();
      }
  
  
        $messageLength = "El dato debe tener más de 8  y menos de 120 letras";
       $response = DataValidator:: validateLength($observaciones, 8, 120, $messageLength);
       if ($response !== true) {
        $validacion = false;
          echo json_encode($response);
          exit();
      }
  
      $datos_int = [$idProveedor, $idRequisicion, $idCatalogoOrdenCompra];
        $messageNumbers = "Ingrese solo numero sin decimal en el dato";
       $response = DataValidator::validateNumbersOnlyArray($datos_int, $messageNumbers);
       if ($response !== true) {
        $validacion = false;
          echo json_encode($response);
          exit();
      }
  
      if($validacion == true){//Si es true,  se puede continuar 

        $result = $consulta->createOrdenCompra($fecha, $observaciones, $idProveedor,
        $idRequisicion, $idCatalogoOrdenCompra);
        $result = true;
         if($result === true){
             $response = array("success" => true, 'message' => 'Orden de compra  registrado con exito!');
         }else{
                $response = array('success' => false, 'message' => 'Error en el registro');

         }
     }
  }
 // Return response as JSON
echo json_encode($response);

