<?php
session_start(); // Iniciar sesión si no está iniciada

// Verificar si el usuario está autenticado
if (isset($_SESSION['user_id'])) {
    // Obtener el ID de usuario de la sesión
    $Pe_Cliente = $_SESSION['user_id'];
} else {
    // Manejar el caso en que el usuario no esté autenticado
    // Por ejemplo, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit(); // Finalizar el script para evitar ejecución adicional
}

require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_51PCx2gRxUN5OHb784L4vrVA5ta8V9wpXoHXThlHuiDh0cBAQs2VCdCEiAma1CtUJDz5QzBgBElhyB3fu3fDNg8JO008Tfah9xf');

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

// Definir una variable para indicar si el pago fue exitoso o rechazado
$pagoExitoso = false;

// Verificar si el monto total está definido en $_POST
if (isset($_POST['monto']) && isset($_POST['stripeToken'])) {
    $monto = $_POST['monto'];
    $token = $_POST['stripeToken'];

    try {
        $charge = \Stripe\Charge::create([
            'amount' => $monto,
            'currency' => 'USD',
            'description' => 'Compra en tu tienda',
            'source' => $token,
        ]);

        // Marcar el pago como exitoso si no se lanzó ninguna excepción
        $pagoExitoso = true;

        // Actualizar el estado de pago en la base de datos de "pendiente" a "pagado"
        if ($pagoExitoso) {
            // Realizar la consulta SQL para actualizar el estado de pago
            $sql_update = "UPDATE carrito SET estado_pago = 'pagado' WHERE estado_pago = 'pendiente' AND Pe_Cliente = '$Pe_Cliente'";
            
            // Ejecutar la consulta SQL para actualizar el estado de pago
            if (mysqli_query($link, $sql_update)) {
// Transferir los productos del carrito a la tabla de pedidos cuando el pago sea exitoso
$sql_transfer = "INSERT INTO pedidos (Pe_Cliente, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Fechapedido)
                SELECT carrito.Pe_Cliente, 1, productos.Identificador, carrito.cantidad, NOW()
                FROM carrito
                INNER JOIN productos ON carrito.id_producto = productos.Identificador
                WHERE carrito.estado_pago = 'pagado' AND carrito.Pe_Cliente = '$Pe_Cliente'";

// Ejecutar la consulta de transferencia
if (mysqli_query($link, $sql_transfer)) {
    // Si la transferencia es exitosa, puedes realizar otras acciones aquí, como vaciar el carrito
    $sql_vaciar = "DELETE FROM carrito WHERE estado_pago = 'pagado' AND Pe_Cliente = '$Pe_Cliente'";
    if (mysqli_query($link, $sql_vaciar)) {
    } else {
        echo "Error al vaciar el carrito: " . mysqli_error($link);
    }
} else {
    echo "Error al realizar el pedido: " . mysqli_error($link);
}

            }}
    } catch (\Stripe\Exception\CardException $e) {
        // El pago fue rechazado
        echo 'Error al procesar el pago: ' . $e->getError()->message;
    } catch (Exception $e) {
        // Otra excepción
        echo 'Error al procesar el pago: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <title>Procesar Pago</title>
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

    <!-- Modal de éxito -->
    <div id="modal-exito">
        <h2>Pago Exitoso</h2>
        <p>Tu pago ha sido un éxito.</p>
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
        // Cierra el modal de éxito después de 10 segundos
        setTimeout(function() {
            document.getElementById('modal-exito').style.display = 'none';
            // Redirige a la página del carrito después de cerrar el modal
            window.location.href = 'index.php';
        }, 10000);
    } else {
        // Muestra el modal de rechazo si el pago fue rechazado
        document.getElementById('modal-rechazo').style.display = 'block';
        // Cierra el modal de rechazo después de 10 segundos
        setTimeout(function() {
            document.getElementById('modal-rechazo').style.display = 'none';
            // Redirige a la página del carrito después de cerrar el modal
            window.location.href = 'index.php';
        }, 10000);
    }
</script>

</body>
</html>
