<?php

require_once("conexion.php");//se lo importa el archivo de la conexion 


class CompraModel{

private $conexion;//variable para el objeto de la conexion 

public function __construct(){

$this->conexion = null;

    }

   
//Función para crear registro de compra
public function createOrdenCompra($fecha, $observaciones, $descripcion, $idCotizacion){
    try {
        $this->conexion = ConexionBD::getconexion(); // Se crea la conexión a la base de datos

        // Se establece la sentencia de la consulta SQL
        $sql = "INSERT INTO orden_compras (fecha, descripcion, observaciones, idCotizacion)
                VALUES (:fecha, :descripcion, :observaciones, :idCotizacion);";


        // Se prepara la sentencia de la consulta SQL
        $query = $this->conexion->prepare($sql);
          // Se vincula cada parámetro al nombre de variable especificado
          $query->bindParam(':fecha', $fecha);
          $query->bindParam(':observaciones', $observaciones);
          $query->bindParam(':descripcion', $descripcion);
          $query->bindParam(':idCotizacion', $idCotizacion);
        
        // Se ejecuta la consulta en la base de datos
        $result = $query->execute();

        if ($result === true) { // Si se retorna true se entra en este bloque if
            return true; // Se retorna true
        } else { // Si no
            return false; // Se retorna false
        }
    } catch (Exception $ex) { // Se captura el error que ocurra en el bloque try
        echo "Error: " . $ex->getMessage();
    } finally {
        $this->conexion = null; // Se cierra la conexión
    }
}

//Función para obtener los registros de orden compra
public function getOrdenesCompras(){
        
    try{
    
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
          ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
        $query = $this->conexion->prepare("SELECT * FROM ordencompra;");
        
        //se ejecuta la consulta sql
        $query->execute();
       //se obtiene un array con todos los registros de los resultados
        $data=$query->fetchAll(PDO::FETCH_ASSOC);
        
        if($data){//si se regresan datos de la consulta se ejecuta este bloque 
            
          return $data;
        }else{//si no hay datos se ejecuta este bloque
             return 0;
        }
} catch (Exception $ex) {//se captura algún error tipo de error
 echo "Error". $ex;// se imprime el tipo de error 

} finally {
    $this->conexion = null;//se cierra la conexión 
}
}

//Función para borrar registro

public function deleteOrdenCompra($id){

    try{ // bloque try-catch, se capturan las  excepciones 
            $this->conexion = ConexionBD::getconexion();//se crea la conexión a la BD
            // se establece la sentencia de la consulta sql
            $sql = "DELETE FROM ordencompra WHERE idOrdenCompra = :id;";
            //se  prepara la sentencia de la  consulta sql
            $query = $this->conexion->prepare($sql);
            //Se vinculan los parámetros de la consulta con las variables
            $query->bindParam(":id", $id);
            //Se ejecuta la consulta en la base de datos
            $resultado = $query->execute();

        if($resultado === TRUE){//si el resultado es igual a true se ejecuta este bloque if 
            return true;//se retorna true si se elimino el registro
        }
        else{
            return false;//se retorna false si no se elimino el registro
        }
    }catch (Exception $ex) {//se captura  el error que ocurra en el bloque try
            echo "Error ". $ex;
           } finally {
               $this->conexion = null; //se cierra la conexión 
           }
  }

//método para actualizar los datos 
public function updateOrdenCompra($id, $fecha, $observaciones, $idProveedor,
$idRequisicion, $idCatalogoOrdenCompra) {
try {
$this->conexion = ConexionBD::getconexion(); // Se crea la conexión a la base de datos

// Se establece la sentencia de la consulta SQL
$sql = "UPDATE ordencompra SET fecha = :fecha, Observaciones = :observaciones,
                idProveedor = :idProveedor, idRequisicion = :idRequisicion,
                idCatalogoOrdenCompra = :idCatalogoOrdenCompra
                WHERE idOrdenCompra = :idOrdenCompra;";


// Se prepara la sentencia de la consulta SQL
$query = $this->conexion->prepare($sql);

// Se vincula cada parámetro al nombre de variable especificado
        $query->bindParam(':idOrdenCompra', $id);
        $query->bindParam(':fecha', $fecha);
        $query->bindParam(':observaciones', $observaciones);
        $query->bindParam(':idProveedor', $idProveedor);
        $query->bindParam(':idRequisicion', $idRequisicion);
        $query->bindParam(':idCatalogoOrdenCompra', $idCatalogoOrdenCompra);

        // ejecutar la consulta
        $result = $query->execute();
        // verificar si la actualización se realizó correctamente
        if ($result == true) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $ex) {
        // capturar el error que ocurra en el bloque try
        echo "Error" . $ex;
    } finally {
        $this->conexion = null; // cerrar la conexión a la BD
    }
}

public function getNumerOrdenesCompra(){

    try{
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
          $sql = "SELECT COUNT(*) as numRegistros FROM orden_compras";
           ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
           $query = $this->conexion->prepare($sql);
        //se ejecuta la consulta sql
        $query->execute();
       //se obtiene un array con todos los registros de los resultados
        $resultClients = $query->fetch(PDO::FETCH_ASSOC);
        return $resultClients['numRegistros']; // Devolver el número de registros
       } catch (Exception $ex) {//se captura algún error tipo de error

             echo "Error". $ex;// se imprime el tipo de error 
      } finally {

         $this->conexion = null;//se cierra la conexión 
     }


}

//Función para obtener los detalles
public function getDetalles($id){
        
    try{
    
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
          ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
          $query = $this->conexion->prepare("SELECT observaciones FROM ordencompra WHERE idOrdenCompra = :id;");
          $query->bindParam(':id', $id);
          

        //se ejecuta la consulta sql
        $query->execute();
       //se obtiene un array con todos los registros de los resultados
        $data=$query->fetch(PDO::FETCH_ASSOC);
        
        if($data){//si se regresan datos de la consulta se ejecuta este bloque 
            
          return $data;
        }else{//si no hay datos se ejecuta este bloque
             return 0;
        }
} catch (Exception $ex) {//se captura algún error tipo de error
 echo "Error". $ex;// se imprime el tipo de error 

} finally {
    $this->conexion = null;//se cierra la conexión 
}
}

}