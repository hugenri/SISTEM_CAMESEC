<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';
require_once '../clases/Response_json.php';

$respuesta_json = new ResponseJson();
$response = null;

$action = $_POST['action'];

if(isset($action) && !empty($action)){
 if($action == "mostarVenta"){
    
   $sql = "SELECT 
    CONCAT(c.nombre, ' ', c.apellidoPaterno, ' ', c.apellidoMaterno) AS nombre_completo,
    c.razonSocial,
    p.fecha_pago,
    p.pago,
    e.estado AS estado_entrega, v.id_venta
FROM 
    cliente c
JOIN 
    ventas v ON c.idCliente = v.id_cliente
JOIN 
    pagos_venta p ON v.id_venta = p.id_venta
JOIN 
    entregas e ON v.id_venta = e.id_venta
WHERE 
    p.pago <> 'no' AND
    e.estado = 'en proceso';";


    
           
    $parametros = array(
    
    );
    
    // Ejecutar la consulta
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    
    if(!empty($datos)){
        $response = array('success' => true, 'datosVenta'  => $datos);
        $respuesta_json->response_json($response);
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registro!');
    }
   
  }elseif ($action == "registarEntrega") {
    $idVenta =  DataSanitizer::sanitize_input($_POST['idVenta']);
    $fechaEntrega =  DataSanitizer::sanitize_input($_POST['fecha']);
    $detalle =  DataSanitizer::sanitize_input($_POST['detalles']);
    $responsable =  DataSanitizer::sanitize_input($_POST['responsable']);



    $data = [$idVenta, $fechaEntrega, $detalle, $responsable];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $respuesta_json->handle_response_json(false, 'Faltan datos');

    }
      
        $messageLetters = "Ingrese solo numeros";
        $datos = [$idVenta, $responsable];
        $response = DataValidator::validateNumbersOnlyArray($datos, $messageLetters);
        if ($response !== true) {
            $respuesta_json->response_json($response);
       }
       
       $messageLetters = "Ingrese una fecha valida";
       $response = DataValidator::validateDateForMySQL($fechaEntrega, $messageLetters);
       if ($response !== true) {
           $respuesta_json->response_json($response);
      }
      
       $parametros = array(
        ':idVenta' => $idVenta,
        ':fecha' => $fechaEntrega,
        ':responsable' => $responsable,
        ':detalle' => $detalle,
        ':estado' => 'enviado'

    );


    $sql = "UPDATE entregas
            SET fecha_entrega = :fecha, estado = :estado,  detalle = :detalle, responsable = :responsable
            WHERE id_venta = :idVenta";
        
    // Ejecutar la consulta
    $coulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, false);
    
    if($coulta){
        

        $respuesta_json->handle_response_json(true, 'Se realizó el registro!');

    } else {
        $respuesta_json->handle_response_json(false, 'No se pudo registar los datos!');
    }

  }
       //####################
} else {
  $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
