<?php

require_once("conexion.php");//se lo importa el archivo de la conexion 


class UsuarioModel{
private $conexion;//variable para el objeto de la conexion 
public function __construct(){
$this->conexion = null;

    }
public function getUsers(){

    try{

        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();

          ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
        $query = $this->conexion->prepare("SELECT * FROM usuarios;");

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

public function resetPasswordPassword($email, $password) {

  try {

      //se crea la conexion a la base de datos
      $this->conexion = ConexionBD::getconexion();
      // Consulta SQL para actualizar la contraseña
      $sql = "UPDATE usuarios SET password = :passw WHERE email = :email";
      $query = $this->conexion->prepare($sql);
      $query->bindParam(':passw', $password);
      $query->bindParam(':email', $email);
      // Ejecutar la consulta
      $success = $query->execute();
      // Verificar si la actualización se realizó correctamente

      if ($success) {

          return true;

      } else {

          return false;

      }

  } catch (PDOException $e) {

      // Manejo de error personalizado

      throw new Exception("Error al restablecer la contraseña: " . $e->getMessage());

  } finally {

      $this->conexion = null; // se cierra la conexión

  }

}



//Función para borrar registro

public function deleteUser($id){

    try{ // bloque try-catch, se capturan las  excepciones 
            $this->conexion = ConexionBD::getconexion();//se crea la conexión a la BD
            // se establece la sentencia de la consulta sql
            $sql = "DELETE FROM usuarios WHERE id= :id;";
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
public function updateUser($id, $nombre, $apellidoP, $apellidoM, $email, $rol){

        try{
            $this->conexion = ConexionBD::getconexion();//se crea la conexión a la BD

    // se establece la sentencia de la consulta sql para actualizar datos de un registro
    $sql="UPDATE usuarios SET nombre =:nombre, apellidoPaterno = :apellidoPaterno, apellidoMaterno = :apellidoMaterno, rol_usuario = :rol ,email = :email WHERE id = :id;";

    //se  prepara la sentencia de la  consulta sql

    $query = $this->conexion->prepare($sql);
    // se vinculan los parámetro de la consulta con las variables
    $query->bindParam(':nombre',$nombre);
    $query->bindParam(':apellidoPaterno',$apellidoP);
    $query->bindParam(':apellidoMaterno',$apellidoM);
    $query->bindParam(':email',$email);
    $query->bindParam(':id',$id);
    $query->bindParam(':rol',$rol);


   // Ejecutar la consulta
   $result = $query->execute();
   // Verificar si la actualización se realizó correctamente
   if ($result == true) {
       return true;
   } else {
       return false;
   }
    } catch (Exception $ex) { //se captura  el error que ocurra en el bloque try
    echo "Error". $ex;
    } finally {
       $this->conexion = null; //se cierra la conexión a la BD

    }

    }



    public function createUser($nombre, $apellidoP, $apellidoM, $email, $password, $rol = 'usuario'){

        try{
            $this->conexion = ConexionBD::getconexion();  //se crea la conexion a la base de datos

             // se establece la sentencia de la consulta sql
    $sql="INSERT INTO usuarios (nombre, apellidoPaterno, apellidoMaterno,rol_usuario, email, password) VALUES (:nombre,:apellidoP, :apellidoM, :rol ,:email, :password);";
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
    
public function verifyUserExists($nombre, $apellidoP, $apellidoM, $email){

        try{
            //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();
              ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
            $query = $this->conexion->prepare("SELECT * FROM usuarios WHERE (
			nombre = :nombre AND apellidoPaterno = :apellidoP AND apellidoMaterno = :apellidoM AND email = :email) OR (email = :email);");
            // se vinculan los parámetro de la consulta con las variables
            $query->bindParam(":nombre", $nombre);
			$query->bindParam(":apellidoP", $apellidoP);
            $query->bindParam(":apellidoM", $apellidoM);
            $query->bindParam(":email", $email);
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

public function login($email){

    try{
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
          ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
        $query = $this->conexion->prepare("SELECT * FROM usuarios WHERE email = :email;");
        // se vinculan los parámetro de la consulta con las variables
        $query->bindParam(":email", $email);

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

public function getNumerUsers(){

    try{
        //se crea la conexion a la base de datos
        $this->conexion = ConexionBD::getconexion();
          $sqlUsuarios = "SELECT COUNT(*) as numRegistros FROM usuarios";
           ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
           $query = $this->conexion->prepare($sqlUsuarios);
        //se ejecuta la consulta sql
        $query->execute();
       //se obtiene un array con todos los registros de los resultados
        $resultUsers = $query->fetch(PDO::FETCH_ASSOC);
        return $resultUsers['numRegistros']; // Devolver el número de registros
       } catch (Exception $ex) {//se captura algún error tipo de error

             echo "Error". $ex;// se imprime el tipo de error 
      } finally {

         $this->conexion = null;//se cierra la conexión 
     }


}

}

