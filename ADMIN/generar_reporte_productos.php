<?php
// Realizar la conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$conexion = mysqli_connect($host, $user, $password, $dbname);

// Comprobar si la conexión se realizó correctamente
if (!$conexion) {
    die("Error al conectarse a la Base de Datos: " . mysqli_connect_error());
}

require_once 'vendor/autoload.php'; // Ruta donde se encuentra autoload.php de Composer

use Dompdf\Dompdf;
use Dompdf\Options;

// Función para generar el reporte de la tabla de productos
function generarReporteProductos($conexion)
{
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);

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
            <img src="../images/Logo Mundo 3d.png" alt="Logo Mundo 3D" style="height: 20px; vertical-align: middle;">
            <span style="vertical-align: middle; font-size: 12pt; font-weight: bold;"> MUNDO 3D - Reporte de
                Productos</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Codigo</th>
                    <th>Categoría</th>
                    <th>Precio Venta</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $colorFondo = 'odd';
                $sql = "SELECT p.Pro_Nombre, p.Identificador, p.Pro_Descripcion, p.Pro_PrecioVenta, c.Cgo_Nombre AS Pro_Categoria, p.Pro_Cantidad, p.Pro_Costo
                        FROM productos p
                        INNER JOIN categoria c ON p.Pro_Categoria = c.Cgo_Codigo";
                $resultado = mysqli_query($conexion, $sql);

                if (!$resultado) {
                    die("Error en la consulta: " . mysqli_error($conexion));
                }

                while ($row = mysqli_fetch_assoc($resultado)) {
                    ?>
                    <tr class="<?php echo $colorFondo; ?>">
                        <td><?php echo utf8_decode($row['Pro_Nombre']); ?></td>
                        <td><?php echo utf8_decode($row['Identificador']); ?></td>
                        <td><?php echo utf8_decode($row['Pro_Categoria']); ?></td>
                        <td><?php echo utf8_decode($row['Pro_PrecioVenta']); ?></td>
                        <td><?php echo utf8_decode($row['Pro_Cantidad']); ?></td>
                        <td><?php echo utf8_decode($row['Pro_Costo']); ?></td>
                        <td><?php echo utf8_decode($row['Pro_Descripcion']); ?></td>
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

    // Generar salida del PDF (descargar automáticamente)
    $pdf->stream('Reporte_Productos.pdf', array('Attachment' => 1));
}

// Generar el reporte de productos
generarReporteProductos($conexion);

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>