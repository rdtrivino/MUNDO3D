<?php
session_start();
require '../conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit(); 
}
$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

// Función para obtener el nombre del producto a partir de su código
function obtenerNombreProducto($IdentificadorProducto, $conexion) {
    $sql = "SELECT pro_nombre FROM productos WHERE Identificador = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $IdentificadorProducto);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nombreProducto);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $nombreProducto ? $nombreProducto : "Producto no encontrado";
}

// Función para obtener el nombre del estado a partir del código
function obtenerNombreEstado($IdentificadorEstado, $conexion) {
    $sql = "SELECT Es_Nombre FROM pedido_estado WHERE Es_Codigo = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $IdentificadorEstado);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nombreEstado);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $nombreEstado ? $nombreEstado : "Estado no encontrado";
}

// Verificar si se recibió una solicitud para guardar cambios en el pedido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_cambios_pedido'])) {
    // Código para guardar los cambios en el pedido
    if (isset($_POST['Identificador'])) {
        // Obtener el código del pedido a actualizar
        $IdentificadorPedido = $_POST['Identificador'];

        // Obtener los demás datos del formulario
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $fechaEntrega = $_POST['fechaEntrega'];
        $fechaPedido = $_POST['fechaPedido'];
        $estado = $_POST['estado'];
        $observacion = $_POST['observacion'];

        // Consulta para actualizar los datos del pedido en la base de datos
        $consulta_actualizar = "UPDATE pedidos SET Pe_Cantidad=?, Pe_Precio=?, Pe_Fechaentrega=?, Pe_Fechapedido=?, Pe_Estado=?, Pe_Observacion=? WHERE Identificador=?";
        $stmt_actualizar = mysqli_prepare($link, $consulta_actualizar);
        mysqli_stmt_bind_param($stmt_actualizar, "ddssssi", $cantidad, $precio, $fechaEntrega, $fechaPedido, $estado, $observacion, $IdentificadorPedido);

        // Ejecutar la consulta de actualización
        if (mysqli_stmt_execute($stmt_actualizar)) {
            echo "Los cambios se han guardado correctamente.";
        } else {
            echo "Error al guardar los cambios en el pedido: " . mysqli_error($link);
        }

        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt_actualizar);
    } else {
        echo "No se recibió el código del pedido a actualizar.";
    }

    // Terminar la ejecución del script
    exit;
}

// Verificar si se recibió una solicitud para ocultar un pedido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ocultar_pedido'])) {
    // Código para ocultar un pedido
    // Sanitiza y obtén el código del pedido
    $IdentificadorPedido = mysqli_real_escape_string($link, $_POST['Identificador']);

    // Consulta para cambiar el estado del pedido en la base de datos
    $sql = "UPDATE pedidos SET Acciones = 'inactivo' WHERE Identificador = '$IdentificadorPedido'";

    // Ejecuta la consulta
    if (mysqli_query($link, $sql)) {
        // Si la consulta se ejecuta con éxito, devuelve un mensaje de éxito
        echo "El pedido se ha eliminado correctamente.";
    } else {
        // Si hay algún error en la consulta, devuelve un mensaje de error
        echo "Error al eliminar el pedido: " . mysqli_error($link);
    }

    // Terminar la ejecución del script
    exit;
}

// Verificar si se recibieron los datos del formulario para agregar un nuevo pedido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_pedido'])) {
    // Código para agregar un nuevo pedido
    // Obtener los datos del formulario
    $Identificador = $_POST['Identificador'];
    $estado = $_POST['estado'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $fechaEntrega = $_POST['fechaEntrega'];
    $fechaPedido = $_POST['fechaPedido'];
    $cliente = $_POST['cliente'];
    $observacion = $_POST['observacion'];
    // Asignar el valor 'Activo' al campo 'Acciones' por defecto
    $acciones = 'Activo';

    // Query SQL para insertar el nuevo pedido
    $sql = "INSERT INTO pedidos (Identificador, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Precio, Pe_Fechaentrega, Pe_Fechapedido, Pe_Cliente, Pe_Observacion, Acciones) 
            VALUES ('$Identificador', '$estado', '$producto', '$cantidad', '$precio', '$fechaEntrega', '$fechaPedido', '$cliente', '$observacion', '$acciones')";

    // Ejecutar la consulta
    if (mysqli_query($link, $sql)) {
        // Si la inserción fue exitosa, mostrar un mensaje de éxito
        echo "¡Pedido agregado correctamente!";
    } else {
        // Si ocurrió un error, mostrar un mensaje de error
        echo "Error al agregar el pedido: " . mysqli_error($link);
    }

    // Terminar la ejecución del script
    exit;
}
?>
