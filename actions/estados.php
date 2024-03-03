<?php
require_once "../model//Estado.php";

$tablaEstado = new Estado();
$estados = $tablaEstado->obtenerEstadosSelect();

header('Content-Type: application/json');
echo json_encode(['data' => $estados]);
?>