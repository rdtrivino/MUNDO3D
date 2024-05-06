<?php
// Incluir la librería de Stripe
require_once('stripe-php/init.php');

// Configurar la clave secreta de Stripe
\Stripe\Stripe::setApiKey('sk_test_51PCx2gRxUN5OHb784L4vrVA5ta8V9wpXoHXThlHuiDh0cBAQs2VCdCEiAma1CtUJDz5QzBgBElhyB3fu3fDNg8JO008Tfah9xf');

// Obtener los detalles del pago desde la solicitud
$token = $_POST['stripeToken'];
$monto = $_POST['monto']; // Asegúrate de pasar el monto en centavos

try {
    // Crear una transacción de pago con Stripe
    $charge = \Stripe\Charge::create([
        'amount' => $monto,
        'currency' => 'USD',
        'description' => 'Compra en tu tienda',
        'source' => $token,
    ]);

    // Aquí puedes agregar más lógica, como actualizar la base de datos con el pedido, enviar confirmaciones por correo electrónico, etc.

    // Redirigir a una página de confirmación de pago exitoso
    header('Location: pago_exitoso.php');
    exit();
} catch (Exception $e) {
    // Manejar cualquier error que ocurra durante el proceso de pago
    echo "Error: " . $e->getMessage();
    // Redirigir a una página de error de pago
    header('Location: error_pago.php');
    exit();
}
?>
