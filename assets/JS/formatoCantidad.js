function formatearNumero(numero) {
    // Verifica si el número es válido
    if (isNaN(numero)) {
        return "Número inválido";
    }
    
    // Divide el número en parte entera y parte decimal
    var partes = numero.toString().split(".");
    partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    
    // Une las partes y devuelve el número formateado
    return partes.join(".");
}