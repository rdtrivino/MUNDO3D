<?php
require '../ADMIN/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

include './../conexion.php';

// Obtener el ID de la factura desde la URL (ejemplo)
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    die("ID de factura no proporcionado.");
}

// Consulta SQL para obtener los datos de la factura
$sql = "SELECT f.id, f.numero_factura, f.fecha, f.total, f.estado, f.nombre_cliente, f.creado_en, f.numero_documento,
               p.pro_nombre AS producto, f.cantidad, p.Pro_precioVenta AS precio
        FROM factura f
        LEFT JOIN productos p ON f.producto = p.Identificador
        WHERE f.pedido_id = (SELECT pedido_id FROM factura WHERE id = ?)";
$stmt = mysqli_prepare($link, $sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . mysqli_error($conexion));
}

mysqli_stmt_bind_param($stmt, "i", $id);
$result = mysqli_stmt_execute($stmt);

if ($result === false) {
    die("Error al ejecutar la consulta: " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);

// Almacenar todas las filas en un array
$facturas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $facturas[] = $row;
}
mysqli_stmt_close($stmt);

if (count($facturas) === 0) {
    die("Factura no encontrada.");
}

// Inicializar Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Función para obtener la fecha y hora actual formateada
function obtenerFechaHoraActual()
{
    $fechaHora = new DateTime('now', new DateTimeZone('America/Bogota')); // Ajustar a la zona horaria deseada
    return $fechaHora->format('Y-m-d H:i:s');
}

// Crear el contenido HTML del PDF
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Venta #' . $facturas[0]['numero_factura'] . '</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333;
            margin: 0;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items th, .items td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .items th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            margin-top: 20px;
        }
        .total strong {
            font-size: 1.2em;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: #f2f2f2;
            padding: 10px 0;
            border-top: 1px solid #ccc;
        }
        .title {
            text-align: center;
            margin-bottom: 10px;
        }
        .title h1 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }
        .generated-by {
            margin-top: 20px;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>Factura de Venta</h1>
        </div>
        <div class="info">
            <p><strong>Numero Factura:</strong> ' . $facturas[0]['numero_factura'] . '</p>
            <p><strong>Nombre Cliente:</strong> ' . $facturas[0]['nombre_cliente'] . '</p>
            <p><strong>Número de Documento:</strong> ' . $facturas[0]['numero_documento'] . '</p>
            <p><strong>Creado En:</strong> ' . $facturas[0]['creado_en'] . '</p>
            <p><strong>Estado:</strong> ' . $facturas[0]['estado'] . '</p>
        </div>
        <h3 style="text-align: center;">Detalles de la Factura</h3>
        <table class="items">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>';

$totalFactura = 0;

foreach ($facturas as $factura) {
    $subtotal = $factura['cantidad'] * $factura['precio'];
    $totalFactura += $subtotal;

    $html .= '
        <tr>
            <td>' . $factura['id'] . '</td>
            <td>' . $factura['producto'] . '</td>
            <td>' . $factura['cantidad'] . '</td>
            <td>$' . $factura['precio'] . '</td>
            <td>$' . number_format($subtotal, 2) . '</td>
        </tr>';
}

$html .= '
        </table>
        <div class="total">
            <strong>Total:</strong> $' . number_format($totalFactura, 2) . '
        </div>
    </div>
   <div class="footer">
        <p>Factura Generada por: Mundo 3D - ' . obtenerFechaHoraActual() . '</p>
        <p>Transformando ideas en realidad tridimensional</p>
    </div>
</body>
</html>
';

// Cargar el HTML en Dompdf
$dompdf->loadHtml($html);

// Renderizar el PDF
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Obtener el contenido generado del PDF
$output = $dompdf->output();

// Escribir el contenido en un archivo temporal
$pdfFilePath = 'Factura_' . $facturas[0]['numero_factura'] . '.pdf';
file_put_contents($pdfFilePath, $output);

// Descargar el archivo PDF generado
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $pdfFilePath . '"');
header('Content-Length: ' . filesize($pdfFilePath));
readfile($pdfFilePath);

// Eliminar el archivo PDF temporal después de la descarga
unlink($pdfFilePath);

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
