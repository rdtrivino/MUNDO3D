<?php
// Determina la URL de destino basada en el parámetro 'page'
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'impresoras':
            $redirectUrl = '../USUARIO/Catalogologin.php';
            break;
        case 'servicioimpresion':
            $redirectUrl = '../USUARIO/serviciodeimpresion.php';
            break;
        case 'repuestos':
            $redirectUrl = '../USUARIO/Repuestoslogin.php';
            break;
        case 'archivos3d':
            $redirectUrl = '../USUARIO/Archivos3dlogin.php';
            break;
        case 'configuracion':
            $redirectUrl = '../USUARIO/confi.php';
            break;
        case 'pedidos':
            $redirectUrl = '../USUARIO/pedidos.php';
            break;
        default:
            $redirectUrl = '../USUARIO/Catalogologin.php'; // Redirige al Index por defecto
            break;
    }
} else {
    $redirectUrl = '../USUARIO/Catalogologin.php'; // Redirige al Index si no se proporciona ningún parámetro
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <title>Redireccionando...</title>
    <style>
        /* Estilos para centrar el contenedor */
        .loader {
            display: flex;
            flex-direction: column;
            /* Para alinear el icono y el texto verticalmente */
            align-items: center;
            justify-content: center;
            height: 100vh;
            /* Ocupa toda la altura del viewport */
        }

        .icon {
            height: 7rem;
            /* Aumenta el tamaño del icono */
            width: 7rem;
            /* Aumenta el tamaño del icono */
            animation: spin 1s linear infinite;
            stroke: rgba(107, 114, 128, 1);
        }

        .loading-text {
            font-size: 5rem;
            /* Aumenta el tamaño del texto */
            line-height: 2.5rem;
            font-weight: 500;
            color: rgba(107, 114, 128, 1);
            margin-top: 1rem;
            /* Añade un margen superior para separar el texto del icono */
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body style="background: linear-gradient(to bottom right, #dddddd, #dddddd);">
    <div aria-label="Loading..." role="status" class="loader">
        <svg class="icon" viewBox="0 0 256 256">
            <line x1="128" y1="32" x2="128" y2="64" stroke-linecap="round" stroke-linejoin="round" stroke-width="24">
            </line>
            <line x1="195.9" y1="60.1" x2="173.3" y2="82.7" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="24"></line>
            <line x1="224" y1="128" x2="192" y2="128" stroke-linecap="round" stroke-linejoin="round" stroke-width="24">
            </line>
            <line x1="195.9" y1="195.9" x2="173.3" y2="173.3" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="24"></line>
            <line x1="128" y1="224" x2="128" y2="192" stroke-linecap="round" stroke-linejoin="round" stroke-width="24">
            </line>
            <line x1="60.1" y1="195.9" x2="82.7" y2="173.3" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="24"></line>
            <line x1="32" y1="128" x2="64" y2="128" stroke-linecap="round" stroke-linejoin="round" stroke-width="24">
            </line>
            <line x1="60.1" y1="60.1" x2="82.7" y2="82.7" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="24"></line>
        </svg>
        <span class="loading-text">Cargando...</span>
    </div>
    <script>
        // Redirecciona al usuario después de 3 segundos
        setTimeout(function () {
            var redirectUrl = "<?php echo $redirectUrl; ?>";
            window.location.href = redirectUrl;
        }, 1000); // Espera 3 segundos antes de redirigir (3000 milisegundos)
    </script>
</body>

</html>