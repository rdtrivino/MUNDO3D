<?php
// Incluir el archivo de conexión
include("..\conexion.php");

// Verificar si se proporcionó un término de búsqueda
if (isset($_GET[''])) {
    // Obtener el término de búsqueda del parámetro GET
    $searchTerm = $_GET[''];

    // Consulta a la base de datos con la búsqueda (aquí puedes personalizar tu consulta)
    $query = "SELECT Pro_Nombre FROM producto
              WHERE Pro_Nombre LIKE '%$searchTerm%' OR Pro_Descripcion LIKE '%$searchTerm%'
              ORDER BY Pro_Nombre";

    $result = mysqli_query($link, $query);

    // Comprobar si se encontraron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Construir una lista de nombres de productos
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>{$row['Pro_Nombre']}</li>";
        }
        echo "</ul>";
    } else {
        echo "No se encontraron resultados.";
    }

    // Liberar los resultados y cerrar la conexión
    mysqli_free_result($result);
    mysqli_close($link);
} else {
    echo "Por favor, ingresa un término de búsqueda.";
}
?>
