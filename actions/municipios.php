<?php
require_once "../model/Municipio.php";
require_once "../model/Estado.php"; // Asegúrate de incluir la clase Estado

if (isset($_POST['estado'])) {
    $nombreEstado = $_POST['estado'];

    // Obtener el ID del estado por su nombre
    $tablaEstado = new Estado();
    $idEstado = $tablaEstado->obtenerIdEstadoPorNombre($nombreEstado);

    if ($idEstado !== null) {
        // Si se encuentra el ID del estado, obtener los municipios
        $tablaMunicipio = new Municipio();
        $municipios = $tablaMunicipio->obtenerMunicipiosSelect($idEstado);

        header('Content-Type: application/json');
        echo json_encode(['data' => $municipios]);
    } else {
        // Manejar el caso en el que no se encuentra el ID del estado
        header('Content-Type: application/json');
        echo json_encode(['error' => 'ID de estado no encontrado']);
    }
} else {
    // Manejar el caso en el que no se proporciona el nombre del estado
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Nombre de estado no proporcionado']);
}
?>
