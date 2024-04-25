<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Session
{
   

public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function checkAndRedirect()
    {
        if (isset($_SESSION['rol_usuario'])) {
            $user = $_SESSION['rol_usuario'];
            $site = $this->authorizeSiteRol($user);

            if (!empty($site)) {
                return $site . '.php';
            } else {
                return 'pagina_de_error.php';
            }
        } else {
            return 'sesion.php';
        }
    }

    function authorizeSiteRol($role)
    {
        switch ($role) {
            case 'admin':
                return 'admin';
                break;
            case 'cliente':
                return 'home';
                break;
            case 'empleado':
                return 'tecnico';
                break;
            default:
                return '';
        }
    }

    public function startSessionData($sessionData)
    {
        foreach ($sessionData as $sessionName => $value) {
            $_SESSION[$sessionName] = $value;
        }
    }

    public function destroySession()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
    }
    header("Location: ../index.php");
    exit;
}


    public function getSessionVariable($variableName)
    {
        if (isset($_SESSION[$variableName])) {
            return $_SESSION[$variableName];
        } else {
            return null;
        }
    }
}

