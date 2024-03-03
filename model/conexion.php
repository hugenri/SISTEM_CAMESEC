<?php

require_once "../config/config.php";

class ConexionBD {
    public static function getConexion() {
        $conexion = null;
        try {
            $conexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Caracteres utf8
            $conexion->exec("SET CHARACTER SET " . DB_ENCODE);
        } catch (PDOException $ex) {
            echo 'Error en conexión: ' . $ex->getMessage();
        }

        return $conexion;
    }
}
