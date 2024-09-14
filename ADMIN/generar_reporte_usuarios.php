<?php

include __DIR__ . '/../conexion.php';

require_once 'vendor/autoload.php'; // Ruta donde se encuentra autoload.php de Composer

use Dompdf\Dompdf;
use Dompdf\Options;

function obtenerEtiquetaRol($rol)
{
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

function generarReporteUsuarios($link)
{
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);

    $pdf = new Dompdf($options);
    $pdf->setPaper('A4', 'landscape');

    ob_start();
    ?>
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 10pt;
                }
                .header {
                    background-color: #0066CC;
                    color: #FFFFFF;
                    text-align: center;
                    padding: 10px;
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid black;
                    padding: 5px;
                    text-align: center;
                }
                .odd {
                    background-color: #E6E6E6;
                }
                .even {
                    background-color: #FFFFFF;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <img src="../images/Logo Mundo 3d.png" alt="Logo Mundo 3D" style="height: 20px; vertical-align: middle;">
                <span style="vertical-align: middle; font-size: 12pt; font-weight: bold;">MUNDO 3D - Reporte de Usuarios</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre completo</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Dirección</th>
                        <th>Rol</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $colorFondo = 'odd';
                    $sql = "SELECT Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Rol, Usu_Estado FROM usuario";
                    $resultado = mysqli_query($link, $sql);

                    if (!$resultado) {
                        die("Error en la consulta: " . mysqli_error($link));
                    }

                    while ($row = mysqli_fetch_assoc($resultado)) {
                        $estadoColor = ($row['Usu_Estado'] == 'inactivo') ? 'style="background-color: #FF0000;"' : 'style="background-color: #00FF00;"';
                        ?>
                            <tr class="<?php echo $colorFondo; ?>">
                                <td><?php echo utf8_decode($row['Usu_Identificacion']); ?></td>
                                <td><?php echo utf8_decode($row['Usu_Nombre_completo']); ?></td>
                                <td><?php echo utf8_decode($row['Usu_Telefono']); ?></td>
                                <td><?php echo utf8_decode($row['Usu_Email']); ?></td>
                                <td><?php echo utf8_decode($row['Usu_Ciudad']); ?></td>
                                <td><?php echo utf8_decode($row['Usu_Direccion']); ?></td>
                                <td><?php echo obtenerEtiquetaRol($row['Usu_Rol']); ?></td>
                                <td <?php echo $estadoColor; ?>><?php echo utf8_decode($row['Usu_Estado']); ?></td>
                            </tr>
                            <?php
                            $colorFondo = ($colorFondo == 'odd') ? 'even' : 'odd';
                    }
                    ?>
                </tbody>
            </table>
        </body>
        </html>
        <?php
        $html = ob_get_clean();

        $pdf->loadHtml($html);
        $pdf->render();

        $pdf->stream('Reporte_Usuarios.pdf', array('Attachment' => 1));
}

generarReporteUsuarios($link);
mysqli_close($link);
?>
