<?php

require_once("conexion.php");//se lo importa el archivo de la conexion 

class AdminModel{
private $conexion;//variable para el objeto de la conexion 

public function __construct(){
$this->conexion = null;
    }

public function userExists($email){

        try{

            //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();

              ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
            $query = $this->conexion->prepare("SELECT * FROM usuarios WHERE email = :email;");

            // se vinculan los parámetro de la consulta con las variables
            $query->bindParam(":email", $email);
            //se ejecuta la consulta sql
            $query->execute();
            $result = $query->fetchColumn();
    // Comprobar si el usuario existe
    if ($result > 0) {

              return true;

            }else{//si no hay datos se ejecuta este bloque

                 return false;

            }

    } catch (Exception $ex) {//se captura algún error tipo de error

     echo "Error". $ex;// se imprime el tipo de error 

    } finally {

      $this->conexion = null;//se cierra la conexión 

    }
}


public function createAdmin($nombre, $apellidoP, $apellidoM, $email, $password, $rol){

    try{
        $this->conexion = ConexionBD::getconexion();  //se crea la conexion a la base de datos

         // se establece la sentencia de la consulta sql

$sql="INSERT INTO usuarios (nombre, apellidoPaterno, apellidoMaterno,email, password, rol_usuario) VALUES (:nombre,:apellidoP, :apellidoM, :email, :password, :rol);";

//se  prepara la sentencia de la  consulta sql

$query = $this->conexion->prepare($sql);
//se vincula un parámetro al nombre de variable especificado 

$query->bindParam(':nombre',$nombre);
$query->bindParam(':apellidoP',$apellidoP);
$query->bindParam(':apellidoM',$apellidoM);
$query->bindParam(':email',$email);
$query->bindParam(':password',$password);
$query->bindParam(':rol',$rol);
//Se ejecuta la consulta en la base de datos

$resultado = $query->execute();

    if($resultado === TRUE){//si se retorna true se eltra en este bloque if



            return true; //se retorna true

    }else{//si no

        return false;//se retorna false

    }       

} catch (Exception $ex) { //se captura  el error que ocurra en el bloque try

echo "Error". $ex;



} finally {

   $this->conexion = null; //se cierra la conexión 

}

}

}