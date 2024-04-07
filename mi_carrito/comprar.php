

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Agrega la librería de Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .cabez {
            background-color: #343a40;
            padding: 10px 0;
            color: #fff;
            text-align: center;
        }
        #footer {
            background-color: #343a40;
            padding: 10px 0;
            color: #fff;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="cabez">
        <div id="header">
            <div id="logo">
                <a class="brand" href="index.php">Carro de compras</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pagar con PayPal</h5>
                        <form name='formTpv' method='post' action='https://www.sandbox.paypal.com/cgi-bin/webscr'>
                            <input name="cmd" type="hidden" value="_cart">
                            <input name="upload" type="hidden" value="1">
                            <input name="business" type="hidden" value="vender@hotmail.com">
                            <!-- Añade aquí los campos de los productos -->
                            <button type="submit" class="btn btn-primary">Pagar con PayPal</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pagar con Stripe</h5>
                        <!-- Botón de pago con Stripe -->
                        <button id="stripe-button" class="btn btn-primary">Pagar con Stripe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">Pie de página</footer>

    <!-- Script para manejar el pago con Stripe -->
    <script>
        var stripe = Stripe('Tu_Llave_Pública_de_Stripe');
        var elements = stripe.elements();

        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };

        var card = elements.create("card", { style: style });
        card.mount("#card-element");

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Enviar el token de pago a tu servidor
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Inserta el token de pago en un campo oculto para enviarlo al servidor
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Enviar el formulario al servidor
            form.submit();
        }
    </script>
</body>
</html>
