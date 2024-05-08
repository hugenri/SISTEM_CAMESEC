<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'cliente') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}


include_once '../model/SolicitudCotizacionModel.php';
include_once '../clases/dataSanitizer.php';
require_once '../clases/Response_json.php';
include_once '../clases/DataBase.php';
include_once '../clases/DataValidator.php';


$consulta = new SolicitudCotizacionModel();
$response = array();

$respuesta_json = new ResponseJson();

$response = array();

$action =   $_POST['action'];

if(isset($action) && !empty($action)){
  if($action == "mostarServiciosSolicitados"){

      $id_cliente  = $session->getSessionVariable('id_cliente');
     $sql = "SELECT sc.*, c.estatus 
     FROM solicitudes_cotizacion sc 
     LEFT JOIN cotizaciones c ON sc.id = c.idSolicitudCotizacion 
     WHERE sc.id_cliente = :idCliente;";
    // Si no se proporciona un ID, se asume que es una solicitud para obtener todas las cotizaciones
    //$dataCotizaciones = $consulta->getSolicitudCotizaciones($id_cliente);
    $parametros = array(
      ':idCliente' => $id_cliente
  );
  
  // Ejecutar la consulta
  $dataCotizaciones = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    if (!empty($dataCotizaciones)) {
        $response = array('success' => true, 'cotizaciones' => $dataCotizaciones); // Encerrar la cotización en un array
    } else {
        $response = array('success' => false, 'message' => 'No tiene cotizaciones');
    }
    
    $respuesta_json->response_json($response);
  }elseif($action == "verCotizacion"){
    $idSC =  DataSanitizer::sanitize_input($_POST['idSC']);

    if($idSC == ""){ //para verificar que los datos enviados por POST tenga un valor.
    
        $respuesta_json->handle_response_json(false, 'Faltan datos');
        
     } 
        
       $sql = "SELECT c.*, cl.nombre, cl.apellidoPaterno, cl.apellidoMaterno, cl.razonSocial,
       p.nombre AS nombre_producto, p.precio, pc.cantidad, sc.servicio
       FROM cotizaciones c
       INNER JOIN solicitudes_cotizacion sc ON c.idSolicitudCotizacion = sc.id
       INNER JOIN cliente cl ON sc.id_cliente = cl.idCliente
       INNER JOIN productos_cotizacion pc ON c.idCotizacion = pc.idCotizacion
       INNER JOIN producto p ON pc.id_producto = p.id
       WHERE c.idSolicitudCotizacion = :idSC";

       
$parametros = array(
    ':idSC' => $idSC
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

if(!empty($datos)){
    $response = array('success' => true, 'dataCotizacion'  => $datos);
    $respuesta_json->response_json($response);
} else {
    $respuesta_json->handle_response_json(false, 'No hay registro!');
}
/******************* */

}elseif($action == "setEstatus"){
  $idSC= DataSanitizer::sanitize_input($_POST['idSC']);
  $estatus = DataSanitizer::sanitize_input($_POST['estatus']);

  $data = [$idSC, $estatus];

  //si se envia formulario sin datos se marca un error
  if(DataValidator::validateVariables($data) === false){

    $respuesta_json->handle_response_json(false, 'Faltan datos en el formulario');
  }
  $messageLength = "El dato debe tener solo letras";
  $response = DataValidator:: validateLettersOnly($estatus, $messageLength);
  if ($response !== true) {
      $respuesta_json->response_json($response);
 }
 
 $messageLength = "ingrese solo numeros";
  $response = DataValidator:: validateNumber($idSC, $messageLength);
  if ($response !== true) {
      $respuesta_json->response_json($response);
 }

 $sql = "UPDATE cotizaciones
 SET estatus = :estatus
 WHERE idSolicitudCotizacion = :idSC;";

   $parametros = array(
       ':idSC' => $idSC,
       ':estatus' => $estatus
   );
   
   // Ejecutar la consulta
   $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
   
   if($consulta == true){
      $respuesta_json->handle_response_json(true, 'Su decicion se ha registrado');
   } else {
       $respuesta_json->handle_response_json(false, 'No se registro su consulta');
   }
   
}
//++++++
} else {
  $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  

 