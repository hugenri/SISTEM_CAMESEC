<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión
if($session->getSessionVariable('rol_usuario') != 'admin'){
$site = $session->checkAndRedirect();
  header('location:' . $site);
}


require_once '../vendor/autoload.php';
require_once '../model/UsuarioModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$consulta = new UsuarioModel();
$userData = $consulta->getUsers();

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

// Ruta de la imagen que deseas incrustar
$rutaImagen = '../assets/images/logo-golem.jpg';
// Leer la imagen y convertirla a base64

$imagenBase64 = base64_encode(file_get_contents($rutaImagen));
$html = '<html>

<head>

    <title>Reporte de Usuarios</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
			
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h3 {
            text-align: center;
        }

        img {
            width: 120px;
            height: 90px;
            margin-bottom: 10px;
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
    <h3>Reporte de Usuarios</h3>
    <table border="1">

        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Rol de Usuario</th>
            <th>Email</th>
        </tr>';



foreach ($userData as $usuario) {

    $html .= '<tr>';
    $html .= '<td>' . $usuario['id'] . '</td>';
    $html .= '<td>' . $usuario['nombre'] . '</td>';
    $html .= '<td>' . $usuario['apellidoPaterno'] . '</td>';
    $html .= '<td>' . $usuario['apellidoMaterno'] . '</td>';
    $html .= '<td>' . $usuario['rol_usuario'] . '</td>';
    $html .= '<td>' . $usuario['email'] . '</td>';
    $html .= '</tr>';

}

$html .= '</table>
</body>
</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_usuarios.pdf");





