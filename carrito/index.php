<?php
// Realizar la conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$link = mysqli_connect($host, $user, $password);

if (!$link) {
    die("Error al conectarse al servidor: " . mysqli_connect_error());
}

if (!mysqli_select_db($link, $dbname)) {
    die("Error al conectarse a la Base de Datos: " . mysqli_error($link));
}

// Verificar si se ha enviado la solicitud para vaciar el carrito
if (isset($_GET['vaciar']) && $_GET['vaciar'] == 1) {
    // Realizar la consulta para eliminar todos los registros de la tabla 'carrito'
    $sql = "DELETE FROM carrito";
    if (mysqli_query($link, $sql)) {
        // Redirigir al usuario de nuevo a la misma página después de vaciar el carrito
        header("Location: index.php");
        exit; // Terminar el script después de redirigir
    } else {
        // Opcional: mostrar un mensaje de error en caso de fallo en la eliminación
        echo "<p>Error al vaciar el carrito.</p>";
    }
}

// Actualizar la cantidad en la base de datos si se ha enviado una solicitud AJAX
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Consulta preparada para evitar la inyección SQL
    $sql = "UPDATE carrito SET cantidad = ? WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $quantity, $productId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Cantidad actualizada correctamente";
    } else {
        echo "Error al actualizar la cantidad: " . mysqli_error($link);
    }

    // Cerrar la declaración preparada
    mysqli_stmt_close($stmt);
}

// Consulta SQL para obtener los datos del carrito
$sql = "SELECT id,Pe_Cliente, nombre, precio, cantidad FROM carrito";
$resultado = mysqli_query($link, $sql);
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
            background-color: #f8f9fa; /* Color de fondo general */
        }
        .container {
            padding: 30px 0;
        }
        .cuadro-global {
            background-color: #0077cc; /* Color de fondo del cuadro global */
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
            background-color: #e9ecef; /* Color claro para cuadro de productos */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        .cuadro-pago {
            background-color: #dee2e6; /* Color claro para cuadro de pago */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        /* Estilo adicional para el cuadro de pago */
        .cuadro-pago {
            background-color: #ced4da; /* Nuevo color de fondo */
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
        .btn-vaciar-carrito,
        .btn-pagar {
            font-size: 18px;
            width: 150px;
            margin-top: 20px;
        }
        .subtotal {
            font-size: 24px;
            font-weight: bold;
            text-align: right;
            margin-top: 30px;
        }
        .cantidad-container {
            display: flex;
            align-items: center;
        }
        .selector-cantidad {
            width: 50px; /* Ancho ajustado */
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
                <i class="bi bi-cart-fill"></i> Mi Carrito
            </h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="cuadro-productos">
                        <h3 class="titulo">Productos en el Carrito</h3>
                        <div class="text-right mb-3">
                            <a href="index.php?vaciar=1" class="btn btn-danger btn-vaciar-carrito">
                                <i class="bi bi-cart-fill"></i> Vaciar 
                            </a>
                        </div>

                        <!-- Iterar sobre los resultados de la consulta -->
                        <?php
                            if (mysqli_num_rows($resultado) > 0) {
                                while ($fila = mysqli_fetch_assoc($resultado)) {
                        ?>
                                    <!-- Mostrar el producto en el carrito -->
                                    <div class="card">
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                <!-- Aquí puedes mostrar una imagen estática o cualquier otro contenido relacionado con el producto -->
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $fila['nombre']; ?></h5>
                                                    <?php
                                                        // Verificar si la columna 'descripcion' está presente en $fila
                                                        if (isset($fila['descripcion'])) {
                                                    ?>
                                                            <p class="card-text"><?php echo $fila['descripcion']; ?></p>
                                                    <?php
                                                        } else {
                                                            // Si la columna 'descripcion' no está presente, puedes mostrar un mensaje alternativo o dejarlo en blanco
                                                            echo "<p>No hay descripción disponible para este producto.</p>";
                                                        }
                                                    ?>
                                                    <p class="card-text precio-producto">$<?php echo $fila['precio']; ?></p>
                                                    <div class="cantidad-container">
                                                        <!-- Botones para ajustar la cantidad -->
                                                        <button class="btn btn-outline-secondary btn-cantidad" onclick="restarCantidad(<?php echo $fila['id']; ?>)">-</button>
                                                        <input type="text" id="cantidad-<?php echo $fila['id']; ?>" class="form-control text-center selector-cantidad" value="<?php echo $fila['cantidad']; ?>" aria-label="Cantidad">
                                                        <button class="btn btn-outline-secondary btn-cantidad" onclick="sumarCantidad(<?php echo $fila['id']; ?>)">+</button>
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

                            // Cerrar la conexión a la base de datos
                            mysqli_close($link);
                        ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="cuadro-pago">
                        <h2 class="titulo">Resumen y Pago</h2>
                        <!-- Subtotal -->
                        <div class="subtotal">
                            Total a pagar: <span id="total">$0</span>
                        </div>

                        <script>
                            $(document).ready(function() {
                                // Agregar event listener para el cambio en el selector de cantidad
                                $(".selector-cantidad").change(function() {
                                    actualizarTotal();
                                });

                                // Calcular el total inicial al cargar la página
                                actualizarTotal();
                            });

                            function restarCantidad(productId) {
                                var cantidadInput = document.getElementById('cantidad-' + productId);
                                var cantidad = parseInt(cantidadInput.value);
                                if (cantidad > 0) {
                                    cantidad--;
                                    cantidadInput.value = cantidad;
                                    actualizarTotal(); // Llamar a actualizarTotal() después de restar la cantidad
                                    actualizarCantidadEnBD(productId, cantidad);
                                }
                            }

                            function sumarCantidad(productId) {
                                var cantidadInput = document.getElementById('cantidad-' + productId);
                                var cantidad = parseInt(cantidadInput.value);
                                cantidad++;
                                cantidadInput.value = cantidad;
                                actualizarTotal(); // Llamar a actualizarTotal() después de sumar la cantidad
                                actualizarCantidadEnBD(productId, cantidad);
                            }

                            function actualizarCantidadEnBD(productId, cantidad) {
                                // Enviar una solicitud AJAX al servidor para actualizar la cantidad en la base de datos
                                $.ajax({
                                    type: "POST",
                                    url: "actualizar_cantidad.php", // Cambiar por la URL correcta si es necesario
                                    data: { product_id: productId, quantity: cantidad }, // Pasar los parámetros
                                    success: function(response) {
                                        // Manejar la respuesta del servidor si es necesario
                                        console.log(response);
                                    }
                                });
                            }

                            function actualizarTotal() {
                                var precioTotal = 0;
                                $(".card").each(function() {
                                    var precio = parseFloat($(this).find(".precio-producto").text().substring(1));
                                    var cantidad = parseInt($(this).find(".selector-cantidad").val());
                                    precioTotal += precio * cantidad;
                                });
                                $("#total").text("$" + precioTotal.toFixed(2));
                            }
                        </script>

<div class="checkoutpro">
        <label>Selecciona tu método de pago:</label><br>
        <!-- Botón de Stripe -->
        <form action="procesar_pago.php" method="POST">
            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="pk_test_51PCx2gRxUN5OHb78Un4Cxh9oWW7Xnk9nzmWDzPqyrjFbfDQP187to1ujx3eAsRByEIU8hHhMwxvgj2FiVq0rGRJ600hiaE79NV"
                data-amount="PRECIO_TOTAL_EN_CENTAVOS"
                data-name="MUNDO 3D"
                data-description="Descripción del pedido"
                data-image="-/../images/Logo Mundo 3d.png"
                data-locale="auto"
                data-currency="USD">
            </script>
        </form>
        <!-- Mostrar los métodos de pago que acepta Stripe -->
        <br>
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/04/Visa.svg/1200px-Visa.svg.png" alt="Visa" style="width: 50px;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/MasterCard_Logo.svg/1200px-MasterCard_Logo.svg.png" alt="Mastercard" style="width: 50px;">
        <!-- Puedes añadir más imágenes según los métodos de pago que aceptes -->
    </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
