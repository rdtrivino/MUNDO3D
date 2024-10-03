<?php
    // Establecer las cabeceras para indicar que se va a enviar un archivo de Excel
    date_default_timezone_set('America/Bogota');
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=exportar_" . date('Y_m_d_H_i_s') . ".xls");

    // Incluir el archivo de conexión a la base de datos
    include __DIR__ . '/../conexion.php';

    // Establecer la codificación UTF-8 para la conexión MySQL
    mysqli_set_charset($link, "utf8");

    // Comenzar a escribir el contenido del archivo Excel
    $output = "";

    if ($_GET['tabla'] == 'pedidos') {

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
        $output .= "<th>Tipo de impresion</th>";
        $output .= "<th>Color</th>";
        $output .= "<th>Observacion</th>";
        $output .= "</tr>";
        $output .= "</thead>";
        $output .= "<tbody>";

        // Consulta SQL para obtener los datos de la tabla pedidos
        $query = mysqli_query($link, "SELECT pedidos.*, pedido_estado.Es_Nombre AS Pe_Estado, productos.Pro_Nombre AS Pe_Producto 
        FROM pedidos
        INNER JOIN pedido_estado ON pedidos.Pe_Estado = pedido_estado.Es_Codigo
        INNER JOIN productos ON pedidos.Pe_Producto = productos.Identificador") or die(mysqli_error($link));
        while($fetch = mysqli_fetch_array($query)) {
            $output .= "<tr>";
            $output .= "<td>" . $fetch['Identificador'] . "</td>";
            $output .= "<td>" . $fetch['Pe_Cliente'] . "</td>";
            $output .= "<td>" . $fetch['Pe_Estado'] . "</td>";
            $output .= "<td style='white-space: nowrap;'>" . $fetch['Pe_Producto'] . "</td>"; //Se incluye estilo para el texto no se ajuste
            $output .= "<td>" . $fetch['Pe_Cantidad'] . "</td>";
            $output .= "<td>" . $fetch['Pe_Fechapedido'] . "</td>";
            $output .= "<td>" . $fetch['Pe_Fechaentrega'] . "</td>";
            $output .= "<td>" . $fetch['pe_tipo_impresion'] . "</td>";
            $output .= "<td>" . $fetch['pe_color'] . "</td>";
            $output .= "<td>" . $fetch['Pe_Observacion'] . "</td>";
            $output .= "</tr>";
        }

        // Cerrar la etiqueta <tbody> y <table>
        $output .= "</tbody>";
        $output .= "</table>";

    } elseif ($_GET['tabla'] == 'productos') {
        // Incluir las etiquetas <table>, <thead> y <tbody>
        $output .= "<table>";
        $output .= "<thead>";
        $output .= "<tr>";
        $output .= "<th>Codigo</th>";
        $output .= "<th>Nombre</th>";
        $output .= "<th>Descripcion</th>";
        $output .= "<th>Categoria</th>";
        $output .= "<th>Cantidad</th>";
        $output .= "<th>Precio de venta</th>";
        $output .= "<th>Costo</th>";
        $output .= "<th>Estado</th>";
        $output .= "</tr>";
        $output .= "</thead>";
        $output .= "<tbody>";

        // Consulta SQL para obtener los datos de la tabla productos
        $query = mysqli_query($link, "SELECT productos.*, categoria.Cgo_Nombre AS Pro_Categoria 
        FROM productos
        INNER JOIN categoria ON productos.Pro_Categoria = categoria.Cgo_Codigo") or die(mysqli_error($link));
        while($fetch = mysqli_fetch_array($query)) {
            $output .= "<tr>";
            $output .= "<td>" . $fetch['Identificador'] . "</td>";
            $output .= "<td style='white-space: nowrap;'>" . $fetch['Pro_Nombre'] . "</td>";
            $output .= "<td style='white-space: nowrap;'>" . $fetch['Pro_Descripcion'] . "</td>";
            $output .= "<td>" . $fetch['Pro_Categoria'] . "</td>";
            $output .= "<td>" . $fetch['Pro_Cantidad'] . "</td>";
            $output .= "<td>" . $fetch['Pro_PrecioVenta'] . "</td>";
            $output .= "<td>" . $fetch['Pro_Costo'] . "</td>";
            $output .= "<td>" . $fetch['Pro_Estado'] . "</td>";
            $output .= "</tr>";
        }

        // Cerrar la etiqueta <tbody> y <table>
        $output .= "</tbody>";
        $output .= "</table>";
    }
    // Imprimir el contenido del archivo Excel
    echo $output;
?>
