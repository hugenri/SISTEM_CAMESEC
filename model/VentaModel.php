<?php

include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if ($session->getSessionVariable('rol_usuario') != 'cliente') {
  $site = $session->checkAndRedirect();
  header('location:' . $site);
}

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

function insertOrderItems($userId, $fecha, $cartItems) {
  try {
    // Establecer la conexión a la base de datos
    $this->conexion = ConexionBD::getconexion();

    // Iniciar una transacción
    $this->conexion->beginTransaction();

    // Insertar en la tabla ventas
    $sqlVentas = "INSERT INTO ventas(id_cliente, fecha_venta, total) VALUES (?, ?, ?)";
    $queryVentas = $this->conexion->prepare($sqlVentas);

    // Calcular el monto total de la venta
    $total = 0;
    foreach ($cartItems as $item) {
      $total += $item['subtotal']; // Sumar el subtotal de cada artículo del carrito
    }

    // Ejecutar la consulta para la tabla ventas
    $queryVentas->execute([$userId, $fecha, $total]);

    // Obtener el último id_venta insertado
    $idVenta = $this->conexion->lastInsertId();

    // Insertar en la tabla ventas_productos
    $sqlVentasProductos = "INSERT INTO ventas_productos(id_venta, id_producto, cantidad) VALUES ";
    $values = [];

    foreach ($cartItems as $item) {
      $sqlVentasProductos .= "(?, ?, ?),";
      $values[] = $idVenta;
      $values[] = $item['id'];
      $values[] = $item['qty'];
    }

    // Eliminar la coma final
    $sqlVentasProductos = rtrim($sqlVentasProductos, ',');

    // Preparar la consulta para la tabla ventas_productos
    $queryVentasProductos = $this->conexion->prepare($sqlVentasProductos);

    // Ejecutar la consulta para la tabla ventas_productos
    $queryVentasProductos->execute($values);

    
    // Insertar en la tabla pagos_productos solo con id_venta
    $sqlPagos = "INSERT INTO pagos_venta (id_venta) VALUES (?)";
    $queryPagos = $this->conexion->prepare($sqlPagos);

    // Ejecutar la consulta para la tabla pagos_productos
    $queryPagos->execute([$idVenta]);

    // Confirmar la transacción
    $this->conexion->commit();

    return $idVenta;
  } catch (PDOException $ex) {
    // Revertir la transacción en caso de error
    $this->conexion->rollBack();
    echo "Error: " . $ex->getMessage();
    return false;
  } finally {
    // Cerrar la conexión a la base de datos
    $this->conexion = null;
  }
}

/*
function insertOrderItems($userId, $fecha, $cartItems) {
 // $sql = "INSERT INTO orden_articulos (order_id, product_id, quantity) VALUES ";
$sql = "INSERT INTO ventas_productos(id_producto, id_cliente, fecha_venta, cantidad, total) VALUES ";

 $values = array();
 try {
  $this->conexion = ConexionBD::getconexion();

  foreach ($cartItems as $item) {
    $sql .= "(?, ?, ?, ?, ?),";
    $values[] = $item['id']; // Accede al ID del producto
    $values[] = $userId;
    $values[] = $fecha;
    $values[] = $item['qty']; // Accede a la cantidad del producto
    $values[] = $item['subtotal']; // Suponiendo que subtotal es el total para este producto
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
*/

}