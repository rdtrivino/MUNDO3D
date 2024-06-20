<?php
include __DIR__ . '/../conexion.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nombre_producto'])) {
    $nombreProducto = mysqli_real_escape_string($link, $_GET['nombre_producto']);
    $sql = "SELECT Pro_Nombre, Pro_Descripcion FROM productos WHERE Pro_Nombre LIKE '%$nombreProducto%'";
    $result = mysqli_query($link, $sql);

    $productos = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $productos[] = $row;
        }
    }

    echo json_encode($productos);
    mysqli_free_result($result);
}

mysqli_close($link);
?>