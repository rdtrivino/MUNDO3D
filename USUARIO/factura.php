<?php
session_start(); // Iniciar sesión si no está iniciada

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Manejar el caso en que el usuario no esté autenticado
    // Por ejemplo, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit(); // Finalizar el script para evitar ejecución adicional
}

$cliente_id = $_SESSION['user_id']; // Obtener el ID de usuario de la sesión

$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$link = mysqli_connect($host, $user, $password);

if (!$link) {
    die("Error al conectarse al servidor: " . mysqli_connect_error());
}

if (!mysqli_select_db($link, $dbname)) {
    die("Error al conectarse a la Base de Datos: " . mysqli_error($link));
}

// Establecer la codificación de caracteres para evitar problemas con tildes y caracteres especiales
mysqli_set_charset($link, "utf8");

// Obtener la factura más reciente para el cliente
$sql_factura = "SELECT * 
                FROM factura 
                WHERE numero_documento = ? 
                ORDER BY creado_en DESC 
                LIMIT 1";

$stmt = mysqli_prepare($link, $sql_factura);
mysqli_stmt_bind_param($stmt, "s", $cliente_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $factura = mysqli_fetch_assoc($result);


    // Incluir la biblioteca FPDF
    require_once ('../libs/fpdf.php');

    // Crear un nuevo documento PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Añadir el logo de la empresa
    $pdf->Image('../images/Logo Mundo 3d.png', 10, 10, 30); // Ajusta la ruta y el tamaño según sea necesario

    // Título principal
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0, 10, utf8_decode('Factura de Compra'), 0, 1, 'C');
    $pdf->Ln(10);

    // Título de la factura
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode('Número de Factura: ' . $factura['numero_factura']), 0, 1, 'C');
    $pdf->Ln(10);

    // Encabezado

    // Dirección del cliente
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(130, 5, utf8_decode('Nombre del Cliente: ' . $factura['nombre_cliente']), 0, 0);
    $pdf->Cell(59, 5, '', 0, 1); // Fin de línea
    $pdf->Cell(130, 5, 'Número de Documento: ' . $factura['numero_documento'], 0, 0);
    $pdf->Cell(59, 5, '', 0, 1); // Fin de línea
    $pdf->Cell(130, 5, 'Creado en: ' . $factura['creado_en'], 0, 0);
    $pdf->Cell(25, 5, '', 0, 1); // Fin de línea
    $pdf->Cell(130, 5, 'Estado: ' . $factura['estado'], 0, 0);
    $pdf->Cell(59, 5, '', 0, 1); // Fin de línea

    $pdf->Ln(10); // Espacio adicional

    // Título de detalles de la factura
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode('Detalles de la Factura'), 0, 1, 'C');

    // Tabla de detalles de la factura
    // Tabla de detalles de la factura
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20, 5, 'ID', 1, 0, 'C');
    $pdf->Cell(30, 5, 'Cantidad', 1, 0, 'C'); // Ajustar el ancho de la celda según sea necesario
    $pdf->Cell(110, 5, 'Producto', 1, 0, 'C'); // Ajustar el ancho de la celda según sea necesario
    $pdf->Cell(30, 5, 'Total', 1, 0, 'C');
    $pdf->Ln();

    // Contenido de la tabla (centrado)
    $pdf->Cell(20, 10, $factura['id'], 1, 0, 'C'); // Contenido ID centrado
    $pdf->Cell(30, 10, $factura['cantidad'], 1, 0, 'C'); // Contenido Cantidad centrado
    $pdf->Cell(110, 10, $factura['producto'], 1, 0, 'C'); // Contenido Producto centrado
    $pdf->Cell(30, 10, '$' . number_format($factura['total'], 2), 1, 1, 'C'); // Contenido Total centrado y salto de línea

    $pdf->Ln(10); // Espacio adicional

    // Total
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(130, 10, '', 0, 0);
    $pdf->Cell(25, 10, 'Total:', 0, 0);
    $pdf->Cell(34, 10, '$' . number_format($factura['total'], 2), 0, 1, 'R'); // Fin de línea

    // Footer de los datos de la empresa
    $pdf->SetY(255); // Posiciona 25 unidades desde el fondo de la página
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, utf8_decode('Mundo 3D - Calle 15 #31-42 Bogotá - 3124672836 - rdtrivino6@misena.edu.co'), 0, 1, 'C');

    // Agregar texto adicional
    $pdf->SetFont('Arial', 'I', 8); // Cambiar a una fuente más pequeña o diferente según sea necesario
    $pdf->Cell(0, 10, utf8_decode('Transformando ideas en realidad tridimensional'), 0, 1, 'C');

    // Salida del PDF al navegador
    $pdf->Output('D', 'Factura_' . $factura['numero_factura'] . '.pdf');
} else {
    echo "No se encontró ninguna factura para el cliente.";
}

mysqli_stmt_close($stmt);
mysqli_close($link); // Cerrar conexión a la base de datos al finalizar
?>