<?php
$nombre_archivo_actual = basename($_SERVER['SCRIPT_FILENAME'], '.php');

// Determinar el nombre de la tabla según el nombre del archivo
switch ($nombre_archivo_actual) {
    case 'tables':
        $nombre_tabla = 'usuario';
        break;
    case 'tablesproductos':
        $nombre_tabla = 'producto';
        break;
    case 'tablespedidos':
        $nombre_tabla = 'pedido';
        break;
    default:
        die("No se pudo determinar la tabla actual.");
}

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

// Consultar la base de datos para obtener los datos de la tabla seleccionada
$sql = "SELECT * FROM $nombre_tabla";
$resultado = mysqli_query($conexion, $sql);

// Comprobar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion)); 
}

// Incluir la biblioteca TCPDF
require_once('tcpdf/tcpdf.php');

// Crear una instancia de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Establecer metadatos del PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MUNDO 3D');
$pdf->SetTitle('Reporte de ' . ucfirst($nombre_tabla));
$pdf->SetSubject('Reporte de ' . ucfirst($nombre_tabla) . ' generados desde una tabla');
$pdf->SetKeywords('PDF, ' . $nombre_tabla);

// Establecer datos del encabezado del PDF
$pdf->setHeaderData('', 0, 'MUNDO 3D/ Reporte de ' . ucfirst($nombre_tabla), '', array(0,0,0), array(255,255,255));
$pdf->AddPage(); // Añadir una página al PDF

// Construir la tabla HTML con los datos de la consulta
$html = '
<table border="1">
    <thead>
    <tr>
        <th style="width: 100px; text-align: center; background-color: #9b9b9b;">ID</th>
        <th style="width: 100px; text-align: center; background-color: #9b9b9b;">Nombre</th>
        <th style="width: 100px; text-align: center; background-color: #9b9b9b;">Otro campo</th>
        <!-- Agrega más encabezados según sea necesario -->
    </tr>
    </thead>
    <tbody>';

// Iterar sobre los resultados de la consulta y construir las filas de la tabla HTML
while ($row = mysqli_fetch_assoc($resultado)) {
    $html .= '<tr>';
    $html .= '<td style="width: 100px; text-align: center;">' . $row['ID'] . '</td>';
    $html .= '<td style="width: 100px; text-align: center;">' . $row['Nombre'] . '</td>';
    $html .= '<td style="width: 100px; text-align: center;">' . $row['OtroCampo'] . '</td>';
    // Agrega más campos según sea necesario
    $html .= '</tr>';
}

$html .= '
    </tbody>
</table>';

// Escribir la tabla HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Ajustar el contenido hacia la derecha
$pdf->SetX(40);

// Generar y descargar el PDF con el nombre adecuado
$pdf->Output('Reporte_de_' . $nombre_tabla . '.pdf', 'D');
?>
