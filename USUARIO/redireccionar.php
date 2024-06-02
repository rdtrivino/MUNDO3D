<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
  <title>Redireccionando...</title>
  <style>
.virtual-card,
.physical-card,
.tokenized-card {
  margin: 0 50px;
}

.plus {
  animation: plus 2s cubic-bezier(0.34, 1.56, 0.64, 1) infinite;
}

.plus-one {
  animation: plus 2.5s cubic-bezier(0.34, 1.56, 0.64, 1) infinite;
}

.plus-two {
  animation: plus 3s cubic-bezier(0.34, 1.56, 0.64, 1) infinite;
}

.plus-three {
  animation: plus 3.5s cubic-bezier(0.34, 1.56, 0.64, 1) infinite;
}

.plus-four {
  animation: plus 4s cubic-bezier(0.34, 1.56, 0.64, 1) infinite;
}

.plus-five {
  animation: plus 4.5s cubic-bezier(0.34, 1.56, 0.64, 1) infinite;
}

@keyframes plus {
  0% {
    opacity: 1;
  }

  50% {
    opacity: 0;
  }

  100% {
    opacity: 1;
  }
}
.virtual-card {
            margin: 0 auto; /* Centrar horizontalmente */
            width: 80%; /* Ancho del elemento */
            max-width: 500px; /* Ancho máximo del elemento */
        }

        .virtual-card svg {
            width: 100%; /* Ajustar el tamaño del SVG al contenedor */
            height: auto; /* Mantener la proporción de aspecto */
        }
  </style>
  <script>
    setTimeout(function () {
      window.location.href = '../carrito'; // Reemplaza '../carrito' con la URL a la que deseas redireccionar
    }, 3000); // Cambia 5000 a la cantidad de tiempo en milisegundos que deseas esperar antes de redireccionar (en este caso, 5 segundos)
  </script>
</head>

<body style="background-color: #D3D3D3;">
<div class="virtual-card">
  <svg
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 111 84"
    height="84"
    width="111"
  >
    <rect
      stroke-dasharray="4 4"
      stroke-width="2"
      stroke="black"
      fill="white"
      transform="matrix(-1.31134e-07 1 1 1.31134e-07 -1.31134e-07 40.7759)"
      rx="3.40064"
      height="65.6552"
      width="41.2241"
      y="1"
      x="1"
    ></rect>
    <rect
      fill="black"
      transform="rotate(-180 65.7758 58.6293)"
      height="10.3362"
      width="63.8966"
      y="58.6293"
      x="65.7758"
    ></rect>
    <path
      class="plus-one"
      stroke-width="2"
      stroke="black"
      d="M70.8334 15L70.8334 19.6954M70.8334 19.6954H66.1379M70.8334 19.6954H75.5288M70.8334 19.6954V24.3909"
    ></path>
    <path
      class="plus-two"
      stroke-width="2"
      stroke="black"
      d="M93.955 39L93.955 45.8171M93.955 45.8171H87.1379M93.955 45.8171H100.772M93.955 45.8171V52.6341"
    ></path>
    <path
      class="plus-three"
      stroke-width="2"
      stroke="black"
      d="M99.9622 0L99.9622 10.8242M99.9622 10.8242H89.1379M99.9622 10.8242H110.786M99.9622 10.8242V21.6484"
    ></path>
    <path
      class="plus-four"
      stroke-width="2"
      stroke="black"
      d="M87.4913 22L87.4913 26.3535M87.4913 26.3535H83.1379M87.4913 26.3535H91.8448M87.4913 26.3535V30.7069"
    ></path>
    <path
      class="plus-five"
      stroke-width="2"
      stroke="black"
      d="M77.8447 1V3.70685M77.8447 3.70685H75.1379M77.8447 3.70685H80.5516M77.8447 3.70685V6.4137"
    ></path>
    <path
      class="plus"
      stroke-width="2"
      stroke="black"
      d="M76.8447 40V42.7068M76.8447 42.7068H74.1379M76.8447 42.7068H79.5516M76.8447 42.7068V45.4137"
    ></path>
  </svg>
</div>

</body>

</html>