<?php
require_once('tcpdf/tcpdf.php');

// Crea una nueva instancia de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Establece el título del documento
$pdf->SetTitle('Reporte de Pedidos');

// Agrega una nueva página al documento
$pdf->AddPage();

// Agrega contenido HTML al documento (puedes generar este contenido desde una consulta SQL)
$html = '
    <h1>Reporte de Pedidos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID de Pedido</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Juan Pérez</td>
                <td>Producto A</td>
                <td>2</td>
                <td>$50.00</td>
                <td>2024-02-10</td>
            </tr>
            <!-- Aquí irían más filas con datos de los pedidos -->
        </tbody>
    </table>';

$pdf->writeHTML($html, true, false, true, false, '');

// Genera el archivo PDF y lo envía al navegador para su descarga
$pdf->Output('reporte_pedidos.pdf', 'D');
?>
