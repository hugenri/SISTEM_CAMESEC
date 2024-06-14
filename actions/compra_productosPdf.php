<?php
include_once '../clases/Session.php';
$session = new Session();
$session->startSession(); // Llamada a la función para iniciar la sesión

if ($session->getSessionVariable('rol_usuario') != 'compras') {
    $site = $session->checkAndRedirect();
    header('location:' . $site);
    exit();
}

include_once '../clases/dataSanitizer.php';
include_once '../clases/DataValidator.php';
include_once '../clases/DataBase.php';
require_once '../clases/Response_json.php';
require_once '../vendor/autoload.php';

$respuesta_json = new ResponseJson();
$response = null;

use Dompdf\Dompdf;

// Recuperar el idVenta de la URL y limpiarlo
$idVenta = isset($_GET['idVenta']) ? filter_var($_GET['idVenta'], FILTER_SANITIZE_NUMBER_INT) : null;

if (empty($idVenta)) {
    // Si el idVenta está vacío, devolvemos un error
    http_response_code(400); // Bad Request
    exit();
}

$sql = "SELECT  v.id_venta, prod.nombre AS nombre_producto, prod.descripcion AS descripcion_producto, prod.precio AS precio_unitario, vp.cantidad AS cantidad_comprar,
  pr.razonSocial AS nombre_proveedor, pr.email AS email_proveedor, pr.telefono AS telefono_proveedor,
  c.razonSocial AS nombre_cliente, c.email AS email_cliente, c.telefono AS telefono_cliente
FROM 
  ventas v
JOIN 
  ventas_productos vp ON v.id_venta = vp.id_venta
JOIN 
  entregas e ON v.id_venta = e.id_venta
JOIN 
  pagos_venta pv ON v.id_venta = pv.id_venta
JOIN 
  producto prod ON vp.id_producto = prod.id
JOIN 
  proveedor pr ON prod.idProveedor = pr.idProveedor
JOIN 
  cliente c ON v.id_cliente = c.idCliente
WHERE v.id_venta = :idVenta;";

$parametros = array('idVenta' => $idVenta);

// Ejecutar la consulta
$ordenCompra = ConsultaBaseDatos::ejecutarConsulta($sql, $parametros, true);

// Verificar que se obtuvieron resultados
if (empty($ordenCompra)) {
    http_response_code(404); // Not Found
    exit();
}

// Estilos CSS personalizados
$customStyles = '
<style>
    /* Estilos personalizados aquí */
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .container {
        max-width: 960px;
        margin: 0 auto;
        display: flex; /* Usamos flexbox para dividir en columnas */
        justify-content: space-between; /* Para separar las columnas */
    }

    .card {
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #f8f9fa;
        padding: 15px 15px;
        border-bottom: 1px solid #ccc;
    }

    .card-body {
        padding: 15px;
    }

    .text-center {
        text-align: center;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .my-4 {
        margin-top: 4px;
        margin-bottom: 4px;
    }

    .border-danger {
        border-color: #dc3545;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px; /* Tamaño de fuente más pequeño para la tabla */
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    p {
        font-size: 10px; /* Tamaño de fuente más pequeño */
        color: blue; /* Color de texto */
    }
</style>
';

// Crear el HTML para el PDF con estilos personalizados
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Orden de compra</title>
' . $customStyles . '
</head>
<body>
<div class="row justify-content-center">
    <div class="col-lg-11 col-md-11">
        <div class="card">
            <div class="card-header">
            <h3 class="text-center">Detalles de la Orden de Compra</h3>
            </div>
            <div class="card-body">
                <p class="mb-0" id="servicio">Servicio: Venta de productos</p>
                <p class="mb-0" id="cliente">Cliente: ' . $ordenCompra[0]["nombre_cliente"] . '</p>
                <p class="mb-0" id="email_cliente">Email: ' . $ordenCompra[0]["email_cliente"] . '</p>
                <p id="telefono_cliente">Teléfono: ' . $ordenCompra[0]["telefono_cliente"] . '</p>
                <hr class="border-danger my-4">
                <div class="row mb-2">
                    <div class="col">
                        <h4>Productos para la compra</h4>
                    </div>
                </div>
                <div class="table-responsive mb-3">
                    <table id="tablaOrdenCompra" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Proveedor</th>
                                <th>Email del Proveedor</th>
                                <th>Teléfono del Proveedor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>' . $ordenCompra[0]["nombre_producto"] . '</td>
                                <td>' . $ordenCompra[0]["precio_unitario"] . '</td>
                                <td>' . $ordenCompra[0]["cantidad_comprar"] . '</td>
                                <td>' . $ordenCompra[0]["nombre_proveedor"] . '</td>
                                <td>' . $ordenCompra[0]["email_proveedor"] . '</td>
                                <td>' . $ordenCompra[0]["telefono_proveedor"] . '</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
';

// Configuración de dompdf y renderizado del PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Establecer el tipo de contenido de la respuesta como PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="orden_compra.pdf"');

// Enviar el contenido del PDF al navegador
echo $dompdf->output();
?>
