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

    // Verificar si se ha enviado el formulario y se ha establecido la tabla adecuada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tabla'])) {
    if ($_POST['tabla'] == 'pedidos') {
        $peticion = "UPDATE pedidos SET Pe_Cliente=?, Pe_Estado=?, Pe_Producto=?, Pe_Cantidad=?, Pe_Fechapedido=?, Pe_Fechaentrega=?, pe_imagen_pedido=?, pe_tipo_impresion=?, pe_color=?, Pe_Observacion=? WHERE Identificador=$id";

        // Preparar la consulta
        $stmt = mysqli_prepare($link, $peticion);

        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "ssssssssss", $_POST['cliente_select'], $_POST['estado_select'], $_POST['producto_select'], $_POST['cantidad'], $_POST['fechapedido'], $_POST['fechaentrega'], $_POST['imagen'], $_POST['tipo'], $_POST['color'], $_POST['observacion']);

        } elseif ($_POST['tabla'] == 'productos') {
            $peticion = "UPDATE productos SET Pro_Nombre=?, Pro_Descripcion=?, Pro_Categoria=?, Pro_Cantidad=?, Pro_PrecioVenta=?, Pro_Costo=?, imagen_principal=? WHERE Identificador=?";

            // Preparar la consulta
            $stmt = mysqli_prepare($link, $peticion);

            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "ssssssss", $_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['cantidad'], $_POST['precioventa'], $_POST['costo'], $_POST['imagen'], $_POST['identificador']);
        }

        // Ejecutar la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            echo "Registro insertado con éxito.";

            header('Refresh: 2; URL=index.php?tabla=' . $_GET['tabla']);
            exit;
        } else {
            echo "Error al insertar el registro: " . mysqli_error($link);
        }

        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt);
    }
?>
