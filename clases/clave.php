<?php

class Clave{
// Función para generar una clave
function generarClave() {
    $longitud = rand(9, 15); // Longitud aleatoria entre 9 y 15 caracteres
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+[]{}|;:,.<>?'; // Caracteres permitidos
    $clave = '';

    for ($i = 0; $i < $longitud; $i++) {
        $clave .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }

    return $clave;
}
}