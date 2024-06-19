<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$conexion = mysqli_connect($host, $user, $password, $dbname);

if (!$conexion) {
    die("Error al conectarse a la Base de Datos: " . mysqli_connect_error());
}

require_once 'vendor/autoload.php'; // Ruta donde se encuentra autoload.php de Composer

use Dompdf\Dompdf;
use Dompdf\Options;

function obtenerNombreEstado($conexion, $codigoEstado)
{
    $sql = "SELECT Es_Nombre FROM pedido_estado WHERE Es_Codigo = '$codigoEstado'";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    return $row['Es_Nombre'];
}

function obtenerNombreCliente($conexion, $codigoCliente)
{
    $sql = "SELECT Usu_Nombre_completo FROM usuario WHERE Usu_Identificacion = '$codigoCliente'";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    return $row['Usu_Nombre_completo'];
}

function obtenerNombreProducto($conexion, $codigoProducto)
{
    $sql = "SELECT Pro_Nombre FROM productos WHERE Identificador = '$codigoProducto'";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    return $row['Pro_Nombre'];
}

function truncarTexto($texto, $longitudMaxima)
{
    if (strlen($texto) > $longitudMaxima) {
        $texto = substr($texto, 0, $longitudMaxima - 3) . '...';
    }
    return $texto;
}

function generarReportePedidos($conexion)
{
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true); // Habilitar el analizador HTML5

    // Crear una instancia de Dompdf con las opciones
    $pdf = new Dompdf($options);
    $pdf->setPaper('A4', 'landscape'); // Establecer tamaño de papel y orientación

    // Contenido HTML para el PDF
    ob_start();
    ?>
    <html>

    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 10pt;
            }

            .header {
                background-color: #0066CC;
                color: #FFFFFF;
                text-align: center;
                padding: 10px;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid black;
                padding: 5px;
                text-align: center;
            }

            .odd {
                background-color: #E6E6E6;
            }

            .even {
                background-color: #FFFFFF;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <img src="../images/Logo Mundo 3d.png" alt="" style="height: 20px; vertical-align: middle;">
            <span style="vertical-align: middle; font-size: 12pt; font-weight: bold;"> MUNDO 3D - Reporte de Pedidos</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Estado</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha de Entrega</th>
                    <th>Fecha de Pedido</th>
                    <th>Cliente</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $colorFondo = 'odd';
                $sql = "SELECT * FROM pedidos";
                $resultado = mysqli_query($conexion, $sql);

                if (!$resultado) {
                    die("Error en la consulta: " . mysqli_error($conexion));
                }

                while ($row = mysqli_fetch_assoc($resultado)) {
                    $estado = obtenerNombreEstado($conexion, $row['Pe_Estado']);
                    $cliente = obtenerNombreCliente($conexion, $row['Pe_Cliente']);
                    $producto = obtenerNombreProducto($conexion, $row['Pe_Producto']);
                    ?>
                    <tr class="<?php echo $colorFondo; ?>">
                        <td><?php echo isset($row['Identificador']) ? $row['Identificador'] : ''; ?></td>
                        <td><?php echo utf8_decode($estado); ?></td>
                        <td><?php echo utf8_decode(truncarTexto($producto, 40)); ?></td>
                        <td><?php echo isset($row['Pe_Cantidad']) ? $row['Pe_Cantidad'] : ''; ?></td>
                        <td><?php echo isset($row['Pe_Fechaentrega']) ? $row['Pe_Fechaentrega'] : ''; ?></td>
                        <td><?php echo isset($row['Pe_Fechapedido']) ? $row['Pe_Fechapedido'] : ''; ?></td>
                        <td><?php echo utf8_decode($cliente); ?></td>
                        <td><?php echo utf8_decode(truncarTexto(isset($row['Pe_Observacion']) ? $row['Pe_Observacion'] : '', 40)); ?>
                        </td>
                    </tr>
                    <?php
                    $colorFondo = ($colorFondo == 'odd') ? 'even' : 'odd';
                }
                ?>
            </tbody>
        </table>
    </body>

    </html>
    <?php
    $html = ob_get_clean();

    // Cargar el contenido HTML en Dompdf
    $pdf->loadHtml($html);

    // Renderizar el PDF
    $pdf->render();

    // Obtener el contenido del PDF generado
    $pdfOutput = $pdf->output();

    // Establecer las cabeceras para descarga del archivo PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="Reporte_Pedidos.pdf"');
    header('Cache-Control: max-age=0');

    // Enviar el contenido del PDF al navegador
    echo $pdfOutput;
}

generarReportePedidos($conexion);
?>