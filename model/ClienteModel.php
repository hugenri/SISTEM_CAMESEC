<?php

require_once("conexion.php");//se lo importa el archivo de la conexion 


class ClienteModel{

private $conexion;//variable para el objeto de la conexion 

public function __construct(){

$this->conexion = null;

    }

    public function getClients(){
        
        try{
        
            //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();
              ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
            $query = $this->conexion->prepare("SELECT * FROM cliente;");
            
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
public function clientExists($email){

        try{
            //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();

              ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta

            $query = $this->conexion->prepare("SELECT * FROM cliente WHERE email = :email;");

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

public function createClient($razonSocial, $nombre, $apellidoPaterno, $apellidoMaterno,  $calle, $numero, $colonia, 
    $municipio, $estado, $cp, $email, $telefono, $password) {
    try {
        $this->conexion = ConexionBD::getconexion(); // Se crea la conexión a la base de datos

        // Se establece la sentencia de la consulta SQL
        $sql = "INSERT INTO cliente (razonSocial, nombre, apellidoPaterno, apellidoMaterno,
         calle, numero, colonia, municipio, estado, cp, email, telefono, password)
          VALUES (:razonSocial, :nombre, :apellidoPaterno, :apellidoMaterno,
            :calle, :numero, :colonia, :municipio,
                :estado, :cp, :email, :telefono, :password);";

        // Se prepara la sentencia de la consulta SQL
        $query = $this->conexion->prepare($sql);

        // Se vincula cada parámetro al nombre de variable especificado
        $query->bindParam(':razonSocial', $razonSocial);
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':apellidoPaterno', $apellidoPaterno);
        $query->bindParam(':apellidoMaterno', $apellidoMaterno);
        $query->bindParam(':calle', $calle);
        $query->bindParam(':numero', $numero);
        $query->bindParam(':colonia', $colonia);
        $query->bindParam(':municipio', $municipio);
        $query->bindParam(':estado', $estado);
        $query->bindParam(':cp', $cp);
        $query->bindParam(':email', $email);
        $query->bindParam(':telefono', $telefono);
        $query->bindParam(':password', $password);


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



//Función para borrar registro

public function deleteClient($id){

    try{ // bloque try-catch, se capturan las  excepciones 
            $this->conexion = ConexionBD::getconexion();//se crea la conexión a la BD
            // se establece la sentencia de la consulta sql
            $sql = "DELETE FROM cliente WHERE idCliente = :id;";
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
    public function updateClient($id, $razonSocial, $nombre, $apellidoPaterno, $apellidoMaterno, 
                               $informacionContacto,  $numero, $calle, $colonia, 
                               $municipio, $estado, $cp, $email, $telefono,
                                $otrosDetalles) {
        try{
            $this->conexion = ConexionBD::getconexion();//se crea la conexión a la BD

    // se establece la sentencia de la consulta sql para actualizar datos de un registro
    $sql = "UPDATE cliente
        SET razonSocial = :razonSocial, 
            nombre = :nombre, 
            apellidoPaterno = :apellidoPaterno, 
            apellidoMaterno = :apellidoMaterno, 
            informacionContacto = :informacionContacto, 
            calle = :calle, 
            numero = :numero, 
            colonia = :colonia, 
            municipio = :municipio, 
            estado = :estado, 
            cp = :cp, 
            email = :email, 
            telefono = :telefono, 
            otrosDetalles = :otrosDetalles
        WHERE idCliente = :idCliente;";
        
    //se  prepara la sentencia de la  consulta sql
    $query = $this->conexion->prepare($sql);
     // Se vincula cada parámetro al nombre de variable especificado
     $query->bindParam(':idCliente', $id);
     $query->bindParam(':razonSocial', $razonSocial);
     $query->bindParam(':nombre', $nombre);
     $query->bindParam(':apellidoPaterno', $apellidoPaterno);
     $query->bindParam(':apellidoMaterno', $apellidoMaterno);
     $query->bindParam(':informacionContacto', $informacionContacto);
     $query->bindParam(':calle', $calle);
     $query->bindParam(':numero', $numero);
     $query->bindParam(':colonia', $colonia);
     $query->bindParam(':municipio', $municipio);
     $query->bindParam(':estado', $estado);
     $query->bindParam(':cp', $cp);
     $query->bindParam(':email', $email);
     $query->bindParam(':telefono', $telefono);
     $query->bindParam(':otrosDetalles', $otrosDetalles);
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
    public function getNumerClients(){

        try{
            //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();
              $sql = "SELECT COUNT(*) as numRegistros FROM cliente";
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

}