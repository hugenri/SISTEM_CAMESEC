<?php
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

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'cliente') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

require_once '../clases/Response_json.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';


$respuesta_json = new ResponseJson();

$response = array();

$action = $_POST['action'];

if(isset($action) && !empty($action)){
  if($action == "mostarCotizacion"){
        $sql = "SELECT c.*, cl.nombre,cl.apellidoPaterno, cl.apellidoMaterno, cl.razonSocial, 
        p.nombre AS nombre_producto, p.precio, ps.cantidad
       FROM cotizaciones c
       INNER JOIN cliente cl ON c.idCliente = cl.idCliente
       INNER JOIN productos_solicitud_cotizacion ps ON c.idCotizacion = ps.id_solicitud
       INNER JOIN producto p ON ps.id_producto = p.id
       WHERE c.idCotizacion = :idCotizacion";
$parametros = array(
    ':idCotizacion' => 118
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

if(!empty($datos)){
    $response = array('success' => true, 'dataCotizacion'  => $datos);
    $respuesta_json->response_json($response);
} else {
    $respuesta_json->handle_response_json(false, 'No hay registros');
}
/******************* */

}elseif($action == "getCotizaciones"){
   $id = $session->getSessionVariable('id_cliente');
    $sql ="SELECT c.idCotizacion, c.fecha, c.servicio, cl.razonSocial
    FROM cotizaciones c
    INNER JOIN cliente cl ON c.idCliente = cl.idCliente
    WHERE c.idCliente = :idCliente;
    ";
    $parametros = array(
        ':idCliente' => $id
    );
    
    // Ejecutar la consulta
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    
    if(!empty($datos)){
        $response = array('success' => true, 'dataCotizacion'  => $datos);
        $respuesta_json->response_json($response);
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registros');
    }
    
}
//++++++
} else {
    $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
