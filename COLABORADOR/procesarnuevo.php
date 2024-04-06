<?php
    session_start();
    include __DIR__ . '/../conexion.php';

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
        header("Location: ../Programas/autenticacion.php");
        exit; // Es importante salir del script después de redireccionar
    }

    // Verificar si se ha enviado el formulario y se ha establecido la tabla adecuada
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tabla'])) {
        if ($_POST['tabla'] == 'pedidos') {
            $peticion = "INSERT INTO pedidos (Identificador, Pe_Cliente, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Fechapedido, Pe_Fechaentrega, pe_imagen_pedido, pe_tipo_impresion, pe_color, Pe_Observacion) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Preparar la consulta
            $stmt = mysqli_prepare($link, $peticion);

            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "sssssssssss", $_POST['identificador'], $_POST['cliente'], $_POST['estado'], $_POST['producto'], $_POST['cantidad'], $_POST['fechapedido'], $_POST['fechaentrega'], $_POST['imagenproducto'], $_POST['tipoimpresion'], $_POST['color'], $_POST['observacion']);

        } elseif ($_POST['tabla'] == 'productos') {
            $peticion = "INSERT INTO productos (Pro_Nombre, Pro_Descripcion, Pro_Categoria, Pro_Cantidad, Pro_PrecioVenta, Pro_Costo, imagen_principal) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

            // Preparar la consulta
            $stmt = mysqli_prepare($link, $peticion);

            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "sssssss", $_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['cantidad'], $_POST['precioventa'], $_POST['costo'], $_POST['imagen']);
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
