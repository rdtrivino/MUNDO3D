<?php
// Conectar a la base de datos
// Reemplaza 'localhost', 'usuario', 'contraseña' y 'basededatos' con tus propios valores
$link = mysqli_connect('localhost', 'root', '', 'mundo3d');

// Verificar la conexión
if ($link === false) {
    die("ERROR: No se pudo conectar a la base de datos. " . mysqli_connect_error());
}

// Obtener los datos del producto enviados desde el cliente
$data = json_decode(file_get_contents("php://input"), true);

// Extraer los datos del producto
$producto_id = $data['producto_id']; // Por ejemplo, el ID del producto
$producto_nombre = $data['producto_nombre']; // Nombre del producto
$producto_precio = $data['producto_precio']; // Precio del producto

// Preparar la consulta SQL para insertar el producto en la tabla de pagos
$sql = "INSERT INTO pagos (Identificador_Producto, Monto, Metodo_Pago, Estado) VALUES (?, ?, ?, ?)";

// Preparar la declaración
$stmt = mysqli_prepare($link, $sql);

// Vincular los parámetros
mysqli_stmt_bind_param($stmt, "isds", $producto_id, $producto_precio, $metodo_pago, $estado);

// Definir valores para los parámetros
$metodo_pago = "Efectivo"; // Por ejemplo, método de pago
$estado = "Pendiente"; // Por ejemplo, estado del pago

// Ejecutar la declaración
if (mysqli_stmt_execute($stmt)) {
    // El producto se guardó correctamente en la base de datos
    echo "Producto guardado correctamente en la base de datos.";
} else {
    // Ocurrió un error al guardar el producto en la base de datos
    echo "ERROR: No se pudo guardar el producto en la base de datos. " . mysqli_error($link);
}

// Cerrar la conexión
mysqli_close($link);
?>
