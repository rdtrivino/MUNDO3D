<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$conexion = mysqli_connect($host, $user, $password, $dbname);

if (!$conexion) {
    die("Error al conectarse a la Base de Datos: " . mysqli_connect_error());
}

require_once ('../libs/fpdf.php');

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
    $pdf = new FPDF('L');
    $pdf->AddPage();

    $pdf->Image('../images/Logo Mundo 3d.png', 10, 5, 20);
    $pdf->SetFont('Arial', '', 8);

    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial', 'B', 12);

    $anchoTexto = $pdf->GetStringWidth('MUNDO 3D - Reporte de Pedidos');

    $altoRecuadro = 10;
    $anchoRecuadro = $anchoTexto + 10;
    $x = $pdf->GetPageWidth() - $anchoRecuadro - 10;
    $y = 10;

    $pdf->SetFillColor(0, 102, 204);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Rect($x, $y, $anchoRecuadro, $altoRecuadro, 'F');

    $pdf->SetXY($x, $y + 1);
    $pdf->Cell($anchoRecuadro, $altoRecuadro, 'MUNDO 3D - Reporte de Pedidos', 0, 0, 'C');

    $pdf->Ln(20);

    $pdf->SetFillColor(50, 50, 50);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(15, 10, 'Codigo', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'Estado', 1, 0, 'C', true);
    $pdf->Cell(80, 10, 'Producto', 1, 0, 'C', true);
    $pdf->Cell(15, 10, 'Cantidad', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Fecha de Entrega', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Fecha de Pedido', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Cliente', 1, 0, 'C', true);
    $pdf->Cell(65, 10, 'Observación', 1, 1, 'C', true);

    $colorFondo = true;

    $sql = "SELECT * FROM pedidos";
    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    while ($row = mysqli_fetch_assoc($resultado)) {
        $estado = obtenerNombreEstado($conexion, $row['Pe_Estado']);
        $cliente = obtenerNombreCliente($conexion, $row['Pe_Cliente']);
        $producto = obtenerNombreProducto($conexion, $row['Pe_Producto']);

        $pdf->SetFillColor($colorFondo ? 200 : 255, 255, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->Cell(15, 10, utf8_decode(isset($row['Identificador']) ? $row['Identificador'] : ''), 1, 0, 'C', $colorFondo);
        $pdf->Cell(20, 10, utf8_decode($estado), 1, 0, 'C', $colorFondo);
        $pdf->Cell(80, 10, utf8_decode(truncarTexto($producto, 40)), 1, 0, 'C', $colorFondo);
        $pdf->Cell(15, 10, utf8_decode(isset($row['Pe_Cantidad']) ? $row['Pe_Cantidad'] : ''), 1, 0, 'C', $colorFondo);
        $pdf->Cell(25, 10, utf8_decode(isset($row['Pe_Fechaentrega']) ? $row['Pe_Fechaentrega'] : ''), 1, 0, 'C', $colorFondo);
        $pdf->Cell(25, 10, utf8_decode(isset($row['Pe_Fechapedido']) ? $row['Pe_Fechapedido'] : ''), 1, 0, 'C', $colorFondo);
        $pdf->Cell(30, 10, utf8_decode($cliente), 1, 0, 'C', $colorFondo);
        $pdf->MultiCell(65, 10, utf8_decode(truncarTexto(isset($row['Pe_Observacion']) ? $row['Pe_Observacion'] : '', 40)), 1, 'C', $colorFondo);

        $colorFondo = !$colorFondo;
    }


    $pdf->Output('Reporte_Pedidos.pdf', 'D');
}

generarReportePedidos($conexion);
?>