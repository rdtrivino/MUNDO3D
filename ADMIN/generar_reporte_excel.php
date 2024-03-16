<?php
    // Establecer las cabeceras para indicar que se va a enviar un archivo de Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=exportar_" . date('Y_m_d_H_i_s') . ".xls");

    // Incluir el archivo de conexión a la base de datos
    include __DIR__ . '/../conexion.php';

    // Comenzar a escribir el contenido del archivo Excel
    $output = "";

    // Incluir las etiquetas <table>, <thead> y <tbody>
    $output .= "<table>";
    $output .= "<thead>";
    $output .= "<tr>";
    $output .= "<th>Codigo</th>";
    $output .= "<th>Cliente</th>";
    $output .= "<th>Estado</th>";
    $output .= "<th>Producto</th>";
    $output .= "<th>Cantidad</th>";
    $output .= "<th>Fecha de pedido</th>";
    $output .= "<th>Fecha de entrega</th>";
    $output .= "<th>Observacion</th>";
    $output .= "</tr>";
    $output .= "</thead>";
    $output .= "<tbody>";

    // Consulta SQL para obtener los datos de la tabla productos
    $query = mysqli_query($link, "SELECT * FROM pedidos") or die(mysqli_error($link));
    while($fetch = mysqli_fetch_array($query)) {
        $output .= "<tr>";
        $output .= "<td>" . $fetch['Identificador'] . "</td>";
        $output .= "<td>" . $fetch['Pe_Cliente'] . "</td>";
        $output .= "<td>" . $fetch['Pe_Estado'] . "</td>";
        $output .= "<td>" . $fetch['Pe_Producto'] . "</td>";
        $output .= "<td>" . $fetch['Pe_Cantidad'] . "</td>";
        $output .= "<td>" . $fetch['Pe_Fechapedido'] . "</td>";
        $output .= "<td>" . $fetch['Pe_Fechaentrega'] . "</td>";
		$output .= "<td>" . $fetch['Pe_Observacion'] . "</td>";
        $output .= "</tr>";
    }

    // Cerrar la etiqueta <tbody> y <table>
    $output .= "</tbody>";
    $output .= "</table>";

    // Imprimir el contenido del archivo Excel
    echo $output;
?>