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
include_once '../clases/deleteFile.php';


$consulta = new ProductoModel();
$response = array();


$id = DataSanitizer::sanitize_input($_POST['id']);
$name_image = $_POST['image'];

if($id == "" && $image == ""){ //para verificar que los datos enviados por POST tenga un valor.

	$response = array('success' => false, 'message' => 'Faltan datos');
 } else{
	$result = null;
	$file_path_image = "../assets/images/productos/" . $name_image; //ruta  del archivo'
	 //eliminar imagen 
	 $deleteFile = new DeleteFile();
	 $delete = $deleteFile->delete_File($file_path_image);

	  if ($delete == false) {
		$response = array('success' => false, 'message' => "El archivo de la imagen no se pudo eliminar.");
	  }else {
	      $result = $consulta->deleteProduct($id); //se realiza la consulta SQL a MYSQL
		  if($result == true){//si elimino
	       $response = array('success' => true, 'message' => 'Producto  eliminado!');
	   
	     }else{
		     $response = array('success' => false, 'message' => 'El producto no se pudo eliminar');
	    }
	  }
	
}

//se retorna $response como JSON
echo json_encode($response);
