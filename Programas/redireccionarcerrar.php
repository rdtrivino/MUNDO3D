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
        body,
        .loader-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .loader {
            width: 200px;
            height: 200px;
            position: relative;
        }

        .loader:before {
            content: "";
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 6px solid #007bff;
            position: absolute;
            top: 0;
            left: 0;
            animation: pulse 1s ease-in-out infinite;
        }

        .loader:after {
            content: "";
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 6px solid transparent;
            border-top-color: #007bff;
            position: absolute;
            top: 0;
            left: 0;
            animation: spin 2s linear infinite;
        }

        .loader-text {
            font-size: 24px;
            margin-top: 20px;
            color: #007bff;
            font-family: Arial, sans-serif;
            text-align: center;
            text-transform: uppercase;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.6);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0;
            }

            100% {
                transform: scale(0.6);
                opacity: 1;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .content {
            display: none;
        }

        .loaded .loader-container {
            display: none;
        }

        .loaded .content {
            display: block;
        }
    </style>
</head>

<body>
    <div class="loader-container">
        <div class="loader"></div>
        <div class="loader-text">Cerrando...</div>
    </div>
    <script>
        // Redirecciona al usuario después de 5 segundos
        setTimeout(function () {
            window.location.href = "../index.html";
        }, 900); // 5000 milisegundos = 5 segundos
    </script>

</body>

</html>
