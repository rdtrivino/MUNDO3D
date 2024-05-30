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
    html {
      height: 100%;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #222;
      /* Cambia el color de fondo según tus preferencias */
    }

    #container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
      width: 300px;
      /* Ajusta el ancho del contenedor según tu preferencia */
      height: 300px;
      /* Ajusta el alto del contenedor según tu preferencia */
    }

    #ring {
      width: 90px;
      /* Ajusta el ancho del anillo según tu preferencia */
      height: 90px;
      /* Ajusta el alto del anillo según tu preferencia */
      border: 4px solid transparent;
      border-radius: 50%;
      position: absolute;
    }

    #page {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #container {
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    #h3 {
      color: white;
    }

    #ring {
      width: 190px;
      height: 190px;
      border: 1px solid transparent;
      border-radius: 50%;
      position: absolute;
    }

    #ring:nth-child(1) {
      border-bottom: 8px solid rgb(255, 141, 249);
      animation: rotate1 2s linear infinite;
    }

    @keyframes rotate1 {
      from {
        transform: rotateX(50deg) rotateZ(110deg);
      }

      to {
        transform: rotateX(50deg) rotateZ(470deg);
      }
    }

    #ring:nth-child(2) {
      border-bottom: 8px solid rgb(255, 65, 106);
      animation: rotate2 2s linear infinite;
    }

    @keyframes rotate2 {
      from {
        transform: rotateX(20deg) rotateY(50deg) rotateZ(20deg);
      }

      to {
        transform: rotateX(20deg) rotateY(50deg) rotateZ(380deg);
      }
    }

    #ring:nth-child(3) {
      border-bottom: 8px solid rgb(0, 255, 255);
      animation: rotate3 2s linear infinite;
    }

    @keyframes rotate3 {
      from {
        transform: rotateX(40deg) rotateY(130deg) rotateZ(450deg);
      }

      to {
        transform: rotateX(40deg) rotateY(130deg) rotateZ(90deg);
      }
    }

    #ring:nth-child(4) {
      border-bottom: 8px solid rgb(252, 183, 55);
      animation: rotate4 2s linear infinite;
    }

    @keyframes rotate4 {
      from {
        transform: rotateX(70deg) rotateZ(270deg);
      }

      to {
        transform: rotateX(70deg) rotateZ(630deg);
      }
    }
  </style>
  <script>
    setTimeout(function () {
      window.location.href = '../carrito'; // Reemplaza '../carrito' con la URL a la que deseas redireccionar
    }, 3000); // Cambia 5000 a la cantidad de tiempo en milisegundos que deseas esperar antes de redireccionar (en este caso, 5 segundos)
  </script>
</head>

<body>
  <div id="container">
    <div id="ring"></div>
    <div id="ring"></div>
    <div id="ring"></div>
    <div id="ring"></div>
    <div id="h3" style="color: white;">Redireccionando...</div>
  </div>
</body>

</html>