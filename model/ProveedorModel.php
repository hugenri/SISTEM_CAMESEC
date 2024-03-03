<?php

require_once("conexion.php");//se lo importa el archivo de la conexion 


class ProveedorModel{

private $conexion;//variable para el objeto de la conexion 

public function __construct(){

$this->conexion = null;

    }

    public function getProvider(){
        
        try{
        
            //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();
              ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
            $query = $this->conexion->prepare("SELECT * FROM proveedor;");
            
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
public function providerExists($email){

        try{
            //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();

              ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta

            $query = $this->conexion->prepare("SELECT * FROM proveedor WHERE email = :email;");

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

public function createProvider($razonSocial, $nombre, $apellidoPaterno, $apellidoMaterno, $informacionContacto, $calle, $numero, $colonia, 
    $municipio, $estado, $cp, $email, $telefono, $otrosDetalles) {
    try {
        $this->conexion = ConexionBD::getconexion(); // Se crea la conexión a la base de datos

        // Se establece la sentencia de la consulta SQL
        $sql = "INSERT INTO proveedor (razonSocial, nombre, apellidoPaterno,
                                         apellidoMaterno,
                                       informacionContacto, calle, 
                                       numero, colonia, municipio, estado, cp,
                                        email, telefono, otrosDetalles) VALUES (:razonSocial,
                                        :nombre, :apellidoPaterno,
                                        :apellidoMaterno, :informacionContacto,
                                         :calle, :numero, :colonia, :municipio, 
                                        :estado, :cp, :email, :telefono, :otrosDetalles);";

        // Se prepara la sentencia de la consulta SQL
        $query = $this->conexion->prepare($sql);

        // Se vincula cada parámetro al nombre de variable especificado
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

public function deleteProvider($id){

    try{ // bloque try-catch, se capturan las  excepciones 
            $this->conexion = ConexionBD::getconexion();//se crea la conexión a la BD
            // se establece la sentencia de la consulta sql
            $sql = "DELETE FROM proveedor WHERE idProveedor = :id;";
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
    public function updateProvider($id, $razonSocial, $nombre, 
                                   $apellidoPaterno, $apellidoMaterno, 
                               $informacionContacto,  $numero, $calle, $colonia, 
                               $municipio, $estado, $cp, $email, $telefono,
                                $otrosDetalles, $categoria) {
        try{
            $this->conexion = ConexionBD::getconexion();//se crea la conexión a la BD

    // se establece la sentencia de la consulta sql para actualizar datos de un registro
    $sql = "UPDATE proveedor 
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
            otrosDetalles = :otrosDetalles,
            idCategoria = :categoria 
             WHERE idProveedor = :idProveedor;";
        
    //se  prepara la sentencia de la  consulta sql
    $query = $this->conexion->prepare($sql);
     // Se vincula cada parámetro al nombre de variable especificado
     $query->bindParam(':idProveedor', $id);
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
     $query->bindParam(':categoria', $categoria);

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

    public function getNumerProviders(){

        try{
            //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();
              $sqlUsuarios = "SELECT COUNT(*) as numRegistros FROM proveedor";
               ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
               $query = $this->conexion->prepare($sqlUsuarios);
            //se ejecuta la consulta sql
            $query->execute();
           //se obtiene un array con todos los registros de los resultados
            $resultProviders = $query->fetch(PDO::FETCH_ASSOC);
            return $resultProviders['numRegistros']; // Devolver el número de registros
           } catch (Exception $ex) {//se captura algún error tipo de error
    
                 echo "Error". $ex;// se imprime el tipo de error 
          } finally {
    
             $this->conexion = null;//se cierra la conexión 
         }
    }
    public function assignCategory($categoria, $idProveedor){

        try{
            //se crea la conexion a la base de datos
            $this->conexion = ConexionBD::getconexion();
            // Realiza la consulta de actualización
            $sql = "UPDATE proveedor SET idCategoria = :categoria WHERE idProveedor = :idProveedor";
               ////se  prepara la sentencia de la  consulta sql para su ejecución y se devuelve un objeto de la consulta
               $query = $this->conexion->prepare($sql);
               $query->bindParam(':categoria', $categoria);
               $query->bindParam(':idProveedor', $idProveedor);
            //se ejecuta la consulta sql
           $result = $query->execute();
            if ($result === true) { // Si se retorna true se entra en este bloque if
                return true; // Se retorna true
            } else { // Si no
                return false; // Se retorna false
            }
           } catch (Exception $ex) {//se captura algún error tipo de error
    
                 echo "Error". $ex;// se imprime el tipo de error 
          } finally {
    
             $this->conexion = null;//se cierra la conexión 
         }
    }



}