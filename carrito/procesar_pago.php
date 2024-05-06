<?php
require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_51PCx2gRxUN5OHb784L4vrVA5ta8V9wpXoHXThlHuiDh0cBAQs2VCdCEiAma1CtUJDz5QzBgBElhyB3fu3fDNg8JO008Tfah9xf');

// Definir una variable para indicar si el pago fue exitoso o rechazado
$pagoExitoso = false;

// Verificar si la clave 'monto' está definida en $_POST
if (isset($_POST['monto'])) {
    $monto = $_POST['monto'];

    try {
        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create([
            'amount' => $monto,
            'currency' => 'USD',
            'description' => 'Compra en tu tienda',
            'source' => $token,
        ]);

        // Marcar el pago como exitoso si no se lanzó ninguna excepción
        $pagoExitoso = true;
    } catch (\Stripe\Exception\CardException $e) {
        // El pago fue rechazado, no es necesario hacer nada ya que la variable $pagoExitoso ya es false
    } catch (Exception $e) {
        // El pago falló por otro motivo, no es necesario hacer nada ya que la variable $pagoExitoso ya es false
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <title>pagos</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        /* Estilos para el modal */
        #modal-exito,
        #modal-rechazo {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 9999;
        }
        #modal-exito h2 {
            color: green;
        }
        #modal-rechazo h2 {
            color: red;
        }
    </style>
</head>
<body>
    <!-- Contenido de tu formulario de pago aquí -->

    <!-- Modal de éxito -->
    <div id="modal-exito">
        <h2>Pago Exitoso</h2>
        <p>Tu pago ha sido  un éxito.</p>
    </div>

    <!-- Modal de rechazo -->
    <div id="modal-rechazo">
        <h2>Pago Rechazado</h2>
        <p>Lo sentimos, tu pago ha sido rechazado.</p>
    </div>

    <script>
    // Verifica si el pago fue exitoso y muestra el modal correspondiente
    if (<?php echo $pagoExitoso ? 'true' : 'false'; ?>) {
        // Muestra el modal de éxito
        document.getElementById('modal-exito').style.display = 'block';
        // Cierra el modal de éxito después de 4 segundos
        setTimeout(function() {
            document.getElementById('modal-exito').style.display = 'none';
            // Redirige a la página del carrito después de cerrar el modal
            window.location.href = 'index.php';
        }, 3000);
    } else {
        // Muestra el modal de rechazo si el pago fue rechazado
        document.getElementById('modal-rechazo').style.display = 'block';
        // Cierra el modal de rechazo después de 4 segundos
        setTimeout(function() {
            document.getElementById('modal-rechazo').style.display = 'none';
            // Redirige a la página del carrito después de cerrar el modal
            window.location.href = 'index.php';
        }, 3000);
    }
</script>

</body>
</html>
