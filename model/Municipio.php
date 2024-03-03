<?php
require_once("conexion.php");//se lo importa el archivo de la conexion 

class Municipio {
	
	private $conexion;//variable para el objeto de la conexion 

public function __construct(){
$this->conexion = null;
}   

    public function obtenerMunicipiosSelect($idEstado) {
       //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();
        try {
            $query = "SELECT id, municipio FROM t_municipio WHERE id_estado = :idEstado";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':idEstado', $idEstado, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejar el error de la manera que consideres apropiada
            // Puedes logear el error, mostrar un mensaje al usuario, etc.
            echo "Error al obtener municipios: " . $e->getMessage();
            return []; // Devolver un array vacío en caso de error
        } finally {
            $this->conexion = null; // Asegurar que se cierre la conexión incluso en caso de error
        }
    }
}
