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

$consulta = new ProductoModel();
$validacion = true;
$response = array();

$id = DataSanitizer::sanitize_input($_POST['id']);    
$nombre = DataSanitizer::sanitize_input($_POST['nombre']);
$precio = DataSanitizer::sanitize_input($_POST['precio']);
$descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
$stock = DataSanitizer::sanitize_input($_POST['stock']);

$file_path_image = '../' . $_POST['name_image'];
$imageName = '';


            
$data = [$nombre, $precio, $descripcion, $stock];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
    }else{
      
      $messageLetters = "Ingrese solo letras en el dato";
     $response = DataValidator::validateLettersOnly($descripcion, $messageLetters);
     if ($response !== true) {
      $validacion = false;
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
    $messageLength = "El dato debe tener más de 8 caracteres y menos de 120";
    $response = DataValidator::validateLength($descripcion, 8, 120, $messageLength);
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
     
    if($validacion == true){//Si es true

      if(isset($_FILES['image'])){
        $filePath = "../assets/images/productos"; //ruta  del archivo
        $uploadImage = new UploadImage();
       $imageName = $uploadImage->guardarImagen($filePath, $_FILES['image']['name'], $_FILES['image']['tmp_name']);
        
        if($imageName === false){
            $response = array("success" => false, 'message' => 'la imagen del producto no se pudo guardar en directorio');
        }
                 //eliminar imagen 
            $deleteFile = new DeleteFile();
             $result = $deleteFile->delete_File($file_path_image);

              if ($result == false) {
                $response = array('success' => false, 'message' => "El archivo no fue eliminado.");
              } 
      }
        $result = $consulta->updateProduct($id, $nombre, $precio, $descripcion, $stock, $imageName);

           if($result == true){
            $response = array("success" => true, 'message' => 'Se actualizaron los datos del producto!');
           }else{
            $response = array('success' => false, 'message' => 'No se pudo actualizar los datos del producto');
           }
 }

}

// Return response as JSON
echo json_encode($response);
 

