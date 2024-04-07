<?php 
// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';

// MercadoPago\SDK::setAccessToken('TEST-6196813918475187-062612-3841e0096245caf473519eb7ff6674f0-252204241');
MercadoPago\SDK::setAccessToken('TEST-7756684308165475-071912-f10fa977f33f99dffbc360b0926c9438-1163486988');

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

//CONFIGURACION DE BACK_URL PARA QUE AL FINALIZAR ME REGRESE A LA RUTA ESPECIFICADA
$preference->back_urls = array(
    "success" => "http://localhost:8080/componentes/sdkMercadoPago/pagoexitoso.php",
    "failure" => "http://localhost:8080/componentes/sdkMercadoPago/pagofallido.php",
    "pending" => "http://localhost:8080/componentes/sdkMercadoPago/pagopendiente.php"
);
//Redirecciona en automatico desdepues de ser aprovado
$preference->auto_return = "approved";

$preference->name = "JESUS";
$preference->surname = "TESTWOC5R05W";
$preference->email = "test_user_11948090@testuser.com";
$preference->date_created = "2018-06-02T12:58:41.425-04:00";

$preference->phone = array(
    "area_code" => "",
    "number" => "949 128 866"
  );
  
  $preference->address = array(
    "street_name" => "Cuesta Miguel Armendáriz",
    "street_number" => 1004,
    "zip_code" => "11020"
  );
// Crea un ítem en la preferencia
$datos = array();

for ($i=0; $i < 5; $i++) { 
    $item = new MercadoPago\Item();
    $item->title = 'pantalon';
    $item->quantity = 1;
    $item->unit_price = 75.56;
    $item->currency_id = "MXN";
    $item->description = "Table is made of heavy duty white plastic and is 96 inches wide and 29 inches tall";
    $item->category_id = "otros";
    $datos[] = $item;
}
$preference->items = $datos;
$preference->save();
// echo $preference->id; 
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
                            <!-- Icono del carrito en el botón -->
                            <i class="bi bi-cart-fill"></i> Vaciar 
                        </a>
                    </div>       
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
                    <!-- Subtotal -->
                    <div class="subtotal">
                        Subtotal: <span id="subtotal">$10</span>
                    </div>
                    <!-- Botones de Pago -->
                    <div class="checkoutpro">
                        <label>Selecciona tu método de pago:</label><br>
                        <!-- Botón de PayPal -->
                        <a href="#" class="btn btn-primary btn-paypal btn-block">
                            <i class="bi bi-paypal"></i> Pagar con PayPal
                        </a>
                        <br>
                        <!-- Botón de Mercado Pago -->
                        <a target="_blank" href="<?php echo $preference->init_point; ?>" class="btn btn-success btn-mercado-pago btn-block">
                            <i class="bi bi-shop"></i> Pagar con Mercado Pago
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
