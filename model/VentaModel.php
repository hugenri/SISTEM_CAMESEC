<?php

require_once("conexion.php");//se lo importa el archivo de la conexion 


class VentaModel{

private $conexion;//variable para el objeto de la conexion 

public function __construct(){

$this->conexion = null;

    }
//Función para obtener los registros de orden compra
public function getProductos($searchTerm){
        
    try{
    
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
          ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
        $query = $this->conexion->prepare("SELECT * FROM producto where nombre LIKE :searchTerm;");
        
        //se ejecuta la consulta sql
        $query->execute(array(':searchTerm' => '%' . $searchTerm . '%'));
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

public function getProductoId($id){
 
        
  try{
    
    //se crea la conexion a la base de datos
    $this->conexion = ConexionBD::getconexion();
      ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
    $query = $this->conexion->prepare("SELECT * FROM producto WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    // Obtenemos el resultado como un array asociativo
    $product = $query->fetch(PDO::FETCH_ASSOC);

    if($product){//si se regresan datos de la consulta se ejecuta este bloque 
        
      return $product;
    }else{//si no hay datos se ejecuta este bloque
         return 0;
    }
   } catch (Exception $ex) {//se captura algún error tipo de error
      echo "Error". $ex;// se imprime el tipo de error 

    } finally {
      $this->conexion = null;//se cierra la conexión 
    }

}

public function registrarVenta($idProducto, $idCliente, $fechaVenta, $cantidad, $total) {
  try {
      $this->conexion = ConexionBD::getconexion();

      

      // Preparar la consulta SQL para insertar la venta
      $query = $this->conexion->prepare("INSERT INTO ventas_productos (id_producto, id_cliente, fecha_venta, cantidad, total) VALUES (:idProducto, :idCliente, :fechaVenta, :cantidad, :total)");

      // Convertir el total a string para mantener la precisión de los números decimales
      $totalStr = strval($total);

      // Asignar valores a los parámetros de la consulta
      $query->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
      $query->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
      $query->bindParam(':fechaVenta', $fechaVenta, PDO::PARAM_STR);
      $query->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
      $query->bindParam(':total', $totalStr, PDO::PARAM_STR);

      // Ejecutar la consulta
      $query->execute();

      // Obtener el ID de la venta insertada
      $idVenta = $this->conexion->lastInsertId();

      return $idVenta;
  } catch (PDOException $ex) {
      echo "Error: " . $ex->getMessage();
      return false;
  } finally {
      $this->conexion = null;
  }
}

function insertOrderItems($userId, $fecha, $total, $cartItems) {
 // $sql = "INSERT INTO orden_articulos (order_id, product_id, quantity) VALUES ";
$sql = "INSERT INTO ventas_productos(id_producto, id_cliente, fecha_venta, cantidad, total) VALUES ";

 $values = array();
 try {
  $this->conexion = ConexionBD::getconexion();

  foreach ($cartItems as $item) {
      $sql .= "(?, ?, ?, ?, ?),";
      $values[] = $item['id'];
      $values[] = $userId;
      $values[] = $fecha;
      $values[] = $item['qty'];
      $values[] = $total;
  }

  // Elimina la coma extra al final de la cadena SQL
  $sql = rtrim($sql, ',');

  // Preparar la declaración
  $query = $this->conexion->prepare($sql);

  // Ejecutar la declaración para cada conjunto de valores
  $query->execute($values);
  // Obtener el ID de la venta insertada
  $idVenta = $this->conexion->lastInsertId();

   return $idVenta;
   }catch (PDOException $ex) {
      echo "Error: " . $ex->getMessage();
      return false;
    } finally {
      $this->conexion = null;
    }
}


}