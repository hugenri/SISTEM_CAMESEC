<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'cliente'){
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
    $idVenta = DataSanitizer::sanitize_input($_POST['idVenta']);
    $data = [$idVenta];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $respuesta_json->handle_response_json(false, 'Faltan datos en el formulario');

    }
      
        $messageLetters = "Ingrese solo numeros";
        $response = DataValidator::validateNumber($idVenta, $messageLetters);
        if ($response !== true) {
            $respuesta_json->response_json($response);
       }
   $sql = "SELECT 
    c.nombre,
    c.apellidoPaterno,
    c.apellidoMaterno, c.razonSocial,
    v.total,
    p.nombre AS producto_nombre, 
    p.imagen,
    vp.cantidad,
    p.precio,
    v.id_venta,
    vp.cantidad

FROM 
    cliente c
JOIN 
    ventas v ON c.idCliente = v.id_cliente
JOIN 
    ventas_productos vp ON v.id_venta = vp.id_venta
JOIN 
    producto p ON vp.id_producto = p.id
JOIN 
    pagos_venta pv ON v.id_venta = pv.id_venta
WHERE 
    pv.pago = 'no' AND pv.id_venta = :idVenta;
";

    
           
    $parametros = array(
        ':idVenta' => $idVenta

    );
    
    // Ejecutar la consulta
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    
    if(!empty($datos)){
        $response = array('success' => true, 'datosVenta'  => $datos);
        $respuesta_json->response_json($response);
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registro!');
    }
   
  }elseif ($action == "procesarPago") {
    $idVenta = DataSanitizer::sanitize_input($_POST['idVenta']);
    $opcionPago =  DataSanitizer::sanitize_input($_POST['opcionPago']);

    $data = [$idVenta, $opcionPago];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $respuesta_json->handle_response_json(false, 'Faltan datos');

    }
      
        $messageLetters = "Ingrese solo numeros";
        $response = DataValidator::validateNumber($idVenta, $messageLetters);
        if ($response !== true) {
            $respuesta_json->response_json($response);
       }
       $messageLetters = "Ingrese solo letras";
       $response = DataValidator::validateLettersOnly($opcionPago, $messageLetters);
       if ($response !== true) {
           $respuesta_json->response_json($response);
      }
 
       $parametros = array(
        ':idVenta' => $idVenta,
        ':fechaPago' => date('Y-m-d'), // Fecha actual en formato YYYY-MM-DD
        ':metodoPago' => $opcionPago,
        ':pago' => 'si' // el pago fue realizado
    );


    $sql = "UPDATE pagos_venta 
            SET fecha_pago = :fechaPago, metodo_pago = :metodoPago, pago = :pago 
            WHERE id_venta = :idVenta";
        
    // Ejecutar la consulta
    $coulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, false);
    
    if($coulta){
        // Ingresar registro en la tabla entregas
        $parametrosEntrega = array(
            ':idVenta' => $idVenta,
            ':detalle' => 'Entrega pendiente'
        );

        $sqlEntrega = "INSERT INTO entregas (id_venta, detalle) 
                       VALUES (:idVenta, :detalle)";

        $consultaEntrega = ConsultaBaseDatos::ejecutarConsulta($sqlEntrega, $parametrosEntrega, false);

        $respuesta_json->handle_response_json(true, 'Gracias por  su pago!');

    } else {
        $respuesta_json->handle_response_json(false, 'No se pudo registar su pago!');
    }

  }
       //####################
} else {
  $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
