<?php
require_once("conexion.php");//se lo importa el archivo de la conexion 


class Estado {
	private $conexion;//variable para el objeto de la conexion 

public function __construct(){
$this->conexion = null;
}
   public function obtenerEstadosSelect() {
        //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();
        try {
            $query = "SELECT id, estado FROM t_estado";
            $statement = $this->conexion->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejar el error de la manera que consideres apropiada
            // Puedes logear el error, mostrar un mensaje al usuario, etc.
            echo "Error al obtener estados: " . $e->getMessage();
            return []; // Devolver un array vacío en caso de error
        } finally {
            $this->conexion = null; // Asegurar que se cierre la conexión incluso en caso de error
        }
    }
	
    public function obtenerIdEstadoPorNombre($nombreEstado) {
        $this->conexion = ConexionBD::getconexion();
        try {
            $query = "SELECT id FROM t_estado WHERE estado = :nombre";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':nombre', $nombreEstado, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['id'];
            } else {
                return null; // Retorna null si el estado no se encuentra
            }
        } catch (PDOException $e) {
            echo "Error al obtener ID del estado: " . $e->getMessage();
            return null;
        } finally {
            $this->conexion = null;
        }
    }

}