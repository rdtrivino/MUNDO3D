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
// Esta función devuelve un array con los estados de la tabla pedido_estado
function obtenerEstadosPedidos($link) {
    // Array para almacenar los resultados
    $estados = array();

    // Consulta SQL para obtener los estados
    $sql = "SELECT Es_Codigo, Es_Nombre FROM pedido_estado";

    // Ejecutar la consulta
    $result = mysqli_query($link, $sql);

    // Verificar si la consulta fue exitosa
    if ($result) {
        // Iterar sobre los resultados y agregarlos al array de estados
        while ($row = mysqli_fetch_assoc($result)) {
            $estados[] = $row;
        }
    } else {
        // Si hay un error en la consulta, puedes manejarlo aquí
        echo "Error al obtener los estados: " . mysqli_error($link);
    }

    // Devolver el array de estados
    return $estados;
}
// Función para obtener todos los productos disponibles desde la base de datos
function obtenerProductos($link) {
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
if (isset($_POST['guardar_cambios'])) {
    $identificador = $_POST['Identificador'];
    $cliente = $_POST['Pe_Cliente'];
    $estado = $_POST['Pe_Estado'];
    $producto = $_POST['Pe_Producto'];
    $cantidad = $_POST['Pe_Cantidad'];
    $fechaPedido = !empty($_POST['pe_fechapedido_' . $identificador]) ? $_POST['pe_fechapedido_' . $identificador] : '0000-00-00';
    
    // Verificar el formato de la fecha actual
    if (!strtotime($fechaPedido)) {
        echo "error: formato de fecha incorrecto";
        exit; // Salir del script si el formato de fecha es incorrecto
    }

    $fechaEntrega = $_POST['Pe_Fechaentrega'];
    $color = $_POST['pe_color'];
    $observaciones = $_POST['Pe_Observacion'];
    $imagen = $_FILES['imagen'];

    // Manejar la subida de la imagen si existe
    if ($imagen['size'] > 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($imagen["name"]);
        move_uploaded_file($imagen["tmp_name"], $target_file);

        // Guardar la ruta de la imagen en la base de datos
        $sql = "UPDATE pedidos SET Pe_Cliente=?, Pe_Estado=?, Pe_Producto=?, Pe_Cantidad=?, Pe_Fechapedido=?, Pe_Fechaentrega=?, pe_color=?, Pe_Observacion=?, pe_imagen_pedido=? WHERE Identificador=?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param('sisiissssi', $cliente, $estado, $producto, $cantidad, $fechaPedido, $fechaEntrega, $color, $observaciones, $target_file, $identificador);
    } else {
        // Si no se sube una nueva imagen
        $sql = "UPDATE pedidos SET Pe_Cliente=?, Pe_Estado=?, Pe_Producto=?, Pe_Cantidad=?, Pe_Fechapedido=?, Pe_Fechaentrega=?, pe_color=?, Pe_Observacion=? WHERE Identificador=?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param('sisiisssi', $cliente, $estado, $producto, $cantidad, $fechaPedido, $fechaEntrega, $color, $observaciones, $identificador);
    }

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $link->close();
}

?>
