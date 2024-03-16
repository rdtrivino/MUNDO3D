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

// Función para generar el reporte de la tabla de usuarios
function generarReporteUsuarios($conexion) {
    // Crear una instancia de FPDF con orientación horizontal
    $pdf = new FPDF('L'); // 'L' indica orientación horizontal (landscape)
    $pdf->AddPage(); // Añadir una página al PDF

    // Configurar la fuente para UTF-8 y reducir el tamaño de las letras
    $pdf->SetFont('Arial', '', 8); // Eliminar el parámetro 'true' para evitar subrayado en amarillo

    // Logo de la empresa (en la esquina superior izquierda, más pequeño)
    $pdf->Image('../images/Logo Mundo 3d.png',10,5,20); // Ajusta las coordenadas y el ancho según sea necesario
    $pdf->Ln(30); // Salto de línea

    // Título del reporte en un cuadro azul con letras blancas (a la derecha)
    $pdf->SetFillColor(0, 102, 204); // Color de fondo azul
    $pdf->SetTextColor(255, 255, 255); // Color de texto blanco
    $pdf->SetFont('Arial', '', 12); // Quitar la negrita y reducir el tamaño de las letras

    // Obtener el ancho del texto "MUNDO 3D - Reporte de Usuarios"
    $anchoTexto = $pdf->GetStringWidth('MUNDO 3D - Reporte de Usuarios');
    
    // Definir el tamaño del recuadro ajustado al texto
    $altoRecuadro = 10; // Alto del recuadro
    $anchoRecuadro = $anchoTexto + 10; // Ancho del recuadro (más margen)
    $x = $pdf->GetPageWidth() - $anchoRecuadro - 10; // Posición X para alinear a la derecha
    $y = 10; // Posición Y para alinear arriba
    
    // Escribir el texto en el recuadro
    $pdf->SetXY($x, $y + 1);
    $pdf->Cell($anchoRecuadro, $altoRecuadro, 'MUNDO 3D - Reporte de Usuarios', 0, 0, 'C', true);
    $pdf->Ln(); // Salto de línea
    $pdf->Ln(); // Salto de línea adicional

    // Definir el encabezado del PDF
    $pdf->SetTextColor(255, 255, 255); // Color de texto blanco
    $pdf->SetFillColor(50, 50, 50); // Color de fondo oscuro
    $pdf->SetFont('Arial', 'B', 8); // Negrita para el encabezado y reducir el tamaño de las letras
    $pdf->Cell(30, 10, 'Identificacion', 1, 0, 'C', true); // Encabezado de la columna 1
    $pdf->Cell(40, 10, 'Nombre completo', 1, 0, 'C', true); // Encabezado de la columna 2
    $pdf->Cell(30, 10, 'Telefono', 1, 0, 'C', true); // Encabezado de la columna 3
    $pdf->Cell(50, 10, 'Email', 1, 0, 'C', true); // Encabezado de la columna 4 (Agrandada)
    $pdf->Cell(20, 10, 'Ciudad', 1, 0, 'C', true); // Encabezado de la columna 5 (Achicada)
    $pdf->Cell(40, 10, 'Direccion', 1, 0, 'C', true); // Encabezado de la columna 6 (Achicada)
    $pdf->Cell(20, 10, 'Rol', 1, 0, 'C', true); // Encabezado de la columna 7
    $pdf->Cell(30, 10, 'Estado', 1, 1, 'C', true); // Encabezado de la columna 9 (Achicada)
    
    // Función para obtener la etiqueta de rol correspondiente
    function obtenerEtiquetaRol($rol) {
        switch ($rol) {
            case '1':
                return 'ADMI';
            case '3':
                return 'USU';
            case '2':
                return 'COL';
            default:
                return '';
        }
    }

    // Consultar la base de datos para obtener los datos de la tabla de usuarios
    $sql = "SELECT Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Rol, Usu_Pedidos, Usu_Estado FROM usuario";
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
    // Cambiar el color de fondo si el estado es "inactivo"
    if ($row['Usu_Estado'] == 'inactivo') {
        $pdf->SetFillColor(255, 0, 0); // Cambiar a rojo (RGB: 255, 0, 0)
    } else {
        $pdf->SetFillColor(0, 255, 0); // Cambiar a verde (RGB: 0, 255, 0)
    }

    // Imprimir los datos en formato horizontal
    $pdf->Cell(30, 8, utf8_decode($row['Usu_Identificacion']), 1, 0, 'C', true); // Datos de la columna 1
    $pdf->Cell(40, 8, utf8_decode($row['Usu_Nombre_completo']), 1, 0, 'C', true); // Datos de la columna 2
    $pdf->Cell(30, 8, utf8_decode($row['Usu_Telefono']), 1, 0, 'C', true); // Datos de la columna 3
    $pdf->Cell(50, 8, utf8_decode($row['Usu_Email']), 1, 0, 'C', true); // Datos de la columna 4 (Agrandada)
    $pdf->Cell(20, 8, utf8_decode($row['Usu_Ciudad']), 1, 0, 'C', true); // Datos de la columna 5 (Achicada)
    $pdf->Cell(40, 8, utf8_decode($row['Usu_Direccion']), 1, 0, 'C', true); // Datos de la columna 6 (Achicada)
    $pdf->Cell(20, 8, obtenerEtiquetaRol($row['Usu_Rol']), 1, 0, 'C', true); // Datos de la columna 7
    $pdf->Cell(30, 8, utf8_decode($row['Usu_Estado']), 1, 1, 'C', true); // Datos de la columna 9 (Achicada)
}
    
    // Generar y descargar el PDF con el nombre adecuado
    $pdf->Output('Reporte_Usuarios.pdf', 'D');
}

// Generar el reporte de usuarios
generarReporteUsuarios($conexion);
?>
