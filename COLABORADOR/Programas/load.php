<?php
session_start();
include __DIR__ . '/../../conexion.php';

$columns = [];

if (isset($_GET['tabla'])) {
    $tabla_seleccionada = $_GET['tabla'];
    
    // Definir encabezados específicos para cada tabla
    if ($tabla_seleccionada == 'pedidos') {
        $columns = array("ID", "Cliente", "Estado", "Producto", "Cantidad", "Fecha Pedido", "Fecha Entrega", "Imagen", "Tipo", "Color", "Observación", "Editar");
    } elseif ($tabla_seleccionada == 'productos') {
        $columns = array("ID", "Nombre", "Descripción", "Categoría", "Cantidad", "Precio Venta", "Costo", "Imagen", "Estado", "Editar");
    }
}

$table = $_GET['tabla'];

$campo = isset($_POST['campo']) ? $link->real_escape_string($_POST['campo']) : '';

$where = '';

if (!empty($campo)) {
    $where = "WHERE (";

    foreach ($columns as $columna) {
        $where .= $columna . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr($where, 0, -3); // Elimina el último " OR "
    $where .= ")";
}

$sql = "SELECT " . implode(", ", $columns) . "
        FROM $table
        $where ";

$resultado = $link->query($sql);
$num_rows = $resultado->num_rows;

$html = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $html .= '<tr>';
        foreach ($columns as $columna) {
            $html .= '<td>' . $row[$columna] . '</td>';
        }
        $html .= '<td><a href="">Editar</a></td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="' . count($columns) . '">No se encontraron resultados de la búsqueda</td>';
    $html .= '</tr>';
}

echo json_encode($html);

/*Limit*/

$limit = isset($_POST['registros']) ? $link->real_escape_string($_POST['registros']) : 10;
$sLimit = "LIMIT $limit";

/*Consulta*/

$sql = "SELECT " . implode(", ", $columns) . "
FROM $table
$where
$sLimit";
$resultado = $link->query($sql);
$num_rows = $resultado->num_rows;

?>