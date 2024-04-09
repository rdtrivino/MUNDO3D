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

// Consulta SQL para obtener los datos del carrito
$sql = "SELECT id, nombre, descripcion, precio, cantidad, imagen_principal FROM carrito";
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
<body>
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
            // Convertir la imagen binaria a una URL de imagen
            $imageData = base64_encode($fila['imagen_principal']);
            $imageSrc = 'data:image/jpeg;base64,' . $imageData;
    ?>
            <!-- Mostrar el producto en el carrito -->
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?php echo $imageSrc; ?>" class="card-img" alt="<?php echo $fila['nombre']; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $fila['nombre']; ?></h5>
                            <p class="card-text"><?php echo $fila['descripcion']; ?></p>
                            <p class="card-text precio-producto">$<?php echo $fila['precio']; ?></p>
                            <div class="cantidad-container">
                                <!-- Botones para ajustar la cantidad -->
                                <button class="btn btn-outline-secondary btn-cantidad" onclick="restarCantidad()">-</button>
                                <input type="text" class="form-control text-center selector-cantidad" value="<?php echo $fila['cantidad']; ?>" aria-label="Cantidad">
                                <button class="btn btn-outline-secondary btn-cantidad" onclick="sumarCantidad()">+</button>
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
                            Subtotal: <span id="subtotal">$0</span>
                        </div>
                        <!-- Botones de Pago -->
                        <div class="checkoutpro">
                            <label>Selecciona tu método de pago:</label><br>
                            <!-- Botón de PayPal -->
                            <a href="#" class="btn btn-primary btn-paypal btn-block">
                                <i class="bi bi-paypal"></i> Pagar con PayPal
                            </a>
                        </div>
                        <!-- Textarea para depuración (opcional) -->
                        <div class="checkoutpro">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Agregar event listener para el cambio en el selector de cantidad
            $(".selector-cantidad").change(function() {
                actualizarSubtotal();
            });
        });

        function restarCantidad() {
            var cantidad = parseInt(document.querySelector('.selector-cantidad').value);
            if (cantidad > 1) {
                cantidad--;
                document.querySelector('.selector-cantidad').value = cantidad;
                actualizarSubtotal();
            }
        }

        function sumarCantidad() {
            var cantidad = parseInt(document.querySelector('.selector-cantidad').value);
            cantidad++;
            document.querySelector('.selector-cantidad').value = cantidad;
            actualizarSubtotal();
        }

        function actualizarSubtotal() {
            var precioProducto = parseFloat($(".precio-producto").text().substring(1));
            var cantidad = parseInt($(".selector-cantidad").val());
            var subtotal = precioProducto * cantidad;
            $("#subtotal").text("$" + subtotal.toFixed(2));
        }
    </script>
</body>
</html>
