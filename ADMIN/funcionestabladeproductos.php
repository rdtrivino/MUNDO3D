<?php
session_start();
require '../conexion.php';

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

$sql = "SELECT p.Pro_Nombre, p.Pro_Codigo, p.Pro_Descripcion, p.Pro_PrecioVenta, c.Cgo_Nombre,p.Pro_Cantidad, p.Pro_Costo, p.imagen_principal
        FROM producto p
        INNER JOIN categoria c ON p.Pro_Categoria = c.Cgo_Codigo";
$resultado = mysqli_query($link, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($link));
}
$sql_categorias = "SELECT * FROM categoria";
$resultado_categorias = mysqli_query($link, $sql_categorias);

if (!$resultado_categorias) {
    die("Error en la consulta de categorías: " . mysqli_error($link));
}

// Almacenar las categorías en un arreglo
$categorias = [];
while ($row = mysqli_fetch_assoc($resultado_categorias)) {
    $categorias[] = $row;
}

// Consulta para obtener los productos
$sql = "SELECT p.Pro_Nombre, p.Pro_Codigo, p.Pro_Descripcion, p.Pro_PrecioVenta, c.Cgo_Nombre, p.Pro_Cantidad, p.Pro_Costo, p.imagen_principal
        FROM producto p
        INNER JOIN categoria c ON p.Pro_Categoria = c.Cgo_Codigo
        WHERE p.Pro_Estado = 'activo'";

$resultado_productos = mysqli_query($link, $sql);


if (!$resultado_productos) {
    die("Error en la consulta de productos: " . mysqli_error($link));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];

    // Procesar la imagen
    $imagen = $_FILES['imagen']['tmp_name'];
    $imagen_contenido = file_get_contents($imagen);

    // Insertar los datos en la base de datos
    $sql_insert = "INSERT INTO producto (Pro_Codigo, Pro_Nombre, Pro_Descripcion, Pro_PrecioVenta, Pro_Categoria, Pro_Cantidad, Pro_Costo, imagen_principal) 
    VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($link, $sql_insert);
mysqli_stmt_bind_param($stmt, "ssdsdds", $nombre, $descripcion, $precio, $categoria, $cantidad, $costo, $imagen_contenido);

if (mysqli_stmt_execute($stmt)) {
// Obtener el último ID insertado
$ultimo_id_insertado = mysqli_insert_id($link);

} else {
die("Error en la inserción del producto: " . mysqli_error($link));
}
if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['guardar_cambios'])) {
    // Obtener el código del producto a actualizar
    $codigo = $_POST['codigo']; // Corrección aquí

    // Obtener los demás datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];

    // Procesar la imagen (si se ha subido una nueva)
    $imagen_contenido = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_temporal = $_FILES['imagen']['tmp_name'];
        $imagen_contenido = file_get_contents($imagen_temporal);
    }

    // Actualizar los datos en la base de datos
    $consulta = "UPDATE producto SET Pro_Nombre=?, Pro_Descripcion=?, Pro_PrecioVenta=?, Pro_Categoria=?, Pro_Cantidad=?, Pro_Costo=?, imagen_principal=? WHERE Pro_Codigo=?";
    $stmt = mysqli_prepare($link, $consulta); // Corrección aquí
    mysqli_stmt_bind_param($stmt, "ssdsddsi", $nombre, $descripcion, $precio, $categoria, $cantidad, $costo, $imagen_contenido, $codigo);

    if (mysqli_stmt_execute($stmt)) {
        // Si la consulta se ejecutó con éxito, devuelve un mensaje de éxito
        echo "Los datos se actualizaron correctamente";
    } else {
        // Si hay algún error en la consulta, devuelve un mensaje de error
        echo "Error al actualizar los datos: " . mysqli_error($link);
    }
}
// Tu código para conectarte a la base de datos y realizar la consulta SQL

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo"])) {
    $codigoProducto = $_POST["codigo"];
    
    // Consulta SQL para actualizar el estado del producto a "inactivo"
    $sql_update = "UPDATE producto SET Pro_Estado = 'inactivo' WHERE Pro_Codigo = $codigoProducto";
    
    if (mysqli_query($link, $sql_update)) {
        echo "El producto se ha marcado como inactivo correctamente";
    } else {
        echo "Error al actualizar el estado del producto: " . mysqli_error($link);
    }
}


}