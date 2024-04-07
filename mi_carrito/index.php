<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
<body>

<div class="container">
    <div class="cuadro-global">
        <h2 class="titulo">Mi Carrito</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="cuadro-productos">
                    <h3 class="titulo">Productos en el Carrito</h3>
                    <!-- Producto en el carrito -->
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="ruta/a/la/imagen/ejemplo.jpg" class="card-img" alt="Producto Ejemplo">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Producto Ejemplo</h5>
                                    <p class="card-text">Descripción del Producto Ejemplo.</p>
                                    <p class="card-text precio-producto">$10</p>
                                    <div class="cantidad-container">
                                        <button class="btn btn-outline-secondary btn-cantidad" onclick="restarCantidad()">-</button>
                                        <input type="text" class="form-control text-center selector-cantidad" value="1" aria-label="Cantidad">
                                        <button class="btn btn-outline-secondary btn-cantidad" onclick="sumarCantidad()">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Agregar más productos aquí -->
                </div>
            </div>

            <div class="col-md-6">
                <div class="cuadro-pago">
                    <h2 class="titulo">Resumen y Pago</h2>
                    <!-- Selector de Modo de Pago -->
                    <div class="form-group">
                        <label for="modo-pago">Modo de Pago</label>
                        <select class="form-control" id="modo-pago">
                            <option value="paypal">PayPal</option>
                            <option value="stripe">Stripe</option>
                            <!-- Agrega más opciones de pago aquí -->
                        </select>
                    </div>

                    <!-- Subtotal -->
                    <div class="subtotal">
                        Subtotal: <span id="subtotal">$10</span>
                    </div>

                    <!-- Botón Vaciar Carrito -->
                    <a href="index.php?vaciar=1" class="btn btn-danger btn-vaciar-carrito">Vaciar Carrito</a>

                    <!-- Botón Ir a Pagar -->
                    <a href="comprar.php" class="btn btn-primary btn-pagar">Ir a Pagar</a>
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
