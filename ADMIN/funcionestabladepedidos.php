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

// Verificar si se recibió una solicitud para agregar un nuevo pedido
if (isset($_POST['cliente'], $_POST['producto'], $_POST['cantidad'], $_POST['fechaPedido'], $_POST['fechaEntrega'], $_POST['observacion'])) {
    // Incluir la conexión a la base de datos
    include 'conexion.php';

    // Obtener los datos del formulario
    $cliente = $_POST['cliente'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $fechaPedido = $_POST['fechaPedido'];
    $fechaEntrega = $_POST['fechaEntrega'];
    $observacion = $_POST['observacion'];

    // Consulta SQL para insertar un nuevo pedido
    $consulta = "INSERT INTO pedidos (Pe_Cliente, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Fechapedido, Pe_Fechaentrega, Pe_Observacion) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $consulta);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        $estado = 1; // Estado por defecto del pedido (puedes ajustarlo según tus necesidades)

        // Vincular parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "iiissss", $cliente, $estado, $producto, $cantidad, $fechaPedido, $fechaEntrega, $observacion);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo "Pedido agregado exitosamente.";
        } else {
            echo "Error al agregar el pedido: " . mysqli_error($link);
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta: " . mysqli_error($link);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($link);
} else {
}
// Verificar si se recibió el formulario para guardar cambios en el pedido
if (isset($_POST['guardarCambiosPedido'])) {
    // Verificar que se recibieron todos los datos necesarios
    if (isset($_POST['Identificador'], $_POST['cliente'], $_POST['estado'], $_POST['producto'], $_POST['cantidad'], $_POST['fechapedido'], $_POST['fechaentrega'], $_POST['observacion'])) {
        // Obtener los datos del formulario
        $identificador = $_POST['Identificador'];
        $cliente = $_POST['cliente'];
        $estado = $_POST['estado'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $fechapedido = $_POST['fechapedido'];
        $fechaentrega = $_POST['fechaentrega'];
        $observacion = $_POST['observacion'];

        // Actualizar el pedido en la base de datos
        $consulta = "UPDATE pedidos SET Pe_Cliente=?, Pe_Estado=?, Pe_Producto=?, Pe_Cantidad=?, Pe_Fechapedido=?, Pe_Fechaentrega=?, Pe_Observacion=? WHERE Identificador=?";
        $stmt = mysqli_prepare($link, $consulta);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iisdsdssi", $cliente, $estado, $producto, $cantidad, $fechapedido, $fechaentrega, $observacion, $identificador);

            // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(["success" => true, "message" => "Datos actualizados correctamente."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al actualizar los datos del pedido: " . mysqli_error($link)]);
            }

            // Cerrar la declaración
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(["success" => false, "message" => "Error al preparar la consulta: " . mysqli_error($link)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No se recibieron todos los datos necesarios para actualizar el pedido."]);
    }
}


// Verificar si se recibió el identificador del pedido a eliminar
if (isset($_POST['identificador'])) {
    // Obtener el identificador del pedido
    $identificador = $_POST['identificador'];
    
    $consulta = "UPDATE pedidos SET Acciones = 'inactivo' WHERE identificador = ?";
    $stmt = mysqli_prepare($link, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $identificador);

    // Ejecutar la consulta
    if (mysqli_stmt_execute($stmt)) {
        // Si la consulta se ejecutó correctamente, enviar mensaje de éxito
        echo "El pedido ha sido eliminado correctamente.";
    } else {
        // Si hubo un error al ejecutar la consulta, enviar mensaje de error
        echo "Error al eliminar el pedido: " . mysqli_error($link);
    }

    // Cerrar la declaración
    mysqli_stmt_close($stmt);
} else {
    // Si no se recibió el identificador del pedido, enviar un mensaje de error
}
?>
