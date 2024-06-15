<?php
session_start();
// Realizar la conexión a la base de datos
include __DIR__ . '/../conexion.php';

// Verificar si el usuario está autenticado
if (isset($_SESSION['user_id'])) {
    $usuario_id = $_SESSION['user_id'];

    // Consulta SQL para obtener los productos del carrito del usuario actualmente autenticado
    $sql = "SELECT * FROM carrito WHERE Pe_Cliente = $usuario_id";
    $resultado = mysqli_query($link, $sql);

}

// Verificar si se ha enviado la solicitud para vaciar el carrito
if (isset($_GET['vaciar']) && $_GET['vaciar'] == 1) {
    // Realizar la consulta para eliminar todos los registros de la tabla 'carrito' asociados al usuario actual
    if (isset($_SESSION['user_id'])) {
        $usuario_id = $_SESSION['user_id'];
        $sql = "DELETE FROM carrito WHERE Pe_Cliente = $usuario_id";
        if (mysqli_query($link, $sql)) {
            // Redirigir al usuario de nuevo a la misma página después de vaciar el carrito
            header("Location: index.php");
            exit; // Terminar el script después de redirigir
        } else {
            // Opcional: mostrar un mensaje de error en caso de fallo en la eliminación
            echo "<p>Error al vaciar el carrito.</p>";
        }
    }
}
if (isset($_SESSION['user_id'])) {
    $usuario_id = $_SESSION['user_id'];
    $sql = "SELECT carrito.*, 
            productos1.Pro_Nombre AS nombre, 
            productos1.Pro_PrecioVenta AS precio_venta, 
            productos1.Pro_Descripcion AS descripcion, 
            productos1.nombre_imagen AS nombre_imagen
        FROM carrito 
        INNER JOIN productos AS productos1 ON carrito.id_producto = productos1.Identificador
        WHERE carrito.Pe_Cliente = '$usuario_id' AND carrito.estado_pago = 'pendiente'";
        $resultado = mysqli_query($link, $sql);


    // Calcular el total a pagar
    $total_a_pagar = 0;
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $total_a_pagar += $fila['precio_venta'] * $fila['cantidad'];
    }
    // Actualizar la cantidad del producto en la base de datos si se ha enviado un formulario para ello
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $producto_id = $_POST['product_id'];
        $cantidad = $_POST['quantity'];

        $sql_update = "UPDATE carrito SET cantidad = $cantidad WHERE Pe_Cliente = $usuario_id AND id = $producto_id";
        if (mysqli_query($link, $sql_update)) {
            echo "La cantidad del producto se ha actualizado correctamente en la base de datos.";
        } else {
            echo "Error al actualizar la cantidad del producto en la base de datos: " . mysqli_error($link);
        }
    }
} else {
    echo "Error: Falta información requerida para actualizar la cantidad del producto.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <!-- Enlace a los archivos de Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            /* Color de fondo general */
        }

        .container {
            padding: 30px 0;
        }

        .cuadro-global {
            background-color: #0077cc;
            /* Color de fondo del cuadro global */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .titulo {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }

        .cuadro-productos {
            background-color: #e9ecef;
            /* Color claro para cuadro de productos */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        .cuadro-pago {
            background-color: #dee2e6;
            /* Color claro para cuadro de pago */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        /* Estilo adicional para el cuadro de pago */
        .cuadro-pago {
            background-color: #ced4da;
            /* Nuevo color de fondo */
        }

        .card {
            background-color: #fff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .subtotal {
        font-size: 24px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: left;
        margin-top: 30px;
    }

        .cantidad-container {
            display: flex;
            align-items: center;
        }

        .selector-cantidad {
            width: 50px;
            /* Ancho ajustado */
            text-align: center;
            margin-right: 10px;
        }

        .btn-cantidad {
            width: 30px;
            padding: 0;
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>
<style>
    body {
        background: linear-gradient(to bottom right, #6ca6cd, #ffb6c1);
    }
</style>
<a href="../USUARIO/Catalogologin.php" class="btn btn-link">
    <i class="bi bi-house-door" style="color: black; font-size: 48px;"></i>
</a>

<div class="container">
    <div class="cuadro-global">
        <h2 class="titulo">
            <!-- Icono del carrito junto al título -->
            <i class="bi bi-cart-fill"></i> Confirmación de compra
        </h2>
        <div class="row">
            <div class="col-md-6">
                <div class="cuadro-productos">
                    <h3 class="titulo">Productos</h3>
                    <div class="text-right mb-3">
                    </div>
                    <!-- Iterar sobre los resultados de la consulta -->
                    <?php
                    if (mysqli_num_rows($resultado) > 0) {
                        mysqli_data_seek($resultado, 0); // Reiniciar el puntero del resultado
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            ?>
                            <!-- Mostrar el producto en el carrito -->
                            <div class="card">
                                <!-- Contenido de la tarjeta -->
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <!-- Aquí puedes mostrar una imagen estática o cualquier otro contenido relacionado con el producto -->
                                        <?php if (isset($fila['nombre_imagen']) && !empty($fila['nombre_imagen'])): ?>
                                            <img src="<?php echo $fila['nombre_imagen']; ?>" class="card-img-top">
                                        <?php else: ?>
                                            <p>Imagen no disponible</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $fila['nombre']; ?></h5>
                                           
                                            <p class="card-text precio-producto">$<?php echo $fila['precio_venta']; ?></p>
                                            <div class="cantidad-container">
                                                <!-- Botones para ajustar la cantidad -->
                                                <button class="btn btn-outline-secondary btn-cantidad"
                                                    onclick="restarCantidad(<?php echo $fila['id']; ?>)">-</button>
                                                <input type="text" id="cantidad-<?php echo $fila['id']; ?>"
                                                    class="form-control text-center selector-cantidad"
                                                    value="<?php echo $fila['cantidad']; ?>" aria-label="Cantidad">
                                                <button class="btn btn-outline-secondary btn-cantidad"
                                                    onclick="sumarCantidad(<?php echo $fila['id']; ?>)">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Si no hay productos en el carrito, mostrar un mensaje indicando que está vacío
                        echo "<p>No hay productos en el carrito.</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="cuadro-pago">
                    <h2 class="titulo">Resumen de compra</h2>
                    <?php if ($total_a_pagar > 0) { ?>
                        <!-- Subtotal -->
                        <div class="subtotal">
                            Total a pagar: <span id="total">$<?php echo number_format($total_a_pagar, 2, '.', ','); ?></span>
                        </div>

                        <br>

                        <!-- Otro contenido para métodos de pago -->
                        <div class="checkoutpro">
                            <label>Selecciona tu método de pago:</label><br>
                            <!-- Botón de Stripe -->
                            <form id="payment-form" action="procesar_pago.php" method="POST">
                                <!-- Campo oculto para enviar el monto -->
                                <input type="hidden" name="monto" id="monto" value="<?php echo $total_a_pagar * 100; ?>">
                                <!-- Convertir a centavos -->

                                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="pk_test_51PCx2gRxUN5OHb78Un4Cxh9oWW7Xnk9nzmWDzPqyrjFbfDQP187to1ujx3eAsRByEIU8hHhMwxvgj2FiVq0rGRJ600hiaE79NV"
                                    data-amount="<?php echo $total_a_pagar * 100; ?>" <!-- Convertir a centavos -->
                                        data - name="MUNDO 3D" <!-- Cambiar el nombre de tu tienda -->
                                        data - description="MUNDO 3D" < !--Cambiar la descripción del pedido-- >
                                            data - image="RUTA_DE_LA_IMAGEN_DEL_PRODUCTO" < !--Cambiar la ruta de la imagen del producto-- >
                                                data - locale="auto"
                                        data - currency="USD" >
                                    </script>
                            </form>
                        </div>

                    <?php } else { ?>
                        <p>No hay productos en el carrito. Por favor, agrega productos para continuar con el pago.</p>
                    <?php } ?>
                    <br>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/04/Visa.svg/1200px-Visa.svg.png"
                        alt="Visa" style="width: 50px;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/MasterCard_Logo.svg/1200px-MasterCard_Logo.svg.png"
                        alt="Mastercard" style="width: 50px;">
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Scripts JavaScript -->
<script>
        $(document).ready(function () {
            // Agregar event listener para el cambio en el selector de cantidad
            $(".selector-cantidad").change(function () {
                actualizarTotal();
                actualizarCantidadEnBD($(this).data('product-id'), $(this).val());
            });

            // Calcular el total inicial al cargar la página
            actualizarTotal();
        });

    function restarCantidad(productId) {
        var cantidadInput = $("#cantidad-" + productId);
        var cantidad = parseInt(cantidadInput.val());
        if (cantidad > 1) {
            cantidad--;
            cantidadInput.val(cantidad);
            actualizarTotal(); // Llamar a actualizarTotal() después de restar la cantidad
            actualizarCantidadEnBD(productId, cantidad);
        }
    }

    function sumarCantidad(productId) {
        var cantidadInput = $("#cantidad-" + productId);
        var cantidad = parseInt(cantidadInput.val());
        cantidad++;
        cantidadInput.val(cantidad);
        actualizarTotal(); // Llamar a actualizarTotal() después de sumar la cantidad
        actualizarCantidadEnBD(productId, cantidad);
    }

    function actualizarCantidadEnBD(productId, cantidad) {
        // Enviar una solicitud AJAX al servidor para actualizar la cantidad en la base de datos
        $.ajax({
            type: "POST",
            url: "index.php", // Cambiar por la URL correcta si es necesario
            data: { product_id: productId, quantity: cantidad }, // Pasar los parámetros
            success: function (response) {
                // Manejar la respuesta del servidor si es necesario
                console.log(response);
            }
        });
    }

    function actualizarTotal() {
        var precioTotal = 0;
        $(".card").each(function () {
            var precio = parseFloat($(this).find(".precio-producto").text().substring(1));
            var cantidad = parseInt($(this).find(".selector-cantidad").val());
            precioTotal += precio * cantidad;
        });
        $("#total").text("$" + precioTotal.toFixed(2));
    }
</script>

</body>

</html>