<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
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

include_once '../model/CompraModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';
require_once '../clases/Response_json.php';

$respuesta_json = new ResponseJson();
$consulta = new CompraModel();
$validacion = true;
$response = null;

$action = $_POST['action'];

if(isset($action) && !empty($action)){
 if($action == "mostar"){

    $sql = "SELECT *
    FROM orden_compras;
    ";
    
           
    $parametros = array(
        
    );
    
    // Ejecutar la consulta
    $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
    
    if(!empty($datos)){
        $response = array('success' => true, 'datosOrdenesCompra'  => $datos);
        $respuesta_json->response_json($response);
    } else {
        $respuesta_json->handle_response_json(false, 'No hay registro!');
    }
   

}elseif($action == "createOrdenCompra"){

$fecha = DataSanitizer::sanitize_input($_POST['fecha']);
$observaciones = DataSanitizer::sanitize_input($_POST['observaciones']);
$descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
$idCotizacion = DataSanitizer::sanitize_input($_POST['idCotizacion']);


$data = [$fecha, $observaciones, $descripcion, $idCotizacion];


    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
    }else{
      $date = $fecha; 
      $messageDate = 'Fecha no válida. Formato: Y-m-d';
      $response = DataValidator::validateDateForMySQL($date, $messageDate);
      
      if ($response !== true) {
        $validacion = false;
        $respuesta_json->response_json($response);

      }
    
      
       
  
      $datosLength = [$descripcion, $observaciones];
        $messageLength = "El dato debe tener más de 8  y menos de 120 letras";
       $response = DataValidator::validateLengthInArray($datosLength, 8, 150, $messageLength);
       if ($response !== true) {
        $validacion = false;
        $respuesta_json->response_json($response);

      }
  
      $datos_int = [$idCotizacion];
        $messageNumbers = "Ingrese solo numero sin decimal en el dato";
       $response = DataValidator::validateNumbersOnlyArray($datos_int, $messageNumbers);
       if ($response !== true) {
        $validacion = false;
          echo json_encode($response);
          exit();
      }

      $sql = "SELECT * FROM orden_compras WHERE idCotizacion = :idCotizacion;";

      $parametros = array(
        ':idCotizacion' => $idCotizacion
        );
        
        // Ejecutar la consulta
        $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

        if(!empty($datos)){
          $respuesta_json->handle_response_json(false, 'Ya tiene una orden de compra de la cotización!');
      } 

      if($validacion == true){//Si es true,  se puede continuar 
        $estado = 'en proceso';
        // Se establece la sentencia de la consulta SQL
        $sql = "INSERT INTO orden_compras (fecha, descripcion, observaciones, idCotizacion, estado)
                VALUES (:fecha, :descripcion, :observaciones, :idCotizacion, :estado);";

        $parametros = array(
          ':fecha'=>$fecha,
          ':observaciones'=>$observaciones,
          ':descripcion'=>$descripcion,
          ':idCotizacion'=>$idCotizacion,
          ':estado'=>$estado
        );

        $result = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);
        
         if($result > 0){

             $respuesta_json->handle_response_json(true, 'Orden de compra  registrado con exito!');

         }else{
                $respuesta_json->handle_response_json(false, 'No se pudo realizar el registro!');

         }
     }
    }
}elseif($action == "eliminar"){

  $id = DataSanitizer::sanitize_input($_POST['idOrdenCompra']);

  if($id == ''){
    $respuesta_json->handle_response_json(false, 'Fantan datos');

  }

  $sql = "DELETE FROM  orden_compras WHERE idOrdenCompra = :id;";
  
         
  $parametros = array(
      ':id' => $id
  );
  
  // Ejecutar la consulta
  $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
  
  if($consulta){
    $respuesta_json->handle_response_json(true, 'Registro eliminado con exito!');

  } else {
      $respuesta_json->handle_response_json(false, 'No hay registro!');
  }
 
}elseif($action == "actualizar"){

  $fecha = DataSanitizer::sanitize_input($_POST['fecha']);
  $observaciones = DataSanitizer::sanitize_input($_POST['observaciones']);
  $descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
  $idCotizacion = DataSanitizer::sanitize_input($_POST['idCotizacion']);
  $id = DataSanitizer::sanitize_input($_POST['idOrdenCompra']);

  
  
  $data = [$fecha, $observaciones, $descripcion, $idCotizacion, $id];
  
  
      //si se envia formulario sin datos se marca un error
      if(DataValidator::validateVariables($data) === false){
  
        $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
      }else{
        $date = $fecha; 
        $messageDate = 'Fecha no válida. Formato: Y-m-d';
        $response = DataValidator::validateDateForMySQL($date, $messageDate);
        
        if ($response !== true) {
          $validacion = false;
          $respuesta_json->response_json($response);
  
        }
      
        
         
    
        $datosLength = [$descripcion, $observaciones];
          $messageLength = "El dato debe tener más de 8  y menos de 150 letras";
         $response = DataValidator::validateLengthInArray($datosLength, 8, 150, $messageLength);
         if ($response !== true) {
          $validacion = false;
          $respuesta_json->response_json($response);
  
        }
    
        $datos_int = [$idCotizacion, $id];
          $messageNumbers = "Ingrese solo numero sin decimal en el dato";
         $response = DataValidator::validateNumbersOnlyArray($datos_int, $messageNumbers);
         if ($response !== true) {
          $validacion = false;
            echo json_encode($response);
            exit();
        }
  
       
  
          if(!empty($datos)){
            $respuesta_json->handle_response_json(false, 'Ya tiene una orden de compra de la cotización!');
        } 
  
        if($validacion == true){//Si es true,  se puede continuar 
          $estado = 'en proceso';
          // Se establece la sentencia de la consulta SQL
          $sql = "UPDATE orden_compras 
          SET fecha = :fecha, 
              descripcion = :descripcion, 
              observaciones = :observaciones, 
              idCotizacion = :idCotizacion
          WHERE idOrdenCompra = :idOrdenCompra;";
  
          $parametros = array(
            ':fecha'=>$fecha,
            ':observaciones'=>$observaciones,
            ':descripcion'=>$descripcion,
            ':idCotizacion'=>$idCotizacion,
            ':idOrdenCompra'=>$id
          );
  
          $result = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
          
           if($result){
               $respuesta_json->handle_response_json(true, 'El registro se actulizo con exito!');
  
           }else{
                  $respuesta_json->handle_response_json(false, 'No se pudo pudo actualizar el registro!');
  
           }
       }
      }

}elseif($action = "getDetalle"){
  $id = DataSanitizer::sanitize_input($_POST['id']);
  
          $messageNumbers = "Ingrese solo numero sin decimal en el dato";
         $response = DataValidator::validateNumber($id, $messageNumbers);
         if ($response !== true) {
          $respuesta_json->response_json($response);

        }
  

   // Se establece la sentencia de la consulta SQL
   $sql = "SELECT descripcion from orden_compras
   WHERE idOrdenCompra = :idOrdenCompra;";

   $parametros = array(
    
     ':idOrdenCompra'=>$id
   );

   $datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros,true, 'no');
   
    if(!empty($datos)){
      $response = array("success" => true, 'descripcion' => $datos);

        $respuesta_json->response_json($response);

    }else{
           $respuesta_json->handle_response_json(false, 'No hay registro!');

    }

}
     //####################
} else {
  $respuesta_json->handle_response_json(false, 'Método de solicitud no admitido');
}  
