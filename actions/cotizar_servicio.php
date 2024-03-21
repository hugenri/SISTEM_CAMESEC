<?php



include_once '../model/SolicitudCotizacionModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';

$consulta = new SolicitudCotizacionModel();
$validacion = true;
$response = array();

$servicio = DataSanitizer::sanitize_input($_POST['servicio']);    
$fecha = DataSanitizer::sanitize_input($_POST['fecha']);
$idCliente = '4';
$estado = 'en proceso';


$data = [$servicio, $fecha, $idCliente];

    //si se envia formulario sin datos se marca un error
if(DataValidator::validateVariables($data) === false){
      $response = array('success' => false, 'message' => 'Faltan datos');
}else{

     
     if($validacion == true){//Si devuelve true, significa que el reCAPTCHA es válido y se puede continuar con el procesamiento del formulario
        $result = $consulta->createSolicitudCotizacion($servicio, $idCliente, $fecha, $estado);

           if($result == true){
            $response = array("success" => true, 'message' => 'La solicitud de cotización se ha registrado.');
           }else{
            $response = array('success' => false, 'message' => 'La solicitud de cotización no se pudo registrar.');
           }
 }

}

// Return response as JSON
echo json_encode($response);
 

