<?php

require_once("conexion.php");//se lo importa el archivo de la conexion 


class CotizacionModel{

private $conexion;//variable para el objeto de la conexion 

public function __construct(){

$this->conexion = null;

    }

 // Función para crear registro de cotizacion
public function createCotizacion($fecha, $observaciones, $idSolicitud, $descripcion,
$subtotal, $total, $iva, $descuento, $costo_instalacion) {
try {
$this->conexion = ConexionBD::getconexion(); // Se crea la conexión a la base de datos

// Se establece la sentencia de la consulta SQL
$sql = "INSERT INTO cotizaciones (fecha, observaciones, idSolicitudCotizacion, descripcion, 
subtotal, total, iva, descuento, costo_instalacion) 
VALUES (:fecha, :observaciones, :idsolicitud, :descripcion, 
:subtotal, :total, :iva, :descuento, :costo_instalacion)";

// Se prepara la sentencia de la consulta SQL
$query = $this->conexion->prepare($sql);

// Se vincula cada parámetro al nombre de variable especificado
$query->bindParam(':fecha', $fecha);
$query->bindParam(':observaciones', $observaciones);
$query->bindParam(':idsolicitud', $idSolicitud);
$query->bindParam(':descripcion', $descripcion);
$query->bindParam(':subtotal', $subtotal);
$query->bindParam(':total', $total);
$query->bindParam(':iva', $iva);
$query->bindParam(':descuento', $descuento);
$query->bindParam(':costo_instalacion', $costo_instalacion);

// Se ejecuta la consulta en la base de datos
$result = $query->execute();

// Obtener el ID de la cotización recién creada
$id_cotizacion = $this->conexion->lastInsertId();

if ($result === true) { // Si se retorna true se entra en este bloque if
return $id_cotizacion; // Se retorna el ID de la cotización
} else { // Si no
return false; // Se retorna false
}
} catch (Exception $ex) { // Se captura el error que ocurra en el bloque try
echo "Error: " . $ex->getMessage();
} finally {
$this->conexion = null; // Se cierra la conexión
}
}


//Función para obtener los registros de citizaciones
public function getCotizaciones(){
        
    try{
    
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
          ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
         $sql = "SELECT c.*, cl.razonSocial AS razonSocialCliente, sc.servicio
         FROM cotizaciones c
         INNER JOIN solicitudes_cotizacion sc ON c.idSolicitudCotizacion = sc.id
         INNER JOIN cliente cl ON sc.id_cliente = cl.idCliente;";
      
      
          $query = $this->conexion->prepare($sql);
        
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

public function deleteCotizacion($id){

    try{ // bloque try-catch, se capturan las  excepciones 
            $this->conexion = ConexionBD::getconexion();//se crea la conexión a la BD
            // se establece la sentencia de la consulta sql
            $sql = "DELETE FROM cotizaciones WHERE idCotizacion = :id;";
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
public function updateCotizacion($id, $fecha, $observaciones, $idCliente, $descripcion,
$cantidad, $precioUnitario, $importeTotal, $idProducto, $idServicio, $idCatalogoCotizaciones) {
try {
$this->conexion = ConexionBD::getconexion(); // Se crea la conexión a la base de datos

// Se establece la sentencia de la consulta SQL
$sql = "UPDATE cotizaciones SET fecha = :fecha, observaciones = :observaciones,
                idCliente = :idCliente, descripcion = :descripcion,
                cantidad = :cantidad, precioUnitario = :precioUnitario,
                importeTotal = :importeTotal, idProducto = :idProducto,
                idServicio = :idServicio, idCatalogoCotizaciones = :idCatalogoCotizaciones
                WHERE idCotizacion = :idCotizacion ;";


// Se prepara la sentencia de la consulta SQL
$query = $this->conexion->prepare($sql);

// Se vincula cada parámetro al nombre de variable especificado
$query->bindParam(':idCotizacion', $id);
$query->bindParam(':fecha', $fecha);
$query->bindParam(':observaciones', $observaciones);
$query->bindParam(':idCliente', $idCliente);
$query->bindParam(':descripcion', $descripcion);
$query->bindParam(':cantidad', $cantidad);
$query->bindParam(':precioUnitario', $precioUnitario);
$query->bindParam(':importeTotal', $importeTotal);
$query->bindParam(':idProducto', $idProducto);
$query->bindParam(':idServicio', $idServicio);
$query->bindParam(':idCatalogoCotizaciones', $idCatalogoCotizaciones);



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

public function getNumerCotizaciones(){

    try{
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
          $sql = "SELECT COUNT(*) as numRegistros FROM cotizaciones";
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
          $query = $this->conexion->prepare("SELECT descripcion FROM cotizaciones WHERE idCotizacion = :id;");
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

//Función para crear registro de solicitud de cotizacion
public function createSolicitudCotizacion($servicio, $idCliente, $fechaSolicitud, $estado) {
    try {
        $this->conexion = ConexionBD::getconexion(); // Se crea la conexión a la base de datos

        // Se establece la sentencia de la consulta SQL
        $sql = "INSERT INTO solicitudes_cotizacion (servicio, id_cliente, fecha_solicitud, estado)
                VALUES (:servicio, :idCliente, :fechaSolicitud, :estado)";

        // Se prepara la sentencia de la consulta SQL
        $query = $this->conexion->prepare($sql);
        
        // Se vincula cada parámetro al nombre de variable especificado
        $query->bindParam(':servicio', $servicio);
        $query->bindParam(':idCliente', $idCliente);
        $query->bindParam(':fechaSolicitud', $fechaSolicitud);
        $query->bindParam(':estado', $estado);
        
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

function insertOrderItems($idCotizacion, $items) {
    $sql = "INSERT INTO productos_cotizacion (idCotizacion, id_producto, cantidad) VALUES ";
   
    $values = array();
    try {
        $this->conexion = ConexionBD::getconexion();
   
        foreach ($items as $item) {
            $sql .= "(?, ?, ?),";
            $values[] = $idCotizacion;
            $values[] = $item['id']; // Accede al id del producto
            $values[] = $item['qty']; // Accede a la cantidad del producto
        }
   
        // Elimina la coma extra al final de la cadena SQL
        $sql = rtrim($sql, ',');
   
        // Preparar la declaración
        $query = $this->conexion->prepare($sql);
   
        // Ejecutar la declaración para cada conjunto de valores
        $query->execute($values);
        
        // No necesitas obtener el ID de la venta insertada, ya que estás insertando en una tabla de relación muchos a muchos
   
        return true; // Retorna verdadero si la inserción fue exitosa
    } catch (PDOException $ex) {
        echo "Error: " . $ex->getMessage();
        return false;
    } finally {
        $this->conexion = null;
    }
}

function actualizarProductos($idCotizacion, $items) {
    $sql = "INSERT INTO productos_cotizacion (idCotizacion, id_producto, cantidad) VALUES ";
   
    $values = array();
    try {
        $this->conexion = ConexionBD::getconexion();
      // Eliminar registros existentes para el idCotizacion dado
      $sql_delete = "DELETE FROM productos_cotizacion WHERE idCotizacion = ?";
      $query_delete = $this->conexion->prepare($sql_delete);
      $query_delete->execute([$idCotizacion]);

        foreach ($items as $item) {
            $sql .= "(?, ?, ?),";
            $values[] = $idCotizacion;
            $values[] = $item['id']; // Accede al id del producto
            $values[] = $item['qty']; // Accede a la cantidad del producto
        }
   
        // Elimina la coma extra al final de la cadena SQL
        $sql = rtrim($sql, ',');
   
        // Preparar la declaración
        $query = $this->conexion->prepare($sql);
   
        // Ejecutar la declaración para cada conjunto de valores
        $query->execute($values);
        
        // No necesitas obtener el ID de la venta insertada, ya que estás insertando en una tabla de relación muchos a muchos
   
        return true; // Retorna verdadero si la inserción fue exitosa
    } catch (PDOException $ex) {
         // Cancela la transacción en caso de error
         $this->conexion->rollBack();
         // Registra el error
        echo "Error: " . $ex->getMessage();
        return false;
    } finally {
        $this->conexion = null;
    }
}
/*
function actualizarProductos($idCotizacion, $items){
    try {
        $this->conexion = ConexionBD::getconexion();

        $sql = "UPDATE productos_cotizacion SET cantidad = ? WHERE idCotizacion = ? AND id_producto = ?";
        $query = $this->conexion->prepare($sql);

        foreach ($items as $item) {
            $query->execute([$item['qty'], $idCotizacion, $item['id']]);
        }

        return true;
    } catch (PDOException $ex) {
        echo "Error: " . $ex->getMessage();
        return false;
    } finally {
        $this->conexion = null;
    }
}


function actualizarProductos($idCotizacion, $items){
    
      try{
        $this->conexion = ConexionBD::getconexion();

      // Llamar a insertOrderItems con el ID de la cotización
      $sql = "UPDATE productos_cotizacion SET id_producto = ?,  cantidad = ? WHERE idCotizacion = ?;";
  
      $values = array();        
          foreach ($items as $item) {
              $sql .= "(?, ?, ?),";
              $values[] = $idCotizacion;
              $values[] = $item['id']; // Accede al id del producto
              $values[] = $item['qty']; // Accede a la cantidad del producto
          }
     
          // Elimina la coma extra al final de la cadena SQL
          $sql = rtrim($sql, ',');
       // Preparar la declaración
       $query = $this->conexion->prepare($sql);
   
       // Ejecutar la declaración para cada conjunto de valores
      $resultado =  $query->execute($values);
       
       // No necesitas obtener el ID de la venta insertada, ya que estás insertando en una tabla de relación muchos a muchos
  
       return $resultado; // Retorna verdadero si la inserción fue exitosa
   } catch (PDOException $ex) {
       echo "Error: " . $ex->getMessage();
       return false;
   } finally {
       $this->conexion = null;
   }

}
*/
}