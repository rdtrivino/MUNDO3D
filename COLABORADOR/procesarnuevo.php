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

            //Obetener el identificador mas alto de la tabla
            include __DIR__ . '/../conexion.php';
            $sql = "SELECT MAX(Identificador) AS max_id FROM pedidos";
            $resultado = mysqli_query($link, $sql);
            // Verificar si se encontraron resultados
            if (mysqli_num_rows($resultado) > 0) {
                // Obtener el resultado como un array asociativo
                $fila = mysqli_fetch_assoc($resultado);
                // Almacenar el valor del identificador más alto en una variable
                $max_id = $fila['max_id'];
            } else {
                $max_id = '1';
            }

            $identificador = $max_id+1;

            //Obtener la extension de la imagen
            if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Obtiene la información del archivo
                $info_archivo = pathinfo($_FILES['imagen']['name']); 
                // Obtiene la extensión del archivo
                $extension = strtolower($info_archivo['extension']);
            }

            // Verificar si se ha subido un archivo y si no hay errores
            if(isset($_FILES['imagen'])){
                $ruta_destino = "../images/imagenes_pedidos/"; // Ruta donde quieres guardar la imagen
                $nombre_imagen = "pedido-" . ($max_id + 1) . ".$extension"; // Nombre que deseas para la imagen
                
                // Combinar la ruta de destino con el nombre de la imagen
                $ruta_completa = $ruta_destino . $nombre_imagen;
                
                // Mover la imagen cargada a la ruta específica
                if(move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa)){
                    echo "La imagen se ha guardado correctamente en: " . $ruta_completa;
                } else {
                    echo "Error al guardar la imagen.";
                }
            }
            //Preparar la consulta
            $peticion = "INSERT INTO pedidos (Identificador, Pe_Cliente, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Fechapedido, Pe_Fechaentrega, pe_tipo_impresion, pe_color, Pe_Observacion, nombre_imagen) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Preparar la consulta
            $stmt = mysqli_prepare($link, $peticion);

            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "sssssssssss", $identificador , $_POST['cliente'], $_POST['estado'], $_POST['producto'], $_POST['cantidad'], $_POST['fechapedido'], $_POST['fechaentrega'], $_POST['tipoimpresion'], $_POST['color'], $_POST['observacion'], $nombre_imagen);
                
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
