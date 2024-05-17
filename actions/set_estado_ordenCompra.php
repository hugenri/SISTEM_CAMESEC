<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'admin') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

// Función para manejar errores fatales y convertirlos en una respuesta JSON
function handleFatalError() {
  $error = error_get_last();
  if ($error !== null) {
      // Limpiar el búfer de salida
      if (ob_get_contents()) ob_clean();
      
      http_response_code(500);
      header('Content-Type: application/json');
      $errorData = [
          'error' => 'Error fatal',
          'message' =>  $error['message']
      ];
      exit(json_encode($errorData));
  }
}

// Registra la función para manejar errores fatales
register_shutdown_function('handleFatalError');

// Simula un error fatal

require_once '../clases/Response_json.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';

$respuesta_json = new ResponseJson();
$response = array();

$idOrdenCompra = DataSanitizer::sanitize_input($_POST['idOrdenCompra']);
$estado = DataSanitizer::sanitize_input($_POST['estado']);
$idCotizacion = DataSanitizer::sanitize_input($_POST['idCotizacion']);



  //si se envia formulario sin datos se marca un error
  if(empty($idOrdenCompra) && empty($estado) && empty($idCotizacion)){

    $respuesta_json->handle_response_json(false, 'Faltan datos para procesar solicitud');
  }


 $messageLength = "ingrese solo numeros";
  $response = DataValidator:: validateNumber($idOrdenCompra, $messageLength);
  if ($response !== true) {
      $respuesta_json->response_json($response);
 }
 $messageLength = "El dato debe tener más de 4 caracteres y menos de 10";
$response = DataValidator::validateLength($estado, 3, 25, $messageLength);
if ($response !== true) {
    $respuesta_json->response_json($response);
}
$messageLetters = "Ingrese solo letras en el dato";
$response = DataValidator::validateLettersOnly($estado, $messageLetters);
if ($response !== true) {
 $validacion = false;
 $respuesta_json->response_json($response);

}
  
$sql = "UPDATE orden_compras
SET estado = :estado
WHERE idOrdenCompra = :id;";

       
$parametros = array(
    'id'=>$idOrdenCompra,
    'estado'=> $estado
);

// Ejecutar la consulta
$consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);

if($consulta){
  if($estado == "finalizada"){
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
 //crear factura 

 $sql = "SELECT * FROM facturas WHERE idCotizacion = :idCotizacion;";
 
        
 $parametros = array(
     'idCotizacion'=> $idCotizacion
 );
 
 // Ejecutar la consulta
 $consulta_existe = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true, 'no');
 
 if(!empty($consulta_existe)){
  $respuesta_json->handle_response_json(false, 'Yatiene un registro!');

 }

   //############
  $sql = "INSERT INTO facturas (idCotizacion, fecha)
  VALUES (:idCotizacion, :fecha);";

       
$parametros = array(
    'idCotizacion'=> $idCotizacion,
    'fecha' => $fecha
);

// Ejecutar la consulta
$consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);


  }
    $response = array('success' => true, 'message'=>'El estado de la orden de compra a canbiado a: '. $estado);
    $respuesta_json->response_json($response);
} else {
    $respuesta_json->handle_response_json(false, 'No hay registro!');
}
