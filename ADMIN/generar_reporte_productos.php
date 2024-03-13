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
require_once('../libs/fpdf.php');

// Función para generar el reporte de la tabla de productos
function generarReporteProductos($conexion) {
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
    $pdf->Cell(20, 10, 'Nombre', 1, 0, 'C', true); // Encabezado de la columna 1 (Achicada)
    $pdf->Cell(15, 10, 'Código', 1, 0, 'C', true); // Encabezado de la columna 2 (Achicada)
    $pdf->Cell(80, 10, 'Descripción', 1, 0, 'C', true); // Encabezado de la columna 3 (Agrandada)
    $pdf->Cell(20, 10, 'Precio Venta', 1, 0, 'C', true); // Encabezado de la columna 4 (Achicada)
    $pdf->Cell(20, 10, 'Categoría', 1, 0, 'C', true); // Encabezado de la columna 5 (Achicada)
    $pdf->Cell(15, 10, 'Cantidad', 1, 0, 'C', true); // Encabezado de la columna 6 (Achicada)
    $pdf->Cell(15, 10, 'Costo', 1, 0, 'C', true); // Encabezado de la columna 7 (Achicada)
    $pdf->Cell(30, 10, 'Imagen', 1, 0, 'C', true); // Encabezado de la columna 8 (Agrandada)
    $pdf->Cell(15, 10, 'Estado', 1, 1, 'C', true); // Encabezado de la columna 9 (Achicada)

    // Consultar la base de datos para obtener los datos de la tabla de productos
    $sql = "SELECT Pro_Nombre, Pro_Codigo, Pro_Descripcion, Pro_PrecioVenta, Pro_Categoria, Pro_Cantidad, Pro_Costo, imagen_principal, Pro_Estado FROM producto";
    $resultado = mysqli_query($conexion, $sql);
    
    // Comprobar si la consulta fue exitosa
    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
    
    // Restaurar la configuración para la construcción de la tabla
    $pdf->SetTextColor(0, 0, 0); // Restaurar el color de texto a negro
    $pdf->SetFont('Arial', '', 8); // Restaurar el tamaño normal de letra

    // Variable para controlar el color de fondo de las celdas
    $colorFondo = true;

    // Construir la tabla con los datos de la consulta
    while ($row = mysqli_fetch_assoc($resultado)) {
        // Obtener el número de líneas para el nombre
        $numLinesNombre = ceil($pdf->GetStringWidth($row['Pro_Nombre']) / 20);

        // Determinar la altura de la celda para el nombre
        $alturaNombre = 10 * $numLinesNombre;

        // Obtener el número de líneas para la descripción
        $numLinesDescripcion = ceil($pdf->GetStringWidth($row['Pro_Descripcion']) / 80);

        // Determinar la altura de la celda para la descripción
        $alturaDescripcion = 5 * $numLinesDescripcion;

        // Calcular la altura máxima entre la altura del nombre y la descripción
        $alturaMaxima = max($alturaNombre, $alturaDescripcion);

        // Cambiar el color de fondo
        $pdf->SetFillColor($colorFondo ? 200 : 255);
        $colorFondo = !$colorFondo;

        // Imprimir los datos en formato horizontal
        $pdf->Cell(20, $alturaMaxima, utf8_decode($row['Pro_Nombre']), 1, 'C', true); // Datos de la columna 1
        $pdf->Cell(15, $alturaMaxima, utf8_decode($row['Pro_Codigo']), 1, 'C', true); // Datos de la columna 2
        $pdf->Cell(80, $alturaMaxima, utf8_decode($row['Pro_Descripcion']), 1, 'L', true); // Datos de la columna 3
        $pdf->Cell(20, $alturaMaxima, utf8_decode($row['Pro_PrecioVenta']), 1, 'C', true); // Datos de la columna 4
        $pdf->Cell(20, $alturaMaxima, utf8_decode($row['Pro_Categoria']), 1, 'C', true); // Datos de la columna 5
        $pdf->Cell(15, $alturaMaxima, utf8_decode($row['Pro_Cantidad']), 1, 'C', true); // Datos de la columna 6
        $pdf->Cell(15, $alturaMaxima, utf8_decode($row['Pro_Costo']), 1, 'C', true); // Datos de la columna 7
        $pdf->Cell(30, $alturaMaxima, utf8_decode($row['imagen_principal']), 1, 'C', true); // Datos de la columna 8
        $pdf->Cell(15, $alturaMaxima, utf8_decode($row['Pro_Estado']), 1, 'C', true); // Datos de la columna 9

        // Salto de línea
        $pdf->Ln();
    }

    // Generar y descargar el PDF con el nombre adecuado
    $pdf->Output('Reporte_Productos.pdf', 'D');
}

// Generar el reporte de productos
generarReporteProductos($conexion);
?>
