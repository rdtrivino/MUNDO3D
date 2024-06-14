<?php
include __DIR__ . '/../conexion.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nombre_producto'])) {
    $nombreProducto = mysqli_real_escape_string($link, $_GET['nombre_producto']);
    $sql = "SELECT * FROM productos WHERE Pro_Nombre LIKE '%$nombreProducto%'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Resultados de la búsqueda:</h2>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>{$row['Pro_Nombre']} - {$row['Pro_Descripcion']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No se encontraron productos que coincidan con '{$nombreProducto}'.</p>";
    }

    mysqli_free_result($result);
}

mysqli_close($link);
?>