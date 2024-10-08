<?php
session_start();
require '../conexion.php';
include ("Programas/controlsesion.php");

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

// Consulta SQL para obtener el número total de facturas
$totalFacturasResult = mysqli_query($link, "SELECT COUNT(*) as total FROM factura");
$totalFacturasRow = mysqli_fetch_assoc($totalFacturasResult);
$totalFacturas = $totalFacturasRow['total'];

// Obtener los parámetros de paginación de la URL
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Página actual, por defecto la primera página
$registrosPorPagina = isset($_GET['registrosPorPagina']) ? (int)$_GET['registrosPorPagina'] : 10; // Número de registros por página, por defecto 10
$offset = ($pagina - 1) * $registrosPorPagina; // Calcular el offset para la consulta SQL

//-----------------------------------------------------
// Consulta SQL para obtener las facturas con paginación
$sql = "SELECT * FROM factura ORDER BY id_factura DESC LIMIT $registrosPorPagina OFFSET $offset";
//-----------------------------------------------------

function obtenerNombreProducto($IdentificadorProducto, $conexion)
{
    $sql = "SELECT pro_nombre FROM productos WHERE Identificador = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $IdentificadorProducto);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nombreProducto);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $nombreProducto ? $nombreProducto : "Producto no encontrado";
}

// Función para obtener todos los productos disponibles desde la base de datos
function obtenerProductos($link)
{
    // Array para almacenar los productos
    $productos = array();

    // Consulta SQL para obtener todos los productos
    $sql = "SELECT Identificador, Pro_Nombre FROM productos";

    // Ejecutar la consulta
    $result = mysqli_query($link, $sql);

    // Verificar si la consulta fue exitosa y procesar los resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Iterar sobre los resultados y almacenar cada producto en el array
        while ($row = mysqli_fetch_assoc($result)) {
            $productos[] = $row;
        }
    }

    // Retornar el array de productos
    return $productos;
}

$stmt->close();
$link->close();

?>