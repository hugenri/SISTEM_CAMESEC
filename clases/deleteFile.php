<?php

class DeleteFile {

    public function delete_File($filePath) {
        try {
            // Verificar si el archivo existe antes de intentar eliminarlo
            if (file_exists($filePath)) {
                // Intentar eliminar el archivo
                unlink($filePath);
                return true; // Devolver verdadero si se eliminó con éxito
            } else {
                return false; // Devolver falso si el archivo no existe
            }
        } catch (Exception $ex) {
            // Manejar cualquier excepción que pueda ocurrir durante la eliminación del archivo
            echo "Error al intentar eliminar el archivo: " . $ex->getMessage();
            return false;
        }
    }
}

