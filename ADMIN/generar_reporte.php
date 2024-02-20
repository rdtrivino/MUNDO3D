<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$conexion = mysqli_connect($host, $user, $password, $dbname);

if (!$conexion) {
    die("Error al conectarse a la Base de Datos: " . mysqli_connect_error());
}
$sql = "SELECT p.Pro_Nombre, p.Pro_Codigo, p.Pro_Descripcion, p.Pro_PrecioVenta, c.Cgo_Nombre, p.imagen_principal
        FROM producto p
        INNER JOIN categoria c ON p.Pro_Categoria = c.Cgo_Codigo";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion)); 
}

require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MUNDO 3D');
$pdf->SetTitle('Reporte de Productos');
$pdf->SetSubject('Reporte de productos generados desde una tabla');
$pdf->SetKeywords('PDF, productos, tabla');

$pdf->setHeaderData('', 0, 'MUNDO 3D/ Reporte de Productos', '', array(0,0,0), array(255,255,255));
$pdf->AddPage();

$html = '
<table border="1">
    <thead>
    <tr>
        <th style="width: 100px; text-align: center; background-color: #9b9b9b;">Nombre</th>
        <th style="width: 50px; text-align: center; background-color: #9b9b9b;">Codigo</th>
        <th style="width: 100px; text-align: center; background-color: #9b9b9b;">Descripción</th>
        <th style="width: 70px; text-align: center; background-color: #9b9b9b;">Precio</th>
        <th style="width: 100px; text-align: center; background-color: #9b9b9b;">Categoria</th>
        <th style="width: 120px;text-align: center; background-color: #9b9b9b;">Imagenes</th>
    </tr>
    </thead>
    <tbody>';

while ($row = mysqli_fetch_assoc($resultado)) {
    $html .= '<tr>';
    $html .= '<td style="width: 100px; text-align: center;">' . $row['Pro_Nombre'] . '</td>';
    $html .= '<td style="width: 50px; text-align: center;">' . $row['Pro_Codigo'] . '</td>';
    $html .= '<td style="width: 100px;">' . $row['Pro_Descripcion'] . '</td>';
    $html .= '<td style="width: 70px; text-align: center;">' . $row['Pro_PrecioVenta'] . '</td>';
    $html .= '<td style="width: 100px; text-align: center;">' . $row['Cgo_Nombre'] . '</td>';
    $html .= '<td style="width: 120px; text-align: center;"><img src="data:image/png;base64,' . base64_encode($row['imagen_principal']) . '" alt="Imagen del producto" style="width: 100px; height: 100px;"></td>';
    $html .= '</tr>';
}

$html .= '
    </tbody>
</table>';


$pdf->writeHTML($html, true, false, true, false, '');

// Ajustar el contenido hacia la derecha
$pdf->SetX(40);

$pdf->Output('Reporte_de_productos.pdf', 'D');
?>
