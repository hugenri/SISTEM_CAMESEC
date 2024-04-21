<?Php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'cliente'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

require_once '../clases/Response_json.php';

include_once '../clases/DataBase.php';

$respuesta_json = new ResponseJson();

$id = $session->getSessionVariable('id_cliente');

$sql = "SELECT COUNT(*) as num_cotizaciones 
        FROM cotizaciones 
        WHERE idCliente = :idCliente AND estatus = 'enviada'";
$parametros = array(
    ':idCliente' => $id
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
     
    if(!empty($datos)){
        $response = array('success' => true, 'numCotizaciones' => $datos); // Encerrar la cotización en un array

        $respuesta_json->response_json($response);

    } else {
        $respuesta_json->handle_response_json(false, 'No hay registros');
    }