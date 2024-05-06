<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51PCx2gRxUN5OHb784L4vrVA5ta8V9wpXoHXThlHuiDh0cBAQs2VCdCEiAma1CtUJDz5QzBgBElhyB3fu3fDNg8JO008Tfah9xf');

$paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => 1000,
    'currency' => 'usd',
    'payment_method_types' => ['card'],
]);

echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <button id="checkout-button">Pagar</button>

    <script>
        var stripe = Stripe('pk_test_51PCx2gRxUN5OHb78Un4Cxh9oWW7Xnk9nzmWDzPqyrjFbfDQP187to1ujx3eAsRByEIU8hHhMwxvgj2FiVq0rGRJ600hiaE79NV');
        var checkoutButton = document.getElementById('checkout-button');

        checkoutButton.addEventListener('click', function() {
            fetch('/crear-pago.php', {
                method: 'POST',
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Hubo un problema al solicitar el cliente secreto.');
                }
                return response.json();
            })
            .then(function(data) {
                return stripe.confirmCardPayment(data.clientSecret, {
                    payment_method: {
                        card: card,
                    }
                });
            })
            .then(function(result) {
                if (result.error) {
                    console.error(result.error.message);
                } else {
                    console.log(result.paymentIntent);
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
