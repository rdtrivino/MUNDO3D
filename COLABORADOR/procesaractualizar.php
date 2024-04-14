<?php
session_start();
include __DIR__ . '/../conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
    header("Location: ../Programas/autenticacion.php");
    exit; // Es importante salir del script después de redireccionar
}

//Obtener dato de consulta
$id = $_GET['id'];

// Definir $stmt fuera del bloque condicional
$stmt = null;

// Verificar si se ha enviado el formulario y se ha establecido la tabla adecuada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tabla'])) {
    if ($_POST['tabla'] == 'pedidos') {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Obtener el contenido de la imagen
            $imagen_contenido = file_get_contents($_FILES['imagen']['tmp_name']);
        } else {
            // Obtener el contenido de la imagen principal desde la base de datos
            $query = "SELECT pe_imagen_pedido FROM pedidos WHERE Identificador = $id";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);
            $imagen_contenido = $row['pe_imagen_pedido'];
        }
        
        // Preparar la consulta
        $peticion = "UPDATE pedidos SET Pe_Cliente=?, Pe_Estado=?, Pe_Producto=?, Pe_Cantidad=?, Pe_Fechapedido=?, Pe_Fechaentrega=?, pe_imagen_pedido=?, pe_tipo_impresion=?, pe_color=?, Pe_Observacion=? WHERE Identificador=$id";
        $stmt = mysqli_prepare($link, $peticion);

        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "ssssssssss", $_POST['cliente_select'], $_POST['estado_select'], $_POST['producto_select'] , $_POST['cantidad'], $_POST['fechapedido'], $_POST['fechaentrega'], $imagen_contenido, $_POST['tipo'], $_POST['color'], $_POST['observacion']);
        
        // Ejecutar la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "Registro actualizado con éxito.";
        } else {
            $mensaje = "Error al actualizar el registro: " . mysqli_error($link);
        }
        
        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt);
    }

    } elseif ($_POST['tabla'] == 'productos') {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Obtener el contenido de la imagen
            $imagen_contenido = file_get_contents($_FILES['imagen']['tmp_name']);
        } else {
            // Obtener el contenido de la imagen principal desde la base de datos
            $query = "SELECT imagen_principal FROM productos WHERE Identificador = $id";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);
            $imagen_contenido = $row['imagen_principal'];
        }
        
        // Preparar la consulta
        $peticion = "UPDATE productos SET Pro_Nombre=?, Pro_Descripcion=?, Pro_Categoria=?, Pro_Cantidad=?, Pro_PrecioVenta=?, Pro_Costo=?, imagen_principal=?, Pro_Estado=? WHERE Identificador= $id";
        $stmt = mysqli_prepare($link, $peticion);
        
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "ssssssss", $_POST['nombre'], $_POST['descripcion'], $_POST['categoria_select'] , $_POST['cantidad'], $_POST['precioventa'], $_POST['costo'], $imagen_contenido, $_POST['estado']);
        
        // Ejecutar la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "Registro actualizado con éxito.";
        } else {
            $mensaje = "Error al actualizar el registro: " . mysqli_error($link);
        }
        
        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt);
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
