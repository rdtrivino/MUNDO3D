<?php
session_start();
require '../conexion.php';

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit(); 
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

function obtenerNombreProducto($codigoProducto, $tu_conexion) {
    $sql = "SELECT pro_nombre FROM producto WHERE pro_codigo = " . $codigoProducto;
    $resultado = mysqli_query($tu_conexion, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['pro_nombre'];
    } else {
        return "Producto no encontrado";
    }
}

// Función para obtener el nombre del estado a partir del código
function obtenerNombreEstado($codigoEstado, $tu_conexion) {
    $sql = "SELECT Es_Nombre FROM pedido_estado WHERE Es_Codigo = " . $codigoEstado;
    $resultado = mysqli_query($tu_conexion, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['Es_Nombre'];
    } else {
        return "Estado no encontrado";
    }
}

// Aquí deberías tener la lógica para conectar a la base de datos

if (isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];

    // Consulta para cambiar el estado del pedido
    $consulta = "UPDATE pedidos SET Activo = IF(Activo = 1, 0, 1) WHERE Codigo = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $codigo);
    if (mysqli_stmt_execute($stmt)) {
        echo "El estado del pedido ha sido actualizado exitosamente.";
    } else {
        echo "Error al actualizar el estado del pedido.";
    }
} else {
    echo "No se recibió el código del pedido.";
}
?>
