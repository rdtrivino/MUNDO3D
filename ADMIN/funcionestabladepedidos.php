<?php
session_start();
require '../conexion.php';

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];


// Consulta SQL para obtener el número total de productos
$totalProductosResult = mysqli_query($link, "SELECT COUNT(*) as total FROM productos");
$totalProductosRow = mysqli_fetch_assoc($totalProductosResult);
$totalProductos = $totalProductosRow['total'];

// Obtener los parámetros de paginación de la URL
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Página actual, por defecto la primera página
$registrosPorPagina = isset($_GET['registrosPorPagina']) ? (int)$_GET['registrosPorPagina'] : 10; // Número de registros por página, por defecto 10
$offset = ($pagina - 1) * $registrosPorPagina; // Calcular el offset para la consulta SQL

//--------------------------------------------------------
// Consulta SQL para obtener los pedidos con paginación
$sql = "SELECT Identificador, Pe_Cliente, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Fechapedido, Pe_Fechaentrega, Pe_Observacion, nombre_imagen 
        FROM pedidos
        ORDER BY Identificador DESC
        LIMIT $registrosPorPagina OFFSET $offset";
//--------------------------------------------------------
function obtenerNombreProducto($IdentificadorProducto, $conexion)
{
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
function obtenerNombreEstado($IdentificadorEstado, $conexion)
{
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
function obtenerEstadosPedidos($link)
{
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
function obtenerProductos($link)
{
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
    $fechaEntrega = $_POST['Pe_Fechaentrega'];
    $fechaPedido = $_POST['Pe_Fechapedido'];
    $color = $_POST['pe_color'];
    $observaciones = $_POST['Pe_Observacion'];
    $imagen = null;

    // Obtener la extensión del archivo
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Obtener la extensión del archivo
        $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $ruta_destino = "../images/imagenes_pedidos/"; // Ruta donde quieres guardar la imagen
        $nombre_imagen = "pedido-" . $identificador . ".$extension"; // Nombre que deseas para la imagen

        // Combinar la ruta de destino con el nombre de la imagen
        $imagen = $ruta_destino . $nombre_imagen;

        // Mover la imagen cargada a la ruta específica
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen)) {
            //echo "La imagen se ha guardado correctamente en: " . $ruta_completa;
        } else {
            echo "Error al guardar la imagen.";
        }
    } else {
        // Si no se ha cargado ninguna imagen nueva, obtener el nombre de imagen existente de la base de datos
        $query = "SELECT nombre_imagen FROM pedidos WHERE Identificador = $identificador";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        $imagen = $row['nombre_imagen'];
    }

    // Guardar los registros en la base de datos
    $sql = "UPDATE pedidos SET Pe_Cliente=?, Pe_Estado=?, Pe_Producto=?, Pe_Cantidad=?, Pe_Fechapedido=?, Pe_Fechaentrega=?, pe_color=?, Pe_Observacion=?, nombre_imagen=? WHERE Identificador=?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('sisisssssi', $cliente, $estado, $producto, $cantidad, $fechaPedido, $fechaEntrega, $color, $observaciones, $imagen, $identificador);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $link->close();
}

?>