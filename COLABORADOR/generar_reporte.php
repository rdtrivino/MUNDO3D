<?php

// Incluir el archivo de conexión a la base de datos
include __DIR__ . '/../conexion.php';  // Conecta con la base de datos desde el archivo "conexion.php"

// Incluir la librería PDF
require_once '../ADMIN/vendor/autoload.php'; // Carga la librería de Dompdf mediante Composer

use Dompdf\Dompdf;  // Usamos la clase Dompdf para la generación del PDF
use Dompdf\Options; // Usamos la clase Options para configurar opciones adicionales de Dompdf

// Función para obtener el nombre del estado de un pedido, a partir de su código
function obtenerNombreEstado($link, $codigoEstado)
{
    // Consulta SQL para obtener el nombre del estado del pedido
    $sql = "SELECT Es_Nombre FROM pedido_estado WHERE Es_Codigo = '$codigoEstado'";
    $resultado = mysqli_query($link, $sql);  // Ejecutar la consulta en la base de datos
    $row = mysqli_fetch_assoc($resultado);  // Obtener el resultado como un arreglo asociativo
    return $row['Es_Nombre'];  // Retorna el nombre del estado
}

// Función para obtener el nombre del cliente a partir de su código
function obtenerNombreCliente($link, $codigoCliente)
{
    // Consulta SQL para obtener el nombre completo del cliente
    $sql = "SELECT Usu_Nombre_completo FROM usuario WHERE Usu_Identificacion = '$codigoCliente'";
    $resultado = mysqli_query($link, $sql);  // Ejecutar la consulta en la base de datos
    $row = mysqli_fetch_assoc($resultado);  // Obtener el resultado como un arreglo asociativo
    return $row['Usu_Nombre_completo'];  // Retorna el nombre completo del cliente
}

// Función para obtener el nombre de un producto a partir de su código
function obtenerNombreProducto($link, $codigoProducto)
{
    // Consulta SQL para obtener el nombre del producto
    $sql = "SELECT Pro_Nombre FROM productos WHERE Identificador = '$codigoProducto'";
    $resultado = mysqli_query($link, $sql);  // Ejecutar la consulta en la base de datos
    $row = mysqli_fetch_assoc($resultado);  // Obtener el resultado como un arreglo asociativo
    return $row['Pro_Nombre'];  // Retorna el nombre del producto
}

// Función para generar el reporte en PDF dependiendo de la tabla seleccionada
function generarReporte($link)
{
    // Configuración de opciones para Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);  // Permite la interpretación de HTML5
    $options->set('isPhpEnabled', true);  // Permite el uso de PHP dentro del HTML generado
    $options->set('fontDir', '/path/to/fonts');  // Define el directorio de fuentes si es necesario

    // Crear una instancia del generador de PDF Dompdf con las opciones definidas
    $pdf = new Dompdf($options);
    $pdf->setPaper('A4', 'landscape');  // Establece el tamaño de papel en A4 y la orientación horizontal

    // Obtener el valor del parámetro 'tabla' desde la URL, que indica qué tipo de reporte generar
    $tabla = isset($_GET['tabla']) ? $_GET['tabla'] : '';  // Si no se pasa ningún parámetro, se usa un valor vacío

    // Captura del contenido HTML a generar el PDF dependiendo de la tabla seleccionada
    ob_start();  // Inicia el almacenamiento en búfer de la salida

    // Si la tabla seleccionada es "pedidos", genera un reporte de pedidos
    if ($tabla == 'pedidos') {
        ?>
        <html>
        <head>
            <meta charset="UTF-8"> <!-- Establecer codificación de caracteres UTF-8 -->
            <style>
                /* Estilos CSS para la tabla y el contenido del PDF */
                body {
                    font-family: DejaVu Sans, sans-serif; /* Fuente con soporte para caracteres especiales */
                    font-size: 10pt;  /* Establece el tamaño de fuente */
                }
                .header {
                    background-color: #0066CC;  /* Color de fondo azul para la cabecera */
                    color: #FFFFFF;  /* Color del texto blanco */
                    text-align: center;  /* Centra el contenido */
                    padding: 10px;  /* Relleno interno */
                    margin-bottom: 20px;  /* Margen inferior */
                }
                table {
                    width: 100%;  /* La tabla ocupa todo el ancho disponible */
                    border-collapse: collapse;  /* Elimina los bordes duplicados */
                }
                table, th, td {
                    border: 1px solid black;  /* Define bordes para la tabla y celdas */
                    padding: 10px;  /* Aumenta el espacio dentro de las celdas */
                    text-align: left;  /* Alineación del texto a la izquierda */
                    word-wrap: break-word;  /* Ajusta texto largo dentro de las celdas */
                    overflow-wrap: break-word;  /* Asegura el ajuste del texto largo */
                }
                .odd {
                    background-color: #E6E6E6;  /* Color de fondo gris para filas impares */
                }
                .even {
                    background-color: #FFFFFF;  /* Color de fondo blanco para filas pares */
                }
            </style>
        </head>
        <body>
        <div class="header">
            <img src="../images/Logo Mundo 3d.png" alt="Logo Mundo 3D" style="height: 20px; vertical-align: middle;">
            <span style="vertical-align: middle; font-size: 12pt; font-weight: bold;">MUNDO 3D - Reporte de Pedidos</span>
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
            $colorFondo = 'odd';  // Se inicia con el color de fondo "odd"
            $sql = "SELECT * FROM pedidos";  // Consulta SQL para obtener todos los pedidos
            $resultado = mysqli_query($link, $sql);  // Ejecutar la consulta

            if (!$resultado) {
                die("Error en la consulta: " . mysqli_error($link));  // Si hay error, termina el script
            }

            // Recorrer los resultados de la consulta para llenar la tabla
            while ($row = mysqli_fetch_assoc($resultado)) {
                $estado = obtenerNombreEstado($link, $row['Pe_Estado']);  // Obtener el nombre del estado del pedido
                $cliente = obtenerNombreCliente($link, $row['Pe_Cliente']);  // Obtener el nombre del cliente
                $producto = obtenerNombreProducto($link, $row['Pe_Producto']);  // Obtener el nombre del producto
                ?>
                <tr class="<?php echo $colorFondo; ?>">
                    <td><?php echo isset($row['Identificador']) ? $row['Identificador'] : ''; ?></td>
                    <td><?php echo utf8_decode($estado); ?></td>
                    <td><?php echo utf8_decode($producto); ?></td>
                    <td><?php echo isset($row['Pe_Cantidad']) ? $row['Pe_Cantidad'] : ''; ?></td>
                    <td><?php echo isset($row['Pe_Fechaentrega']) ? $row['Pe_Fechaentrega'] : ''; ?></td>
                    <td><?php echo isset($row['Pe_Fechapedido']) ? $row['Pe_Fechapedido'] : ''; ?></td>
                    <td><?php echo utf8_decode($cliente); ?></td>
                    <td><?php echo utf8_decode(isset($row['Pe_Observacion']) ? $row['Pe_Observacion'] : ''); ?></td>
                </tr>
                <?php
                // Alternar el color de fondo entre filas impares y pares
                $colorFondo = ($colorFondo == 'odd') ? 'even' : 'odd';
            }
            ?>
            </tbody>
        </table>
        </body>
        </html>
        <?php
    } elseif ($tabla == 'productos') {
        // Similar al bloque anterior, pero para generar el reporte de productos
        ?>
        <html>
        <head>
            <meta charset="UTF-8"> <!-- Establecer codificación de caracteres UTF-8 -->
            <style>
                body {
                    font-family: DejaVu Sans, sans-serif; /* Fuente con soporte para caracteres especiales */
                    font-size: 10pt;  /* Establece el tamaño de fuente */
                }
                .header {
                    background-color: #0066CC;  /* Color de fondo azul para la cabecera */
                    color: #FFFFFF;  /* Color del texto blanco */
                    text-align: center;  /* Centra el contenido */
                    padding: 10px;  /* Relleno interno */
                    margin-bottom: 20px;  /* Margen inferior */
                }
                table {
                    width: 100%;  /* La tabla ocupa todo el ancho disponible */
                    border-collapse: collapse;  /* Elimina los bordes duplicados */
                }
                table, th, td {
                    border: 1px solid black;  /* Define bordes para la tabla y celdas */
                    padding: 10px;  /* Aumenta el espacio dentro de las celdas */
                    text-align: left;  /* Alineación del texto a la izquierda */
                    word-wrap: break-word;  /* Ajusta texto largo dentro de las celdas */
                    overflow-wrap: break-word;  /* Asegura el ajuste del texto largo */
                }
                .odd {
                    background-color: #E6E6E6;  /* Color de fondo gris para filas impares */
                }
                .even {
                    background-color: #FFFFFF;  /* Color de fondo blanco para filas pares */
                }
            </style>
        </head>
        <body>
        <div class="header">
            <img src="../images/Logo Mundo 3d.png" alt="Logo Mundo 3D" style="height: 20px; vertical-align: middle;">
            <span style="vertical-align: middle; font-size: 12pt; font-weight: bold;">MUNDO 3D - Reporte de Productos</span>
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
            $colorFondo = 'odd';  // Se inicia con el color de fondo "odd"
            // Consulta SQL para obtener los productos y sus categorías
            $sql = "SELECT p.Pro_Nombre, p.Identificador, p.Pro_Descripcion, p.Pro_PrecioVenta, c.Cgo_Nombre AS Pro_Categoria, p.Pro_Cantidad, p.Pro_Costo
                    FROM productos p
                    INNER JOIN categoria c ON p.Pro_Categoria = c.Cgo_Codigo";
            $resultado = mysqli_query($link, $sql);  // Ejecutar la consulta

            if (!$resultado) {
                die("Error en la consulta: " . mysqli_error($link));  // Si hay error, termina el script
            }

            // Recorrer los resultados de la consulta para llenar la tabla
            while ($row = mysqli_fetch_assoc($resultado)) {
                ?>
                <tr class="<?php echo $colorFondo; ?>">
                    <td><?php echo utf8_decode($row['Pro_Nombre']); ?></td>
                    <td><?php echo isset($row['Identificador']) ? $row['Identificador'] : ''; ?></td>
                    <td><?php echo utf8_decode($row['Pro_Categoria']); ?></td>
                    <td><?php echo isset($row['Pro_PrecioVenta']) ? $row['Pro_PrecioVenta'] : ''; ?></td>
                    <td><?php echo isset($row['Pro_Cantidad']) ? $row['Pro_Cantidad'] : ''; ?></td>
                    <td><?php echo isset($row['Pro_Costo']) ? $row['Pro_Costo'] : ''; ?></td>
                    <td><?php echo utf8_decode($row['Pro_Descripcion']); ?></td>
                </tr>
                <?php
                // Alternar el color de fondo entre filas impares y pares
                $colorFondo = ($colorFondo == 'odd') ? 'even' : 'odd';
            }
            ?>
            </tbody>
        </table>
        </body>
        </html>
        <?php
    }

    // Capturar el contenido HTML generado y almacenarlo en la variable $html
    $html = ob_get_clean();  // Captura el contenido generado en el búfer de salida
    
    // Cargar el contenido HTML en Dompdf
    $pdf->loadHtml($html);  // Cargar el HTML capturado
    $pdf->render();  // Generar el PDF
    
    // Enviar el PDF al navegador con la opción de descarga
    $pdf->stream('reporte.pdf', array('Attachment' => 1));  // 'Attachment' => 1 hace que el archivo se descargue automáticamente
}

// Ejecutar la función de generación de reporte
generarReporte($link);  // Llamada a la función para generar el reporte basado en la base de datos

?>
