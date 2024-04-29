<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

include_once '../model/ProductoModel.php';
include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/deleteFile.php';
include_once '../clases/UploadImage.php';
include_once '../clases/DataBase.php';

$consulta = new ProductoModel();
$validacion = true;
$response = array();

$id = DataSanitizer::sanitize_input($_POST['id']);    
$nombre = DataSanitizer::sanitize_input($_POST['nombre']);
$precio = DataSanitizer::sanitize_input($_POST['precio']);
$descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
$stock = DataSanitizer::sanitize_input($_POST['stock']);
$idProveedor  = DataSanitizer::sanitize_input($_POST['proveedor']);


$file_path_image = '../' . $_POST['pathImage'];
$imageName = '';
$nombreImagen = $_FILES['name_image']['name'];

            
$data = [$nombre, $precio, $descripcion, $stock];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
      echo json_encode($response);
      exit();
    }
      
    $messageLength = "El dato debe tener más de 5 caracteres y menos de 25";
     $response = DataValidator::validateLength($nombre, 5, 25, $messageLength);
     if ($response !== true) {
      $validacion = false;
        echo json_encode($response);
        exit();
    }
    $messageLength = "El dato debe tener más de 8 caracteres y menos de 150";
    $response = DataValidator::validateLength($descripcion, 8, 150, $messageLength);
    if ($response !== true) {
     $validacion = false;
       echo json_encode($response);
       exit();
   }
    $datos = [$precio, $stock];
    $messageLetters = "Ingrese solo numeros en el dato";
   $response = DataValidator::validateNumbersFloat($datos, $messageLetters);
   if ($response !== true) {
    $validacion = false;
      echo json_encode($response);
      exit();
  }
  if(!empty($idProveedor)){
  $messageNumber = "El id de proveedor no es un numero entero";
  $response = DataValidator::validateNumber($idProveedor, $messageNumber);
  if ($response !== true) {
   $validacion = false;
     echo json_encode($response);
     exit();
 }
}

if($validacion == true){//Si es true
  if(isset($_FILES['name_image']) && !empty($_FILES['name_image']['name']) && empty($idProveedor)){
        
    $filePath = "../assets/images/productos"; //ruta  del archivo
    $uploadImage = new UploadImage();
   $imageName = $uploadImage->guardarImagen($filePath, $_FILES['name_image']['name'], $_FILES['name_image']['tmp_name']);
    
    if($imageName === false){
        $response = array("success" => false, 'message' => 'la imagen del producto no se pudo guardar en directorio');
        echo json_encode($response);
        exit();
      }
             //eliminar imagen 
        $deleteFile = new DeleteFile();
         $result = $deleteFile->delete_File($file_path_image);

          if ($result == false) {
            $response = array('success' => false, 'message' => "El archivo no fue eliminado.");
            echo json_encode($response);
             exit();
          } 
  
  $sql = "UPDATE producto 
  SET nombre = :nombre, 
  precio = :precio, 
  descripcion = :descripcion, 
  stock = :stock, imagen = :imagen WHERE id = :id;";
  $parametros = array(
    'id'=> $id,
    'nombre'=> $nombre,
    'precio'=> $precio,
    'descripcion'=> $descripcion,
    'stock'=>$stock,
    'imagen'=>$imageName
  );
   // Ejecutar la consulta
 $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
 if($consulta == true){
  $response = array("success" => true, 'message' => 'Se actualizaron los datos del producto!');
  echo json_encode($response);
  exit();
}else{
  $response = array('success' => false, 'message' => 'No se pudo actualizar los datos del producto');
  echo json_encode($response);
  exit();
}
  }elseif ($nombreImagen == "" && $idProveedor != "") {
  $sql = "UPDATE producto 
      SET idProveedor = :idProveedor, 
       nombre = :nombre, 
      precio = :precio, 
      descripcion = :descripcion, 
      stock = :stock WHERE id = :id;";
      $parametros = array(
        'id'=> $id,
        'nombre'=> $nombre,
        'precio'=> $precio,
        'descripcion'=> $descripcion,
        'stock'=>$stock,
        'idProveedor'=>$idProveedor
      );
       // Ejecutar la consulta
     $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
     if($consulta == true){
      $response = array("success" => true, 'message' => 'Se actualizaron los datos del producto!');
      echo json_encode($response);
      exit();
    }else{
      $response = array('success' => false, 'message' => 'No se pudo actualizar los datos del producto');
      echo json_encode($response);
      exit();
    }
     
  }elseif(!empty($nombreImagen) && !empty($idProveedor)){
        
    $filePath = "../assets/images/productos"; //ruta  del archivo
    $uploadImage = new UploadImage();
   $imageName = $uploadImage->guardarImagen($filePath, $_FILES['name_image']['name'], $_FILES['name_image']['tmp_name']);
    
    if($imageName === false){
        $response = array("success" => false, 'message' => 'la imagen del producto no se pudo guardar en directorio');
        echo json_encode($response);
        exit();
      }
             //eliminar imagen 
        $deleteFile = new DeleteFile();
         $result = $deleteFile->delete_File($file_path_image);

          if ($result == false) {
            $response = array('success' => false, 'message' => "El archivo no fue eliminado.");
            echo json_encode($response);
             exit();
          } 
  
  $sql = "UPDATE producto 
  SET  idProveedor = :idProveedor,
  nombre = :nombre, 
  precio = :precio, 
  descripcion = :descripcion, 
  stock = :stock, imagen = :imagen WHERE id = :id;";
  $parametros = array(
    'id'=> $id,
    'nombre'=> $nombre,
    'precio'=> $precio,
    'descripcion'=> $descripcion,
    'stock'=>$stock,
    'imagen'=>$imageName,
    'idProveedor'=>$idProveedor
  );
   // Ejecutar la consulta
 $consulta = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros);
 if($consulta == true){
  $response = array("success" => true, 'message' => 'Se actualizaron los datos del producto!');
  echo json_encode($response);
  exit();
}else{
  $response = array('success' => false, 'message' => 'No se pudo actualizar los datos del producto');
  echo json_encode($response);
  exit();
}
  }
   
}