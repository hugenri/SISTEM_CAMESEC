<?php


include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'cliente'){
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



include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';
require_once '../clases/Response_json.php';

$respuesta_json = new ResponseJson();
$response = null;

$action =  $_POST['action'];

if(isset($action) && !empty($action)){
 if($action == "mostarCompras"){
    

    $idCliente = $session->getSessionVariable('id_cliente');

    // Consulta para obtener los datos de las ventas del cliente
    $sql = "SELECT DISTINCT
            v.id_venta, 
            v.fecha_venta, 
            FORMAT(v.total, 2) AS total, 
            FORMAT(v.total * 0.16, 2) AS iva,
            FORMAT(v.total * 1.16, 2) AS total_con_iva,
            pv.pago, 
             COALESCE(pv.metodo_pago, 'pendiente') AS metodo_pago,
            CASE
                WHEN e.estado IS NULL THEN 'sin pago'
                WHEN e.estado = 'pendiente' THEN 'procesando la compra'
                ELSE e.estado
            END AS estado,
            COALESCE(e.fecha_entrega, 'pendiente') AS fecha_entrega
        FROM 
            ventas v
        JOIN 
            ventas_productos vp ON v.id_venta = vp.id_venta
        JOIN 
            producto p ON vp.id_producto = p.id
        LEFT JOIN 
            pagos_venta pv ON v.id_venta = pv.id_venta
        LEFT JOIN 
            entregas e ON v.id_venta = e.id_venta
        WHERE 
            v.id_cliente = :id_cliente;";


           
    $parametros = array(
      'id_cliente' => $idCliente
    );
    
    // Ejecutar la consulta
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    
    if(!empty($datos)){
        $response = array('success' => true, 'datos'  => $datos);
        $respuesta_json->response_json($response);
    } else {
      $response = array('error' => false, 'message'=> 'No hay registro!');
        $respuesta_json->response_json($response);
    }
   
  }elseif($action == "getCompra"){
    

    $idCliente = $session->getSessionVariable('id_cliente');
    $idVenta =  DataSanitizer::sanitize_input($_POST['idVenta']);
    
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
    // Consulta para obtener los datos de las ventas del cliente
    $sql = "SELECT DISTINCT
            v.id_venta, 
            v.fecha_venta, 
            FORMAT(v.total, 2) AS total, 
            FORMAT(v.total * 0.16, 2) AS iva,
            FORMAT(v.total * 1.16, 2) AS total_con_iva,
            pv.pago, COALESCE(pv.fecha_pago, 'pendiente') AS fecha_pago, 
            COALESCE(pv.metodo_pago, 'pendiente') AS metodo_pago,
            COALESCE(e.estado, ' ') AS estado, 
             p.nombre AS nombre_producto, FORMAT(p.precio, 2) AS precio, p.imagen,
            vp.cantidad, COALESCE(e.fecha_entrega, 'pendiente') AS fecha_entrega,
            CONCAT('calle: ', c.calle, ', número: ', c.numero, ', colonia: ', c.colonia, ', municipio: ', c.municipio, ', estado: ', c.estado, ', cp: ', c.cp) AS direccion_completa
        FROM 
            ventas v
        JOIN 
            ventas_productos vp ON v.id_venta = vp.id_venta
        JOIN 
            producto p ON vp.id_producto = p.id
        LEFT JOIN 
            pagos_venta pv ON v.id_venta = pv.id_venta
        LEFT JOIN 
            entregas e ON v.id_venta = e.id_venta
        JOIN
            cliente c ON v.id_cliente = c.idCliente
        WHERE 
            v.id_cliente = :id_cliente AND v.id_venta = :id_venta;";


           
    $parametros = array(
      'id_cliente' => $idCliente,
      'id_venta' => $idVenta

    );
    
    // Ejecutar la consulta
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    
    if(!empty($datos)){
        $response = array('success' => true, 'datos'  => $datos);
        $respuesta_json->response_json($response);
    } else {
      $response = array('error' => false, 'message'=> 'No hay registro!'. $idVenta);
        $respuesta_json->response_json($response);
    }

  }
       //####################
} else {
  $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
