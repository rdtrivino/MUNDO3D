<?php
    session_start();
    include __DIR__ . '/../conexion.php';

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
        header("Location: ../Programas/autenticacion.php");
        exit; // Es importante salir del script después de redireccionar
    }

    // Inicializar la variable mensaje
    $mensaje = "";

    // Verificar si se ha enviado el formulario y se ha establecido la tabla adecuada
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tabla'])) {
        if ($_POST['tabla'] == 'pedidos') {
            //var_dump($_POST['color']);
          // Verificar si se ha subido un archivo y si no hay errores
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Obtener el contenido de la imagen
                $imagen_contenido = file_get_contents($_FILES['imagen']['tmp_name']);

            //Preparar la consulta
            $peticion = "INSERT INTO pedidos (Pe_Cliente, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Fechapedido, Pe_Fechaentrega, pe_imagen_pedido, pe_tipo_impresion, pe_color, Pe_Observacion) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Preparar la consulta
            $stmt = mysqli_prepare($link, $peticion);

            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "ssssssssss", $_POST['cliente'], $_POST['estado'], $_POST['producto'], $_POST['cantidad'], $_POST['fechapedido'], $_POST['fechaentrega'], $imagen_contenido, $_POST['tipoimpresion'], $_POST['color'], $_POST['observacion']);
                // Ejecutar la consulta preparada
                if (mysqli_stmt_execute($stmt)) {
                    $mensaje = "Registro insertado con éxito.";
                } else {
                    $mensaje = "Error al insertar el registro: " . mysqli_error($link);
                }
            } else {
                $mensaje = "Error al cargar la imagen.";
            }
        } elseif ($_POST['tabla'] == 'productos') {
            // Verificar si se ha subido un archivo y si no hay errores
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Obtener el contenido de la imagen
                $imagen_contenido = file_get_contents($_FILES['imagen']['tmp_name']);
        
                // Preparar la consulta
                $peticion = "INSERT INTO productos (Pro_Nombre, Pro_Descripcion, Pro_Categoria, Pro_Cantidad, Pro_PrecioVenta, Pro_Costo, imagen_principal, Pro_Estado) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $estado = "inactivo";
                $stmt = mysqli_prepare($link, $peticion);
                
                // Vincular parámetros
                mysqli_stmt_bind_param($stmt, "ssssssss", $_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['cantidad'], $_POST['precioventa'], $_POST['costo'], $imagen_contenido, $estado);
                
                // Ejecutar la consulta preparada
                if (mysqli_stmt_execute($stmt)) {
                    $mensaje = "Registro insertado con éxito.";
                } else {
                    $mensaje = "Error al insertar el registro: " . mysqli_error($link);
                }
            } else {
                $mensaje = "Error al cargar la imagen.";
            }
        }
        
        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt);
    }
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
