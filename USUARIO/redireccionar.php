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
      width: fit-content;
      font-weight: bold;
      font-family: monospace;
      font-size: 30px;
      background: radial-gradient(circle closest-side, #000 94%, #0000) right/calc(200% - 1em) 100%;
      animation: l24 1s infinite alternate linear;
    }

    .loader::before {
      content: "Cargando...";
      line-height: 1em;
      color: #0000;
      background: inherit;
      background-image: radial-gradient(circle closest-side, #fff 94%, #000);
      -webkit-background-clip: text;
      background-clip: text;
    }

    @keyframes l24 {
      100% {
        background-position: left
      }
    }

    .loader {
      margin: 45%;
      /* Centrar horizontalmente */
      width: 80%;
      /* Ancho del elemento */
      max-width: 400px;
      /* Ancho máximo del elemento */
      margin-top: 20%;
    }

    .loader {
      width: 100%;
      /* Ajustar el tamaño del SVG al contenedor */
      height: auto;
      /* Mantener la proporción de aspecto */
    }
  </style>
  <script>
    setTimeout(function () {
      window.location.href = '../carrito'; // Reemplaza '../carrito' con la URL a la que deseas redireccionar
    }, 3000); // Cambia 5000 a la cantidad de tiempo en milisegundos que deseas esperar antes de redireccionar (en este caso, 5 segundos)
  </script>
</head>

<body style="background-color: #D3D3D3;">
  <div class="loader"></div>

</body>

</html>