<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}

require_once '../vendor/autoload.php';
require_once '../model/ProveedorModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$consulta = new ProveedorModel();
$proveedores = $consulta->getProvider();

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

// Ruta de la imagen que deseas incrustar
$rutaImagen = '../assets/images/logo-golem.jpg';
// Leer la imagen y convertirla a base64
$imagenBase64 = base64_encode(file_get_contents($rutaImagen));

// HTML de la tabla
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
    table {
        width: 80%;
        border-collapse: collapse;
        font-size: 9px; /* Tamaño de fuente más pequeño */
    }
    th, td {
        border: 1px solid #000;
        padding: 1px; /* Espaciado reducido */
		vertical-align: top; /* Alinea el contenido en la parte superior de las celdas */

    }
    h4 {
        text-align: center;
    }
    img {
        width: 100px; /* Tamaño de la imagen reducido */
        height: 75px;
        margin-bottom: 5px; /* Espacio inferior reducido */
    }
    .header {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    </style>
</head>
<body>
<div class="header">
    <img src="data:image/jpeg;base64,' . $imagenBase64 . '" alt="Logo de la empresa">
 </div>
    <h4>Reporte De Proveedores</h4>
    <table>
        <thead>
            <tr>
             
                <th>Razón Social</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Información de Contacto</th>
                <th>Calle</th>
                <th>Número</th>
                <th>Colonia</th>
                <th>Municipio</th>
                <th>Estado</th>
                <th>CP</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Categoía</th>

            </tr>
        </thead>
        <tbody>
';

// Generar filas de la tabla con datos de la base de datos
foreach ($proveedores as $proveedor) {
    $html .= '<tr>';
    $html .= '<td>' . $proveedor['razonSocial'] . '</td>';
    $html .= '<td>' . $proveedor['nombre'] . '</td>';
    $html .= '<td>' . $proveedor['apellidoPaterno'] . '</td>';
    $html .= '<td>' . $proveedor['apellidoMaterno'] . '</td>';
    $html .= '<td>' . $proveedor['informacionContacto'] . '</td>';
    $html .= '<td>' . $proveedor['calle'] . '</td>';
    $html .= '<td>' . $proveedor['numero'] . '</td>';
    $html .= '<td>' . $proveedor['colonia'] . '</td>';
    $html .= '<td>' . $proveedor['municipio'] . '</td>';
    $html .= '<td>' . $proveedor['estado'] . '</td>';
    $html .= '<td>' . $proveedor['cp'] . '</td>';
    $html .= '<td>' . $proveedor['email'] . '</td>';
    $html .= '<td>' . $proveedor['telefono'] . '</td>';
    $html .= '<td>' . $proveedor['idCategoria'] . '</td>';

    $html .= '</tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>
';

// Cargar el contenido HTML en Dompdf
$dompdf->loadHtml($html);
// Establecer el tamaño de página y orientación
$dompdf->setPaper('A4', 'portrait');

// Renderizar el PDF y mostrarlo en el navegador
$dompdf->render();
$dompdf->stream('proveedores.pdf');
?>
