<?php
session_start();
require '../conexion.php';

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

// Verificar si el rol del usuario es diferente de 3
if ($rolUsuario != 3) {
    // Si el rol no es 3, redirigir a la página de autenticación
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Si llegamos aquí, el usuario está autenticado y tiene el rol 3

// Continuar con el resto del código
$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

// Consulta a la base de datos para obtener productos de la categoría 2
$sql = "SELECT * FROM productos WHERE Pro_Categoria = 2";
$impresoras = mysqli_query($link, $sql);

// Manejar la solicitud AJAX en el mismo archivo PHP
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el producto
    if (isset($_POST['producto'])) {
        // Obtener el ID del usuario de la sesión
        if (isset($_SESSION['user_id'])) {
            $usuario_id = $_SESSION['user_id'];

            // Convertir los datos del producto JSON en un array asociativo
            $producto = json_decode($_POST['producto'], true);

            // Definir la cantidad predeterminada (en este caso, 1)
            $cantidad = 1;

            // Obtener el identificador del producto
            $Identificador = $producto['Identificador'];

            // Verificar si el producto ya existe en el carrito del usuario
            $sql_check = "SELECT cantidad FROM carrito WHERE Pe_Cliente = '$usuario_id' AND id_producto = '$Identificador' AND estado_pago = 'pendiente'";
            $result_check = mysqli_query($link, $sql_check);

            if (mysqli_num_rows($result_check) > 0) {
                // Si el producto ya existe, actualizar la cantidad
                $row = mysqli_fetch_assoc($result_check);
                $nueva_cantidad = $row['cantidad'] + $cantidad;

                $sql_update = "UPDATE carrito SET cantidad = $nueva_cantidad WHERE Pe_Cliente = '$usuario_id' AND id_producto = '$Identificador'";
                mysqli_query($link, $sql_update);

                echo "Cantidad del producto actualizada correctamente en el carrito.";
            } else {
                // Si el producto no existe, insertar un nuevo registro
                $sql_insert = "INSERT INTO carrito (Pe_Cliente, cantidad, id_producto, estado_pago) 
                               VALUES ('$usuario_id', $cantidad, '$Identificador', 'pendiente')";

                mysqli_query($link, $sql_insert);

                echo "Producto agregado al carrito correctamente.";
            }

            // Finalizar la ejecución del script para evitar la renderización adicional de HTML
            exit();
        } else {
            // Si no hay un usuario logueado, mostrar un mensaje de error
            echo "No hay un usuario logueado.";
        }
    } else {
        // Si no se recibió el producto, mostrar un mensaje de error
        echo "No se recibieron datos del producto.";
    }

    // Finalizar la ejecución del script para evitar la renderización adicional de HTML
    exit();
}
?>