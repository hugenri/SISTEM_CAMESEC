<?php

require_once("conexion.php");//se lo importa el archivo de la conexion 


class SolicitudCotizacionModel{

private $conexion;//variable para el objeto de la conexion 

public function __construct(){

$this->conexion = null;

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

//Función para obtener los registros
public function getSolicitudCotizaciones($idCliente){
        
    try{
    
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
          ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
         
         /*
         $sql = "SELECT sc.*, c.idCotizacion 
         FROM solicitudes_cotizacion sc 
         INNER JOIN cotizaciones c ON sc.id = c.idSolicitudCotizacion 
         WHERE sc.id_cliente = :id;";
         */
        $sql = "SELECT *
        FROM solicitudes_cotizacion 
        WHERE id_cliente = :id;";

          $query = $this->conexion->prepare($sql);
          $query->bindParam(':id', $idCliente);
          

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

//Función para obtener un regidtro
public function getSolicitud_cotizacion_Servicio($servicio, $idCliente){
    try {
        $this->conexion = ConexionBD::getconexion();
        $query = $this->conexion->prepare("SELECT COUNT(*) as count FROM solicitudes_cotizacion 
                                           WHERE servicio = :servicio AND id_cliente = :idCliente AND estado = 'en proceso';");
        $query->bindParam(':servicio', $servicio);
        $query->bindParam(':idCliente', $idCliente);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($row['count'] > 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $ex) {
        // Manejar  el error 
        throw new Exception("Error al obtener la solicitud de cotización del servicio: " . $ex->getMessage());
    } finally {
        $this->conexion = null;
    }
}

//Función para obtener los registros
public function getSolicitudesCotizacion($sql){
        
    try{
    
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
        
          ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
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


//método para actualizar los datos 
public function updateEstado($id, $estado) {
    try {
        $this->conexion = ConexionBD::getconexion(); // se crea la conexión a la BD
        // se establece la sentencia de la consulta sql para actualizar datos de un registro
        $sql = "UPDATE solicitudes_cotizacion
        SET estado = :estado
        WHERE id = :id;";

        // se prepara la sentencia de la consulta sql
        $query = $this->conexion->prepare($sql);
        // se vinculan los parámetros al nombre de variable especificado
        $query->bindParam(':id', $id);
        $query->bindParam(':estado', $estado);
    
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

}