<?php
session_start();
require dirname(__DIR__) . './../conexion.php';

// Confirmación de que el usuario ha realizado el proceso de autenticación
if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}
$_SESSION['carrito'] = array(); // o $_SESSION['carrito'] = []; en PHP >= 5.4

// Realizamos la consulta para obtener el rol del usuario
$peticion = "SELECT Usu_rol FROM usuario WHERE Usu_Identificacion = '" . $_SESSION['user_id'] . "'";
$result = mysqli_query($link, $peticion);

// Verificamos si la consulta tuvo éxito
if (!$result) {
    // Manejo de errores de consulta
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Verificamos si la consulta devolvió exactamente un resultado
if (mysqli_num_rows($result) != 1) {
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Obtenemos el rol del usuario
$fila = mysqli_fetch_assoc($result);
$rolUsuario = $fila['Usu_rol'];

// Verificar si el rol del usuario es diferente de 3
if ($rolUsuario != 3) {
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Si llegamos aquí, el usuario está autenticado y tiene el rol 3
$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'vaciar_carrito') {
            $sql = "DELETE FROM carrito WHERE Pe_Cliente = '$usuario_id'";
            if (mysqli_query($link, $sql)) {
                echo "Carrito vaciado exitosamente.";
            } else {
                echo "Error al vaciar el carrito: " . mysqli_error($link);
            }
            exit();
        } elseif ($_POST['action'] == 'actualizar_cantidad') {
            $id = $_POST['id'];
            $action_type = $_POST['action_type'];

            // Obtener la cantidad actual del producto en el carrito
            $sql = "SELECT cantidad FROM carrito WHERE id = '$id'";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            $cantidad = $row['cantidad'];

            if ($action_type == 'increment') {
                $cantidad++;
            } elseif ($action_type == 'decrement' && $cantidad > 1) {
                $cantidad--;
            }

            $sql = "UPDATE carrito SET cantidad = '$cantidad' WHERE id = '$id'";
            if (mysqli_query($link, $sql)) {
                echo "Cantidad actualizada.";
            } else {
                echo "Error al actualizar la cantidad: " . mysqli_error($link);
            }
            exit();
        } elseif ($_POST['action'] == 'eliminar_producto') {
            $id = $_POST['id'];

            $sql = "DELETE FROM carrito WHERE id = '$id'";
            if (mysqli_query($link, $sql)) {
                echo "Producto eliminado.";
            } else {
                echo "Error al eliminar el producto: " . mysqli_error($link);
            }
            exit();
        }
    }

    if (isset($_POST['producto'])) {
        $producto = json_decode($_POST['producto'], true);
        if ($producto) {
            $cantidad = 1;
            $Identificador = $producto['Identificador'];

            $sql_check = "SELECT cantidad FROM carrito WHERE Pe_Cliente = '$usuario_id' AND id_producto = '$Identificador' AND estado_pago = 'pendiente'";
            $result_check = mysqli_query($link, $sql_check);

            if (mysqli_num_rows($result_check) > 0) {
                $row = mysqli_fetch_assoc($result_check);
                $nueva_cantidad = $row['cantidad'] + $cantidad;

                $sql_update = "UPDATE carrito SET cantidad = $nueva_cantidad WHERE Pe_Cliente = '$usuario_id' AND id_producto = '$Identificador'";
                mysqli_query($link, $sql_update);

                echo "Cantidad del producto actualizada correctamente en el carrito.";
            } else {
                $sql_insert = "INSERT INTO carrito (Pe_Cliente, cantidad, id_producto, estado_pago) 
                               VALUES ('$usuario_id', $cantidad, '$Identificador', 'pendiente')";

                mysqli_query($link, $sql_insert);

                echo "Producto agregado al carrito correctamente.";
            }

            exit();
        } else {
            echo "No se recibieron datos del producto.";
        }
    } else {
        echo "Acción no válida.";
    }

    exit();
}

?>