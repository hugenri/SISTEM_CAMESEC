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


}