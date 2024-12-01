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
if (isset($_SESSION['user_id'])) {
    $usuario_id = $_SESSION['user_id'];
    $sql = "SELECT carrito.*, 
            productos1.Pro_Nombre AS nombre, 
            productos1.Pro_Pvdolar AS precio_venta, 
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            /* Color de fondo general */
        }

        .container {
            padding: 30px 0;
        }

        .cuadro-global {
            background-color: #000000;
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
            color: #ffffff;
        }

        .titulo-2 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            color: #000000;
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

        /* Boton Home */
        .Btn-1 {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 60px;
            height: 60px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: rgb(0, 0, 0);
            margin-top: 10px;
            margin-left: 10px;
        }

        /* plus sign */
        .sign {
            width: 100%;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sign svg {
            width: 17px;
        }

        .sign svg path {
            fill: white;
        }

        /* text */
        .text {
            position: absolute;
            right: -10px;
            /* Ajusta la posición a la derecha, con un margen de 10px */
            opacity: 0;
            /* Cambia la opacidad para hacer visible el texto */
            color: white;
            font-size: 1.2em;
            font-weight: 600;
            transition-duration: .3s;
        }

        /* hover effect on button width */
        .Btn-1:hover {
            width: 125px;
            border-radius: 40px;
            transition-duration: .3s;
        }

        .Btn-1:hover .sign {
            width: 30%;
            transition-duration: .3s;
            padding-left: 20px;
        }

        /* hover effect button's text */
        .Btn-1:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 10px;
        }

        /* button click effect*/
        .Btn-1:active {
            transform: translate(2px, 2px);
        }

        .text-white {
            color: white;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .mr-3 {
            margin-right: 1rem;
        }

        .font-small {
            font-size: 14px;
        }

        .font-medium {
            font-size: 16px;
        }

        .font-large {
            font-size: 20px;
        }

        #buttons-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .font-small,
        .font-medium,
        .font-large {
            background-color: transparent;
            /* Quitar el fondo */
            color: black;
            /* Color de texto blanco */
            font-weight: bold;
            border: none;
            cursor: pointer;
            /* Negrita */
        }
    </style>
</head>
<style>
    body {
        background: linear-gradient(to bottom right, #dddddd, #dddddd);

    }
</style>

<a class="Btn-1" href="../USUARIO/Catalogologin.php">
    <div class="sign">
        <img src="../images/iconizer-bx-home-alt-2.2.svg" alt="Inicio">
    </div>
    <div class="text">INICIO</div>
</a>

<div id="buttons-container" style="display: flex; justify-content: flex-end; align-items: center; margin-right: 10px;">
    <div class="button-box">
        <button class="font-small text-black" onclick="disminuirTamano()">A</button>
    </div>
    <div class="button-box">
        <button class="font-medium text-black" onclick="ajustarTamano('medium')">A</button>
    </div>
    <div class="button-box">
        <button class="font-large text-black" onclick="aumentarTamano()">A</button>
    </div>
    <div class="button-box" style="margin-right: 10px;">
        <i class="fas fa-wheelchair fa-lg text-black"></i>
    </div>
</div>
<div class="container">
    <div class="cuadro-global">
        <h2 class="titulo">
            <!-- Icono del carrito junto al título -->
            <i class="bi bi-cart-fill"></i> Confirmación de compra
        </h2>
        <div class="row">
            <div class="col-md-6">
                <div class="cuadro-productos">
                    <h3 class="titulo-2">Productos</h3>
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

                                            <p class="card-text precio-producto">$ <?php echo $fila['precio_venta']; ?></p>
                                            <div class="cantidad-container">
                                                <!-- Botones para ajustar la cantidad -->
                                                <input type="text" id="cantidad-<?php echo $fila['id']; ?>"
                                                    class="form-control text-center selector-cantidad"
                                                    value="<?php echo $fila['cantidad']; ?>" aria-label="Cantidad">
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
                    <h2 class="titulo-2">Resumen de compra</h2>
                    <?php if ($total_a_pagar > 0) { ?>
                        <!-- Subtotal -->
                        <div class="subtotal">
                            Total a pagar USD: <span
                                id="total">$ <?php echo number_format($total_a_pagar, 2, '.', ','); ?></span>
                        </div>

                        <br>

                        <!-- Otro contenido para métodos de pago -->
                        <div class="checkoutpro">
                            <label>Selecciona tu método de pago:</label><br>
                            <!-- Formulario de Stripe -->
                            <form id="payment-form" action="procesar_pago.php" method="POST">
                                <!-- Campo oculto para enviar el monto en centavos -->
                                <input type="hidden" name="monto" id="monto" value="<?php echo $total_a_pagar * 100; ?>">
                                <!-- Convertir a centavos -->

                                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="pk_test_51PCx2gRxUN5OHb78Un4Cxh9oWW7Xnk9nzmWDzPqyrjFbfDQP187to1ujx3eAsRByEIU8hHhMwxvgj2FiVq0rGRJ600hiaE79NV"
                                    data-amount="<?php echo $total_a_pagar * 100; ?>" <!-- Convertir a centavos -->
                                        data - name="MUNDO 3D" <!-- Cambiar el nombre de tu tienda -->
                                        data - description="Compra en MUNDO 3D" < !--Cambiar la descripción del pedido-- >
                                            data - image="RUTA_DE_LA_IMAGEN_DEL_PRODUCTO" < !--Cambiar la ruta de la imagen del producto-- >
                                                data - locale="auto"
                                        data - currency="COP" > < !--Cambiar la moneda a COP-- >
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
    // Función para disminuir el tamaño de la fuente
    function disminuirTamano() {
        // Obtener el tamaño actual de la fuente, o usar 1rem si no está definido
        var currentFontSize = parseFloat(document.body.style.fontSize) || 1;
        // Reducir el tamaño de la fuente en 1rem
        var newFontSize = currentFontSize - 1 + 'rem';
        document.body.style.fontSize = newFontSize;
    }

    // Función para ajustar el tamaño de la fuente a valores predefinidos
    function ajustarTamano(size) {
        switch (size) {
            case 'small': // Tamaño pequeño
                document.body.style.fontSize = 'small';
                break;
            case 'medium': // Tamaño mediano
                document.body.style.fontSize = 'medium';
                break;
            case 'large': // Tamaño grande
                document.body.style.fontSize = 'large';
                break;
            default: // No hacer nada si no coincide con un caso
                break;
        }
    }

    // Función para aumentar el tamaño de la fuente
    function aumentarTamano() {
        var currentFontSize = parseFloat(document.body.style.fontSize) || 1;
        // Incrementar el tamaño de la fuente en 1rem
        var newFontSize = currentFontSize + 1 + 'rem';
        document.body.style.fontSize = newFontSize;
    }

    // Función para restaurar el tamaño original de la fuente
    function restaurarTamano() {
        if (tamanoOriginal !== '') { // Si hay un tamaño original guardado
            document.body.style.fontSize = tamanoOriginal;
        }
    }

    // Función para cambiar el cursor al estilo de "puntero"
    function cambiarCursor(event) {
        event.target.style.cursor = 'pointer';
    }

    // Función para restaurar el cursor al estilo predeterminado
    function restaurarCursor() {
        document.body.style.cursor = 'default';
    }

    // Variable para almacenar el tamaño original de la fuente
    var tamanoOriginal = '';

    // Guardar el tamaño original de la fuente al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        tamanoOriginal = window.getComputedStyle(document.body).fontSize;
    });

    // Código para manejar eventos relacionados con el DOM una vez que la página esté cargada
    $(document).ready(function () {
        // Agregar listener para detectar cambios en los selectores de cantidad
        $(".selector-cantidad").change(function () {
            actualizarTotal(); // Actualizar el total al cambiar la cantidad
            actualizarCantidadEnBD($(this).data('product-id'), $(this).val()); // Actualizar en la base de datos
        });

        // Calcular el total inicial al cargar la página
        actualizarTotal();
    });

    // Función para disminuir la cantidad de un producto específico
    function restarCantidad(productId) {
        var cantidadInput = $("#cantidad-" + productId); // Seleccionar el input de cantidad
        var cantidad = parseInt(cantidadInput.val()); // Obtener el valor actual
        if (cantidad > 1) { // Evitar que sea menor que 1
            cantidad--;
            cantidadInput.val(cantidad); // Actualizar el input con la nueva cantidad
            actualizarTotal(); // Actualizar el total
            actualizarCantidadEnBD(productId, cantidad); // Actualizar en la base de datos
        }
    }

    // Función para aumentar la cantidad de un producto específico
    function sumarCantidad(productId) {
        var cantidadInput = $("#cantidad-" + productId); // Seleccionar el input de cantidad
        var cantidad = parseInt(cantidadInput.val()); // Obtener el valor actual
        cantidad++;
        cantidadInput.val(cantidad); // Actualizar el input con la nueva cantidad
        actualizarTotal(); // Actualizar el total
        actualizarCantidadEnBD(productId, cantidad); // Actualizar en la base de datos
    }

    // Función para actualizar la cantidad de un producto en la base de datos
    function actualizarCantidadEnBD(productId, cantidad) {
        $.ajax({
            type: "POST", // Método HTTP para la solicitud
            url: "index.php", // URL a donde se enviará la solicitud
            data: { product_id: productId, quantity: cantidad }, // Datos a enviar
            success: function (response) {
                // Manejar la respuesta del servidor si es necesario
                console.log(response);
            }
        });
    }

    // Función para calcular y mostrar el precio total de los productos seleccionados
    function actualizarTotal() {
        var precioTotal = 0; // Variable para almacenar el total
        $(".card").each(function () {
            // Obtener el precio del producto, eliminando el símbolo de moneda
            var precio = parseFloat($(this).find(".precio-producto").text().substring(1));
            var cantidad = parseInt($(this).find(".selector-cantidad").val()); // Obtener la cantidad
            precioTotal += precio * cantidad; // Sumar al total
        });
        $("#total").text("$" + precioTotal.toFixed(2)); // Mostrar el total con formato de moneda
    }
</script>

</body>

</html>