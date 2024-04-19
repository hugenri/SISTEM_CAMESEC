<?php
require_once("../model/conexion.php");//se lo importa el archivo de la conexion 


class ConsultaBaseDatos{
    private $conexion;//variable para el objeto de la conexion 

    // Método para ejecutar consultas
    public static function ejecutarConsulta($sql, $parametros = [], $regresarDatos = false, $filas = "all") {
        try {
            //se crea la conexion a la base de datos
            $conexion = ConexionBD::getconexion();
            // Preparar la consulta
            $consulta = $conexion->prepare($sql);
 
            // Ejecutar la consulta
            $consulta->execute($parametros);

            // Dependiendo del tipo de consulta y del parámetro $returnData, manejar el resultado
            if ($regresarDatos) {
                if($filas == "all"){
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $consulta->fetch(PDO::FETCH_ASSOC);
            }
            } elseif (strpos($sql, 'INSERT') === 0) {
                // Si es una inserción, devolver el último ID insertado
                return $conexion->lastInsertId();
            } else {
                // Para otras consultas como update o delete, devolver true si se ejecutan correctamente
                return true;
            }
        } catch (PDOException $e) {
            // Manejar cualquier error de la base de datos
            throw new Exception('Error en la consulta: ' . $e->getMessage());
        }finally {

            $conexion = null;//se cierra la conexión 
      
          }
    }
}
