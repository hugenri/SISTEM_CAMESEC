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
 if($action == "mostarVentas"){
   
   $sql = "SELECT 
    v.id_venta,  ROUND(v.total + (v.total * 0.16), 2) AS total_con_iva,
    ROUND(v.total * 0.16, 2) AS iva,
    c.razonSocial,
    v.fecha_venta,
    p.metodo_pago,
    p.pago,
    e.estado AS estado_entrega
FROM 
    ventas v
    INNER JOIN cliente c ON v.id_cliente = c.idCliente
    LEFT JOIN pagos_venta p ON v.id_venta = p.id_venta
    LEFT JOIN entregas e ON v.id_venta = e.id_venta;
";

    
           
    $parametros = array(

    );
    
    // Ejecutar la consulta
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    
    if(!empty($datos)){
        $response = array('success' => true, 'datosVentas'  => $datos);
        $respuesta_json->response_json($response);
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registro!');
    }
   
  }elseif ($action == "eliminarVenta") {
    $idVenta = DataSanitizer::sanitize_input($_POST['idVenta']);

    $data = [$idVenta];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $respuesta_json->handle_response_json(false, 'Faltan datos');

    }
      
        $messageLetters = "Ingrese solo numeros";
        $response = DataValidator::validateNumber($idVenta, $messageLetters);
        if ($response !== true) {
            $respuesta_json->response_json($response);
       }
      
 
       $parametros = array(
        ':idVenta' => $idVenta
    );


 $sql = "DELETE  FROM ventas WHERE id_venta = :idVenta;";
        
    // Ejecutar la consulta
    $coulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, false);
    
    if($coulta){

        $respuesta_json->handle_response_json(true, 'El registro de la venta fue eliminado!');

    } else {
        $respuesta_json->handle_response_json(false, 'No se pudo elimina el registro de la venta!');
    }

  }
       //####################
} else {
  $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
