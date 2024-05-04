<?php

class Login_functions{

/*
La función authenticateUser se encarga de verificar las credenciales del usuario y autenticarlo si las credenciales son válidas. Toma dos conjuntos de datos, 
$dataUser y $dataCliente, que representan los datos del usuario y del cliente 
*/
function authenticateUser($dataUser, $dataCliente, $password) {
    global $validacion, $session;
    
    if (!empty($dataUser)) {
        if (password_verify($password, $dataUser['password'])) {
            // Autenticación exitosa para usuario
            $userData = [
                'nombre' => $dataUser['nombre'],
                'apellidoPaterno' => $dataUser['apellidoPaterno'],
                'apellidoMaterno' => $dataUser['apellidoMaterno'],
                'rol_usuario' => $dataUser['rol_usuario'],
				 'id_usuario' => $dataUser['id']
            ];
            $this->handleSuccessfulAuthentication($userData);
        }
    } elseif (!empty($dataCliente)) {
        if (password_verify($password, $dataCliente['password'])) {
            // Autenticación exitosa para cliente
            $clientData = [
                'id_cliente' => $dataCliente['idCliente'],
                'nombre' => $dataCliente['nombre'],
                'apellidoPaterno' => $dataCliente['apellidoPaterno'],
                'apellidoMaterno' => $dataCliente['apellidoMaterno'],
                'rol_usuario' => 'cliente'
            ];
            $this->handleSuccessfulAuthentication($clientData);
        }
    }
    
    // Si las credenciales son incorrectas
    $this->handleError('Contraseña incorrecta');
  
  }
  /*
  handleSuccessfulAuthentication se encarga de iniciar la sesión con los datos del usuario 
   proporcionados y redirigir al usuario a la página correspondiente
   */
  function handleSuccessfulAuthentication($userData) {
    global $session, $site;
    $session->startSessionData($userData);
    $site = $session->checkAndRedirect();
    $response = ['success' => true, 'url' => $site];
    echo json_encode($response);
    exit();
  }
  /*
  La función handleError se encarga de manejar los errores durante el proceso de autenticación. Toma un mensaje de error como argumento 
  ($message) y genera una respuesta JSON con un indicador de éxito false
  */
  function handleError($message) {
    $response = ['success' => false, 'message' => $message];
    echo json_encode($response);
    exit();
  }
}