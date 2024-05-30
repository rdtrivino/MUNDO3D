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

// Incluir la biblioteca FPDF
require_once ('../libs/fpdf.php');

// Función para generar el reporte de la tabla de productos
function generarReporteProductos($conexion)
{
    // Crear una instancia de FPDF con orientación horizontal
    $pdf = new FPDF('L'); // 'L' indica orientación horizontal (landscape)
    $pdf->AddPage(); // Añadir una página al PDF

    // Configurar la fuente para UTF-8 y reducir el tamaño de las letras
    $pdf->SetFont('Arial', '', 8); // Eliminar el parámetro 'true' para evitar subrayado en amarillo

    // Título del reporte en un cuadro azul con letras blancas (a la derecha)
    $pdf->SetFillColor(0, 102, 204); // Color de fondo azul
    $pdf->SetTextColor(255, 255, 255); // Color de texto blanco
    $pdf->SetFont('Arial', '', 12); // Quitar la negrita y reducir el tamaño de las letras

    // Obtener el ancho del texto "MUNDO 3D - Reporte de Productos"
    $anchoTexto = $pdf->GetStringWidth('MUNDO 3D - Reporte de Productos');

    // Definir el tamaño del recuadro ajustado al texto
    $altoRecuadro = 10; // Alto del recuadro
    $anchoRecuadro = $anchoTexto + 10; // Ancho del recuadro (más margen)
    $x = $pdf->GetPageWidth() - $anchoRecuadro - 10; // Posición X para alinear a la derecha
    $y = 10; // Posición Y para alinear arriba

    // Escribir el texto en el recuadro
    $pdf->SetXY($x, $y + 1);
    $pdf->Cell($anchoRecuadro, $altoRecuadro, 'MUNDO 3D - Reporte de Productos', 0, 0, 'C', true);
    $pdf->Ln(); // Salto de línea
    $pdf->Ln(); // Salto de línea adicional

    // Definir el encabezado del PDF
    $pdf->SetTextColor(255, 255, 255); // Color de texto blanco
    $pdf->SetFillColor(50, 50, 50); // Color de fondo oscuro
    $pdf->SetFont('Arial', 'B', 8); // Negrita para el encabezado y reducir el tamaño de las letras

    // Encabezados de las columnas con celdas del mismo tamaño
    $alturaCelda = 15; // Ajustar la altura de las celdas
    $pdf->Cell(85, $alturaCelda, 'Nombre', 1, 0, 'C', true); // Encabezado de la columna 1
    $pdf->Cell(15, $alturaCelda, 'Codigo', 1, 0, 'C', true); // Encabezado de la columna 2
    $pdf->Cell(25, $alturaCelda, 'Categoría', 1, 0, 'C', true); // Encabezado de la columna 3
    $pdf->Cell(20, $alturaCelda, 'Precio Venta', 1, 0, 'C', true); // Encabezado de la columna 4
    $pdf->Cell(20, $alturaCelda, 'Cantidad', 1, 0, 'C', true); // Encabezado de la columna 5
    $pdf->Cell(15, $alturaCelda, 'Costo', 1, 0, 'C', true); // Encabezado de la columna 6
    $pdf->Cell(100, $alturaCelda, 'Descripción', 1, 0, 'C', true); // Encabezado de la columna 7

    // Consultar la base de datos para obtener los datos de la tabla de productos
    $sql = "SELECT p.Pro_Nombre, p.Identificador, p.Pro_Descripcion, p.Pro_PrecioVenta, c.Cgo_Nombre AS Pro_Categoria, p.Pro_Cantidad, p.Pro_Costo
    FROM productos p
    INNER JOIN categoria c ON p.Pro_Categoria = c.Cgo_Codigo";

    $resultado = mysqli_query($conexion, $sql);

    // Comprobar si la consulta fue exitosa
    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    // Restaurar la configuración para la construcción de la tabla
    $pdf->SetTextColor(0, 0, 0); // Restaurar el color de texto a negro
    $pdf->SetFont('Arial', '', 8); // Restaurar el tamaño normal de letra

    // Construir la tabla con los datos de la consulta
    while ($row = mysqli_fetch_assoc($resultado)) {
        // Rellenar las celdas con los datos obtenidos de la base de datos
        $pdf->Cell(85, $alturaCelda, utf8_decode($row['Pro_Nombre']), 1, 0, 'C'); // Celda para el nombre
        $pdf->Cell(15, $alturaCelda, utf8_decode($row['Identificador']), 1, 0, 'C'); // Celda para el identificador
        $pdf->Cell(25, $alturaCelda, utf8_decode($row['Pro_Categoria']), 1, 0, 'C'); // Celda para la categoría
        $pdf->Cell(20, $alturaCelda, utf8_decode($row['Pro_PrecioVenta']), 1, 0, 'C'); // Celda para el precio de venta
        $pdf->Cell(20, $alturaCelda, utf8_decode($row['Pro_Cantidad']), 1, 0, 'C'); // Celda para la cantidad
        $pdf->Cell(15, $alturaCelda, utf8_decode($row['Pro_Costo']), 1, 0, 'C'); // Celda para el costo
        // Celda para la descripción con MultiCell para manejar saltos de línea
        $pdf->MultiCell(100, 6, utf8_decode($row['Pro_Descripcion']), 1, 'C');
        // Salto de línea después de cada fila
        $pdf->Ln();
    }

    // Generar y descargar el PDF con el nombre adecuado
    $pdf->Output('Reporte_Productos.pdf', 'D');
}

// Generar el reporte de productos
generarReporteProductos($conexion);

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>