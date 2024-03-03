<?php

class DataSanitizer {
    /**
     * Clase para limpiar y sanitizar datos enviados por POST para prevenir la inyección de código.
     */

    public static function sanitize_input($data) {
    /**
     * Limpia y sanitiza los datos enviados por POST.
    */
    if ($data !== null) {
        $sanitized_data = htmlspecialchars(stripslashes(trim($data)));
        return $sanitized_data;
    } else {
        return ''; // O maneja el caso de valor nulo de alguna otra manera
    }
}

  
}

