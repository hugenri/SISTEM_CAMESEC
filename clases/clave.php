<?php

class Clave{
// Función para generar una clave
function generarClave() {
    $longitud = rand(9, 15); // Longitud aleatoria entre 9 y 15 caracteres
    
    // Definir subconjuntos de caracteres
    $letrasMinusculas = 'abcdefghijklmnopqrstuvwxyz';
    $letrasMayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numeros = '0123456789';
    $caracteresEspeciales = '@#$%&*+[]{};:,.';
   
    // Combinar los subconjuntos de caracteres
    $caracteres = $letrasMinusculas . $letrasMayusculas . $numeros . $caracteresEspeciales;

    $clave = '';

    // Asegurar que haya al menos un carácter de cada subconjunto
    $clave .= $letrasMinusculas[rand(0, strlen($letrasMinusculas) - 1)];
    $clave .= $letrasMayusculas[rand(0, strlen($letrasMayusculas) - 1)];
    $clave .= $numeros[rand(0, strlen($numeros) - 1)];
    $clave .= $caracteresEspeciales[rand(0, strlen($caracteresEspeciales) - 1)];

    // Generar el resto de la clave
    for ($i = 0; $i < ($longitud - 4); $i++) {
        $clave .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }

    // Mezclar la clave para mayor seguridad
    $clave = str_shuffle($clave);
    // Quitar espacios en blanco dentro de la clave
    $clave = str_replace(' ', '', $clave);
    return trim($clave);
}
}
//en el servidor
/*
// Función para generar una clave
    function generarClave() {
        // Longitud aleatoria entre 9 y 15 caracteres
        $longitud = rand(9, 15); 

        // Definir subconjuntos de caracteres
        $letrasMinusculas = 'abcdefghijklmnopqrstuvwxyz';
        $letrasMayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numeros = '0123456789';
        $caracteresEspeciales = '@#$%&*+[]{};:,.';

        // Combinar los subconjuntos de caracteres
        $caracteres = $letrasMinusculas . $letrasMayusculas . $numeros . $caracteresEspeciales;

        $clave = '';

        // Asegurar que haya al menos un carácter de cada subconjunto
        $clave .= $letrasMinusculas[rand(0, strlen($letrasMinusculas) - 1)];
        $clave .= $letrasMayusculas[rand(0, strlen($letrasMayusculas) - 1)];
        $clave .= $numeros[rand(0, strlen($numeros) - 1)];
        $clave .= $caracteresEspeciales[rand(0, strlen($caracteresEspeciales) - 1)];

        // Generar el resto de la clave
        for ($i = 0; $i < ($longitud - 4); $i++) {
            $clave .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        // Ajustar la longitud de la clave si es necesario
        $clave = substr($clave, 0, $longitud);

        // Mezclar la clave para mayor seguridad
        $clave = str_shuffle($clave);

        // Quitar espacios en blanco dentro de la clave
        $clave = str_replace(' ', '', $clave);

        return trim($clave);
    }
    */