<?php
require_once('../libs/fpdf.php'); // Ajusta la ruta según la ubicación de FPDF en tu proyecto

function generarFactura(array $datos_factura): string {
    // Crear instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar título de la factura
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Factura');
    $pdf->Ln(); // Salto de línea

    // Agregar los datos de la factura
    foreach ($datos_factura as $dato) {
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(40,10,'ID: ' . $dato['id']);
        $pdf->Ln(); // Salto de línea
        $pdf->Cell(40,10,'Cliente: ' . $dato['nombre']);
        $pdf->Ln(); // Salto de línea
        $pdf->Cell(40,10,'Precio: ' . $dato['precio']);
        $pdf->Ln(); // Salto de línea
        $pdf->Cell(40,10,'Cantidad: ' . $dato['cantidad']);
        $pdf->Ln(15); // Salto de línea
    }

    // Nombre y ubicación del archivo PDF
    $pdf_file = 'Factura.pdf';

    // Guardar el PDF en el servidor
    $pdf->Output('F', $pdf_file);

    // Devolver la ruta del archivo PDF
    return $pdf_file;
}
?>
