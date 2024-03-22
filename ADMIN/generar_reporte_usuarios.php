<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$conexion = mysqli_connect($host, $user, $password, $dbname);

if (!$conexion) {
    die("Error al conectarse a la Base de Datos: " . mysqli_connect_error());
}

require_once('../libs/fpdf.php');

function generarReporteUsuarios($conexion) {
    $pdf = new FPDF('L');
    $pdf->AddPage();

    $pdf->SetFont('Arial', '', 8);

    $pdf->Image('../images/Logo Mundo 3d.png',10,5,20);
    $pdf->Ln(30);

    $pdf->SetFillColor(0, 102, 204);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', '', 12);

    $anchoTexto = $pdf->GetStringWidth('MUNDO 3D - Reporte de Usuarios');
    $altoRecuadro = 10;
    $anchoRecuadro = $anchoTexto + 10;
    $x = $pdf->GetPageWidth() - $anchoRecuadro - 30;
    $y = 10;

    $pdf->SetXY($x, $y + 1);
    $pdf->Cell($anchoRecuadro, $altoRecuadro, 'MUNDO 3D - Reporte de Usuarios', 0, 0, 'C', true);
    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFillColor(50, 50, 50);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(30, 10, 'Identificacion', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Nombre completo', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Telefono', 1, 0, 'C', true);
    $pdf->Cell(50, 10, 'Email', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'Ciudad', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Direccion', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'Rol', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Estado', 1, 1, 'C', true);

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

    $sql = "SELECT Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Rol, Usu_Pedidos, Usu_Estado FROM usuario";
    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 8);

    $colorFondo = true;

    while ($row = mysqli_fetch_assoc($resultado)) {
        if ($row['Usu_Estado'] == 'inactivo') {
            $pdf->SetFillColor(255, 0, 0);
        } else {
            $pdf->SetFillColor(0, 255, 0);
        }

        $pdf->Cell(30, 8, utf8_decode($row['Usu_Identificacion']), 1, 0, 'C', true);
        $pdf->Cell(40, 8, utf8_decode($row['Usu_Nombre_completo']), 1, 0, 'C', true);
        $pdf->Cell(30, 8, utf8_decode($row['Usu_Telefono']), 1, 0, 'C', true);
        $pdf->Cell(50, 8, utf8_decode($row['Usu_Email']), 1, 0, 'C', true);
        $pdf->Cell(20, 8, utf8_decode($row['Usu_Ciudad']), 1, 0, 'C', true);
        $pdf->Cell(40, 8, utf8_decode($row['Usu_Direccion']), 1, 0, 'C', true);
        $pdf->Cell(20, 8, obtenerEtiquetaRol($row['Usu_Rol']), 1, 0, 'C', true);
        $pdf->Cell(30, 8, utf8_decode($row['Usu_Estado']), 1, 1, 'C', true);
    }

    $pdf->Output('Reporte_Usuarios.pdf', 'D');
}

generarReporteUsuarios($conexion);
?>
