<?php
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;

// Recuperar los datos de la base de datos
$idOrdenCompra = 1; // Supongamos que este es el ID de la orden de compra que deseas mostrar

// Tu conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "golem";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT pc.id, p.nombre AS nombre_producto, p.descripcion AS descripcion_producto, p.precio AS precio_unitario, pc.cantidad AS cantidad_comprar,
        pr.razonSocial AS nombre_proveedor, pr.email AS email_proveedor, pr.telefono AS telefono_proveedor,
        c.razonSocial AS nombre_cliente, c.email AS email_cliente, c.telefono AS telefono_cliente,
        sc.servicio AS servicio_ofrecido, co.idCotizacion, oc.estado
        FROM orden_compras oc
        INNER JOIN cotizaciones co ON oc.idCotizacion = co.idCotizacion
        INNER JOIN productos_cotizacion pc ON co.idCotizacion = pc.idCotizacion
        INNER JOIN producto p ON pc.id_producto = p.id
        INNER JOIN proveedor pr ON p.idProveedor = pr.idProveedor
        INNER JOIN solicitudes_cotizacion sc ON co.idSolicitudCotizacion = sc.id
        INNER JOIN cliente c ON sc.id_cliente = c.idCliente
        WHERE oc.idOrdenCompra = :idOrdenCompra");
    $stmt->bindParam(':idOrdenCompra', $idOrdenCompra);
    $stmt->execute();
    $ordenCompra = $stmt->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
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
            
                            <p class="mb-0" id="servicio">Servicio: ' . $ordenCompra["servicio_ofrecido"] . '</p>
                            <p  class="mb-0" id="cliente">Cliente: ' . $ordenCompra["nombre_cliente"] . '</p> 
                            <p  class="mb-0" id="email_cliente">Email: ' . $ordenCompra["email_cliente"] . '</p>
                            <p id="telefono_cliente">Teléfono: ' . $ordenCompra["telefono_cliente"] . '</p>
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
                                    <td>' . $ordenCompra["nombre_producto"] . '</td>
                                    <td>' . $ordenCompra["precio_unitario"] . '</td>
                                    <td>' . $ordenCompra["cantidad_comprar"] . '</td>
                                    <td>' . $ordenCompra["nombre_proveedor"] . '</td>
                                    <td>' . $ordenCompra["email_proveedor"] . '</td>
                                    <td>' . $ordenCompra["telefono_proveedor"] . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
$dompdf->stream("orden_compra.pdf", array("Attachment" => false));
