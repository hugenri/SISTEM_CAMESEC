<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

class UploadImage {

    
    private $fileImage;
    private $extension;
    private $carpetaDestino; 
	
    public function __construct() {
        
    }

    public function guardarImagen($target_dir, $fileImage, $temp) {
        $this->fileImage = $fileImage;
        // Validar si es una imagen válida
        $this->extension = strtolower(pathinfo($this->fileImage, PATHINFO_EXTENSION));

        if (!$this->esImagenValida($this->extension)) {
            return false;
        }
    
        // Validar si existe la carpeta de destino
        if (!$this->existeCarpetaDestino($target_dir)) {
            return false;
        }
    
        // Generar un nuevo nombre único para la imagen
        $imageName = $this->generarNombreUnico($this->extension);

        $rutaAbsoluta = realpath($target_dir);
        // Construir la ruta completa de destino
        $rutaCompleta = $rutaAbsoluta . DIRECTORY_SEPARATOR . $imageName;          // Mover la imagen a la carpeta de destino con el nuevo nombre
        if (move_uploaded_file($temp, $rutaCompleta)) {
           // return $imageName;
            return $imageName;

        } else {
            return false;
        }
    }
    

    public function esImagenValida($extension) {
        $extensionesValidas = array("jpg", "jpeg", "png", "gif");

        if (!in_array($extension, $extensionesValidas)) {
            return false;
        }

        // Puedes agregar más validaciones según tus necesidades, como verificar el tipo MIME, tamaño, etc.

        return true;
    }

    public function existeCarpetaDestino($carpetaDestino) {
        $this->carpetaDestino = realpath($carpetaDestino) . '/';

        if (!file_exists($this->carpetaDestino) || !is_dir($this->carpetaDestino)) {
            return false;
        }

        return true;
    }

    public function generarNombreUnico($extension) {
        // Generar un nombre único basado en la fecha y hora actual
        $timestamp = time();
        $nombreUnico = "imagen_" . $timestamp . "." . $extension;

        return $nombreUnico;
    }
}


