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
include_once '../clases/UploadImage.php';
include_once '../clases/DataBase.php';

$consulta = new ProductoModel();
$validacion = true;
$response = null;


  $nombre = DataSanitizer::sanitize_input($_POST['nombre']);
  $precio = DataSanitizer::sanitize_input($_POST['precio']);
  $descripcion = DataSanitizer::sanitize_input($_POST['descripcion']);
  $stock = DataSanitizer::sanitize_input($_POST['stock']);
  $idProveedor = DataSanitizer::sanitize_input($_POST['proveedor']);

   $data = [$nombre, $precio, $descripcion, $stock];

    //si se envia formulario sin datos se marca un error
    if(DataValidator::validateVariables($data) === false && !isset($_FILES['image'])){

      $response = array('success' => false, 'message' => 'Faltan datos en el formulario');
    }else{
      


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

  $messageNumber = "El id de proveedor no es un numero entero";
  $response = DataValidator::validateNumber($idProveedor, $messageNumber);
  if ($response !== true) {
   $validacion = false;
     echo json_encode($response);
     exit();
 }

 $sql = "SELECT * FROM producto WHERE nombre = :nombre;";

       
$parametros = array(
    'nombre'=> $nombre
);

// Ejecutar la consulta
$datos = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

if(!empty($datos)){
  $validacion = false;
  $response = array('success' => false, 'message' => 'Ya tiene un producto registrado con el mismo nombre!');
    echo json_encode($response);
    exit();
} 
      if($validacion == true){//Si es true,  se puede continuar 
        $filePath = "../assets/images/productos"; //ruta  del archivo

        $uploadImage = new UploadImage();
       $imageName = $uploadImage->guardarImagen($filePath, $_FILES['image']['name'], $_FILES['image']['tmp_name']);
        
        if($imageName === false){
            $response = array("success" => false, 'message' => 'la imagen del producto no se pudo guardar en directorio');
        }
        $result = $consulta->createProduct($nombre, $precio, $descripcion, $stock, $imageName, $idProveedor);
        $result = true;
         if($result === true){
             $response = array("success" => true, 'message' => 'Producto registrado con exito!');
         }else{
                $response = array('success' => false, 'message' => 'Error en el registro');

         }
     }
  }

 // Return response as JSON
echo json_encode($response);

