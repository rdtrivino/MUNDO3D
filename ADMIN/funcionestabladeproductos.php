<?php
session_start();
require '../conexion.php';

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

$sql = "SELECT p.Pro_Nombre, p.Identificador, p.Pro_Descripcion, p.Pro_PrecioVenta, c.Cgo_Nombre, p.Pro_Cantidad, p.Pro_Costo, p.Pro_Estado, p.nombre_imagen
        FROM productos p
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


// Verificar si se recibió una solicitud para guardar cambios
if (isset($_POST['guardar_cambios'])) {
    if (isset($_POST['Identificador'])) {
        // Obtener el código del producto a actualizar
        $identificador = $_POST['Identificador'];

        // Obtener los demás datos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoria = $_POST['categoria'];
        $cantidad = $_POST['cantidad'];
        $costo = $_POST['costo'];
        $estado = $_POST['estado']; // Obtener el estado

        // Procesar la imagen (si se ha subido una nueva)
        $imagen_contenido = null;
        // Establecer parametros para almacenar imagen 
        // Obtener la extensión del archivo
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
            // Obtener la extensión del archivo
            $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $ruta_destino = "../images/imagenes_catalogo/"; // Ruta donde quieres guardar la imagen
            $nombre_imagen = "catalogo-" . $identificador . ".$extension"; // Nombre que deseas para la imagen
            
            // Combinar la ruta de destino con el nombre de la imagen
            $imagen_contenido = $ruta_destino . $nombre_imagen;
            
            // Mover la imagen cargada a la ruta específica
            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_contenido)){
                //echo "La imagen se ha guardado correctamente en: " . $ruta_completa;
            } else {
                echo "Error al guardar la imagen.";
            } 
            } else {
                // Si no se ha cargado ninguna imagen nueva, obtener el nombre de imagen existente de la base de datos
                $query = "SELECT nombre_imagen FROM pedidos WHERE Identificador = $identificador";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_assoc($result);
                $imagen_contenido = $row['nombre_imagen'];
            }

        // Consulta para obtener los datos actuales del producto
        $consulta_actualizar = "SELECT Pro_Nombre, Pro_Descripcion, Pro_PrecioVenta, Pro_Categoria, Pro_Cantidad, Pro_Costo, Pro_Estado, nombre_imagen FROM productos WHERE Identificador=?";
        $stmt_actualizar = mysqli_prepare($link, $consulta_actualizar);
        mysqli_stmt_bind_param($stmt_actualizar, "i", $identificador);
        mysqli_stmt_execute($stmt_actualizar);
        mysqli_stmt_store_result($stmt_actualizar);

        // Si el producto existe, se procede a actualizar
        if (mysqli_stmt_num_rows($stmt_actualizar) > 0) {
            mysqli_stmt_bind_result($stmt_actualizar, $nombre_actual, $descripcion_actual, $precio_actual, $categoria_actual, $cantidad_actual, $costo_actual, $estado_actual, $imagen_actual);
            mysqli_stmt_fetch($stmt_actualizar);

            // Verificar y asignar los valores que se mantienen iguales si no se han modificado
            $nombre = empty($nombre) ? $nombre_actual : $nombre;
            $descripcion = empty($descripcion) ? $descripcion_actual : $descripcion;
            $precio = empty($precio) ? $precio_actual : $precio;
            $categoria = empty($categoria) ? $categoria_actual : $categoria;
            $cantidad = empty($cantidad) ? $cantidad_actual : $cantidad;
            $costo = empty($costo) ? $costo_actual : $costo;
            $estado = empty($estado) ? $estado_actual : $estado;
            $imagen_contenido = empty($imagen_contenido) ? $imagen_actual : $imagen_contenido;

            // Actualizar los datos en la base de datos
            $consulta = "UPDATE productos SET Pro_Nombre=?, Pro_Descripcion=?, Pro_PrecioVenta=?, Pro_Categoria=?, Pro_Cantidad=?, Pro_Costo=?, Pro_Estado=?, nombre_imagen=? WHERE Identificador=?";
            $stmt = mysqli_prepare($link, $consulta);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssdsdsssi", $nombre, $descripcion, $precio, $categoria, $cantidad, $costo, $estado, $imagen_contenido, $identificador);
                if (mysqli_stmt_execute($stmt)) {
                    // Si la consulta se ejecutó con éxito, devuelve un mensaje de éxito
                    echo "success";
                    exit; // Termina el script aquí para evitar que se envíe cualquier otro contenido
                } else {
                    // Si hay algún error en la consulta, devuelve un mensaje de error
                    echo "Error al actualizar los datos: " . mysqli_error($link);
                    exit; // Termina el script aquí para evitar que se envíe cualquier otro contenido
                }
            } else {
                // Si hay algún error en la preparación de la consulta, devuelve un mensaje de error
                echo "Error al preparar la consulta: " . mysqli_error($link);
                exit; // Termina el script aquí para evitar que se envíe cualquier otro contenido
            }
        } else {
            // Si el producto no existe, muestra un mensaje de error
            echo "El producto no existe.";
            exit; // Termina el script aquí para evitar que se envíe cualquier otro contenido
        }
    } else {
        // Si no se recibió el código del producto, devuelve un mensaje de error
        echo "No se recibió el código del producto.";
        exit; // Termina el script aquí para evitar que se envíe cualquier otro contenido
    }
}


// Verificar si se recibió una solicitud para agregar un nuevo producto
if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['categoria']) && isset($_POST['cantidad']) && isset($_POST['costo'])) {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];

    // Estado activo por defecto
    $estado = 'activo';

    // Procesar la imagen (si se ha subido una nueva)
    $imagen_contenido = null;
    // Establecer parametros para almacenar imagen 
        // Obtener la extensión del archivo
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
            // Obtener la extensión del archivo
            $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $ruta_destino = "../images/imagenes_catalogo/"; // Ruta donde quieres guardar la imagen
            $nombre_imagen = "catalogo-" . $identificador . ".$extension"; // Nombre que deseas para la imagen
            
            // Combinar la ruta de destino con el nombre de la imagen
            $imagen_contenido = $ruta_destino . $nombre_imagen;
            
            // Mover la imagen cargada a la ruta específica
            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_contenido)){
                //echo "La imagen se ha guardado correctamente en: " . $ruta_completa;
            } else {
                echo "Error al guardar la imagen.";
            } 
        }

    // Obtener el último código de producto
    $ultimoCodigoConsulta = mysqli_query($link, "SELECT MAX(Identificador) AS ultimo_codigo FROM productos");
    $ultimoCodigoFila = mysqli_fetch_assoc($ultimoCodigoConsulta);
    $ultimoCodigo = $ultimoCodigoFila['ultimo_codigo'];
    $nuevoCodigo = $ultimoCodigo + 1;

    // Insertar los datos en la base de datos
    $consulta = "INSERT INTO productos (Identificador, Pro_Nombre, Pro_Descripcion, Pro_PrecioVenta, Pro_Categoria, Pro_Cantidad, Pro_Costo, Pro_Estado, nombre_imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $consulta);
    mysqli_stmt_bind_param($stmt, "dssdsdsss", $nuevoCodigo, $nombre, $descripcion, $precio, $categoria, $cantidad, $costo, $estado, $imagen_contenido);

    if (mysqli_stmt_execute($stmt)) {
        // Si la consulta se ejecutó con éxito, devuelve un mensaje de éxito
        echo "¡Producto guardado con éxito!";
    } else {
        // Si hay algún error en la consulta, devuelve un mensaje de error
        echo "Error al guardar el producto: " . mysqli_error($link);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($link);
}

?>
