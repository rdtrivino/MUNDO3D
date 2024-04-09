<?php
// Verificar si se recibieron datos del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['carrito'])) {
    // Decodificar los datos del carrito desde JSON a un array de PHP
    $carrito = json_decode($_POST['carrito'], true);

    // Conectar a la base de datos (cambia estos valores según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mundo3d";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Preparar y ejecutar una consulta para insertar cada producto del carrito en la base de datos
    $stmt = $conn->prepare("INSERT INTO carrito (Ca_Nombre, Ca_PrecioVenta, Ca_Cantidad, imagen_principal) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nombre, $precioVenta, $cantidad, $imagenPrincipal);

    foreach ($carrito as $producto) {
        // Validar y limpiar los datos del producto
        $nombre = $conn->real_escape_string($producto['nombre']);
        $precioVenta = floatval($producto['precio']); // Convertir a número de punto flotante
        $cantidad = 1; // Puedes cambiar esto según lo que necesites
        $imagenPrincipal = $conn->real_escape_string($producto['imagen_principal']);

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            echo "Error al insertar el producto " . $nombre . ": " . $conn->error;
        }
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    // Redirigir a una página de confirmación
    header("Location:..\carrito\index.php");
    exit();
} else {
    // Si no se recibieron datos del carrito, redirigir a una página de error
    header("Location: error.php");
    exit();
}
?>
