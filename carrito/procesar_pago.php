<?php
session_start(); // Iniciar sesión si no está iniciada

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Manejar el caso en que el usuario no esté autenticado
    // Por ejemplo, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit(); // Finalizar el script para evitar ejecución adicional
}

$cliente_id = $_SESSION['user_id']; // Obtener el ID de usuario de la sesión

require_once ('vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_51PCx2gRxUN5OHb784L4vrVA5ta8V9wpXoHXThlHuiDh0cBAQs2VCdCEiAma1CtUJDz5QzBgBElhyB3fu3fDNg8JO008Tfah9xf');

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

// Verificar si el monto total está definido en $_POST y procesar el pago
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
            $sql_update = "UPDATE carrito SET estado_pago = 'pagado' WHERE estado_pago = 'pendiente' AND Pe_Cliente = ?";
            $stmt = mysqli_prepare($link, $sql_update);
            mysqli_stmt_bind_param($stmt, "i", $cliente_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Obtener la fecha actual para el pedido
            $fechaPedido = date('Y-m-d'); // Fecha de pedido actual

            // Función para calcular la fecha de entrega
            function calcularFechaEntrega($fechaPedido)
            {
                $diasHabiles = 15; // Número de días hábiles para la entrega
                $fechaEntrega = new DateTime($fechaPedido);
                $diasAgregados = 0;

                while ($diasAgregados < $diasHabiles) {
                    $fechaEntrega->add(new DateInterval('P1D')); // Añadir un día
                    // Si el día agregado no es sábado ni domingo, contarlo como hábil
                    if ($fechaEntrega->format('N') < 6) {
                        $diasAgregados++;
                    }
                }

                return $fechaEntrega->format('Y-m-d'); // Formato de fecha 'YYYY-MM-DD'
            }

            // Calcular la fecha de entrega
            $fechaEntrega = calcularFechaEntrega($fechaPedido);

            // Insertar pedido con fecha de entrega calculada
            $sql_transfer = "INSERT INTO pedidos (Pe_Cliente, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Fechapedido, Pe_Fechaentrega)
                            SELECT carrito.Pe_Cliente, 1, productos.Identificador, carrito.cantidad, ?, ?
                            FROM carrito
                            INNER JOIN productos ON carrito.id_producto = productos.Identificador
                            WHERE carrito.estado_pago = 'pagado' AND carrito.Pe_Cliente = ?";
            $stmt = mysqli_prepare($link, $sql_transfer);
            mysqli_stmt_bind_param($stmt, "ssi", $fechaPedido, $fechaEntrega, $cliente_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Obtener el último ID insertado en la tabla pedidos
            $pedido_id = mysqli_insert_id($link);

            // Función para obtener el nombre del cliente
            function obtenerNombreCliente($conexion, $cliente_id)
            {
                $sql = "SELECT Usu_Nombre_completo FROM usuario WHERE Usu_Identificacion = ?";
                $stmt = mysqli_prepare($conexion, $sql);
                mysqli_stmt_bind_param($stmt, "i", $cliente_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $nombre_completo);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
                return $nombre_completo;
            }

            // Función para obtener el número de documento del cliente
            function obtenerNumeroDocumentoCliente($conexion, $cliente_id)
            {
                $sql = "SELECT Usu_Identificacion FROM usuario WHERE Usu_Identificacion = ?";
                $stmt = mysqli_prepare($conexion, $sql);
                mysqli_stmt_bind_param($stmt, "i", $cliente_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $numero_documento);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
                return $numero_documento;
            }

            // Obtener el nombre del cliente y número de documento
            $nombre_cliente = obtenerNombreCliente($link, $cliente_id);
            $numero_documento = obtenerNumeroDocumentoCliente($link, $cliente_id);

            // Insertar datos en la tabla factura
            $numero_factura = uniqid('FACT-'); // Generar un número de factura único
            $fecha = date('Y-m-d');
            $total = $monto / 100; // Convertir de centavos a dólares (o la moneda que uses)
            $estado = 'pagado';

            $sql_factura = "INSERT INTO factura (numero_factura, fecha, pedido_id, total, estado, nombre_cliente, numero_documento)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $sql_factura);
            mysqli_stmt_bind_param($stmt, "ssidsiss", $numero_factura, $fecha, $pedido_id, $total, $estado, $nombre_cliente, $numero_documento);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Vaciar el carrito
            $sql_vaciar = "DELETE FROM carrito WHERE estado_pago = 'pagado' AND Pe_Cliente = ?";
            $stmt = mysqli_prepare($link, $sql_vaciar);
            mysqli_stmt_bind_param($stmt, "i", $cliente_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Aquí puedes enviar un correo electrónico al cliente si lo deseas
        }
    } catch (\Stripe\Exception\CardException $e) {
        // El pago fue rechazado
        echo 'Error al procesar el pago: ' . $e->getError()->message;
    } catch (Exception $e) {
        // Otra excepción
        echo 'Error al procesar el pago: ' . $e->getMessage();
    }
}

mysqli_close($link); // Cerrar conexión a la base de datos al finalizar

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
            setTimeout(function () {
                document.getElementById('modal-exito').style.display = 'none';
                // Redirige a la página del carrito después de cerrar el modal
                window.location.href = '/../MUNDO 3D/USUARIO/Catalogologin.php';
            }, 3000);
        } else {
            // Muestra el modal de rechazo si el pago fue rechazado
            document.getElementById('modal-rechazo').style.display = 'block';
            // Cierra el modal de rechazo después de 10 segundos
            setTimeout(function () {
                document.getElementById('modal-rechazo').style.display = 'none';
                // Redirige a la página del carrito después de cerrar el modal
                window.location.href = '/../MUNDO 3D/USUARIO/Catalogologin.php';
            }, 3000);
        }
    </script>

</body>

</html>