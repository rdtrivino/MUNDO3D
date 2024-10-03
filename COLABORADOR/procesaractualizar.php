<?php
session_start();
include __DIR__ . '/../conexion.php';

// Confirmación de que el usuario ha realizado el proceso de autenticación
if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Realizamos la consulta para obtener el rol del usuario
$peticion = "SELECT Usu_rol FROM usuario WHERE Usu_Identificacion = '" . $_SESSION['user_id'] . "'";
$result = mysqli_query($link, $peticion);

// Verificamos si la consulta tuvo éxito
if (!$result) {
    // Manejo de errores de consulta
    // Redirigir a la página de autenticación o mostrar un mensaje de error
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Verificamos si la consulta devolvió exactamente un resultado
if (mysqli_num_rows($result) != 1) {
    // Si la consulta no devuelve un solo resultado, puede ser un problema de base de datos
    // Redirigir a la página de autenticación o mostrar un mensaje de error
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Obtenemos el rol del usuario
$fila = mysqli_fetch_assoc($result);
$rolUsuario = $fila['Usu_rol'];

// Verificar si el rol del usuario es diferente de 2
if ($rolUsuario != 2) {
    // Si el rol no es 2, redirigir a la página de autenticación
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}
// Si llegamos aquí, el usuario está autenticado y tiene el rol 2

// Obtener dato de consulta
$id = $_GET['id'];

// Definir $stmt fuera del bloque condicional
$stmt = null;

// Verificar si se ha enviado el formulario y se ha establecido la tabla adecuada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tabla'])) {
    if ($_POST['tabla'] == 'pedidos') {
        // Establecer parametros para almacenar imagen 
        // Obtener la extensión del archivo
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
            // Obtener la extensión del archivo
            $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $ruta_destino = "../images/imagenes_pedidos/"; // Ruta donde quieres guardar la imagen
            $nombre_imagen = "pedido-" . $id . ".$extension"; // Nombre que deseas para la imagen
            
            // Combinar la ruta de destino con el nombre de la imagen
            $ruta_completa = $ruta_destino . $nombre_imagen;
            
            // Mover la imagen cargada a la ruta específica
            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa)){
                //echo "La imagen se ha guardado correctamente en: " . $ruta_completa;
            } else {
                echo "Error al guardar la imagen.";
            } 
            } else {
                // Si no se ha cargado ninguna imagen nueva, obtener el nombre de imagen existente de la base de datos
                $query = "SELECT nombre_imagen FROM pedidos WHERE Identificador = $id";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_assoc($result);
                $ruta_completa = $row['nombre_imagen'];
            }
        
        // Preparar la consulta
        $peticion = "UPDATE pedidos SET Pe_Cliente=?, Pe_Estado=?, Pe_Producto=?, Pe_Cantidad=?, Pe_Fechapedido=?, Pe_Fechaentrega=?, pe_tipo_impresion=?, pe_color=?, Pe_Observacion=?, nombre_imagen=?, Pe_Usuario=?  WHERE Identificador=$id";
        $stmt = mysqli_prepare($link, $peticion);

        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssssssssss", $_POST['cliente_select'], $_POST['estado_select'], $_POST['producto_select'] , $_POST['cantidad'], $_POST['fechapedido'], $_POST['fechaentrega'], $_POST['tipo'], $_POST['color'], $_POST['observacion'], $ruta_completa, $_SESSION['user_id']);
        
        // Ejecutar la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "Registro actualizado con éxito.";
        } else {
            $mensaje = "Error al actualizar el registro: " . mysqli_error($link);
        }
        
        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt);

    } elseif ($_POST['tabla'] == 'productos') {
        // Establecer parametros para almacenar imagen 
        // Obtener la extensión del archivo
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
            // Obtener la extensión del archivo
            $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $ruta_destino = "../images/imagenes_catalogo/"; // Ruta donde quieres guardar la imagen
            $nombre_imagen = "catalogo-" . $id . ".$extension"; // Nombre que deseas para la imagen
            
            // Combinar la ruta de destino con el nombre de la imagen
            $ruta_completa = $ruta_destino . $nombre_imagen;
            
            // Mover la imagen cargada a la ruta específica
            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa)){
                //echo "La imagen se ha guardado correctamente en: " . $ruta_completa;
            } else {
                echo "Error al guardar la imagen.";
            } 
            } else {
                // Si no se ha cargado ninguna imagen nueva, obtener el nombre de imagen existente de la base de datos
                $query = "SELECT nombre_imagen FROM productos WHERE Identificador = $id";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_assoc($result);
                $ruta_completa = $row['nombre_imagen'];
            }
        
        // Preparar la consulta
        $peticion = "UPDATE productos SET Pro_Nombre=?, Pro_Descripcion=?, Pro_Categoria=?, Pro_Cantidad=?, Pro_PrecioVenta=?, Pro_Costo=?, Pro_Estado=?, nombre_imagen=?, Pro_Usuario=? WHERE Identificador= $id";
        $stmt = mysqli_prepare($link, $peticion);
        
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssssssss", $_POST['nombre'], $_POST['descripcion'], $_POST['categoria_select'] , $_POST['cantidad'], $_POST['precioventa'], $_POST['costo'], $_POST['estado'], $ruta_completa, $_SESSION['user_id']);
        
        // Ejecutar la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "Registro actualizado con éxito.";
        } else {
            $mensaje = "Error al actualizar el registro: " . mysqli_error($link);
        }
        
        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt);
    }
}
//Inicia modal
?>
<!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Programas/css/modal.css">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    </head>
    <body>
    <!--Ventana Modal-->
    <input type="checkbox" id="btn-modal" checked>
    <div class="container-modal">
    <div class="content-modal">
        <h2>¡Alerta!</h2>
        <p><?= $mensaje ?></p>
        <div class="btn-cerrar">
            <label for="btn-modal" id="cerrar-modal">Cerrar</label>
        </div>
    </div>
    <label for="btn-modal" class="cerrar-modal"></label>
    </div>
    <!--Fin de Ventana Modal-->

    <script>
    // Al cargar la página, asegúrate de que el modal esté visible
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('btn-modal').checked = true;
        
        // Agregar evento de clic al botón "Cerrar"
        document.getElementById('cerrar-modal').addEventListener('click', function() {
            window.location.href = 'index.php?tabla=<?= $_GET['tabla'] ?>'; // Redirigir al usuario a la página de inicio
        });
    });
    </script>
    </body>
</html>
