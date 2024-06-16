<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <title>Redireccionando...</title>
    <style>
        .loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            /* Ajusta la altura del loader según el viewport */
        }

        .heading {
            color: black;
            letter-spacing: 0.2em;
            margin-bottom: 1em;
        }

        .loading {
            display: flex;
            width: 10em;
            /* Ajusta el ancho del loader */
            height: 10em;
            /* Ajusta la altura del loader */
            align-items: center;
            justify-content: center;
            font-size: 2em;
            /* Ajusta el tamaño del texto dentro del loader */
        }


        .load {
            width: 23px;
            height: 3px;
            background-color: limegreen;
            animation: 1s move_5011 infinite;
            border-radius: 5px;
            margin: 0.1em;
        }

        .load:nth-child(1) {
            animation-delay: 0.2s;
        }

        .load:nth-child(2) {
            animation-delay: 0.4s;
        }

        .load:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes move_5011 {
            0% {
                width: 0.2em;
            }

            25% {
                width: 0.7em;
            }

            50% {
                width: 1.5em;
            }

            100% {
                width: 0.2em;
            }
        }
    </style>
</head>

<body>
    <div class="loader">
        <p class="heading">Cerrando sesión</p>
        <div class="loading">
            <div class="load"></div>
            <div class="load"></div>
            <div class="load"></div>
            <div class="load"></div>
        </div>
    </div>
    <script>
        // Redirecciona al usuario después de 5 segundos
        setTimeout(function () {
            window.location.href = "../Index.html";
        }, 3000); // 5000 milisegundos = 5 segundos
    </script>

</body>

</html>