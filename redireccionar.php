<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="images/Logo Mundo 3d.png" type="image/x-icon">
  <title>Redireccionando...</title>

  <style>
    /* Define estilos para centrar el contenedor en toda la pantalla */
    body,
    .loader-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    /* Estilos para el contenedor principal del loader */
    .loader {
      width: 200px;
      height: 200px;
      position: relative;
    }

    /* Define un círculo animado que se expande y se desvanece */
    .loader:before {
      content: "";
      width: 200px;
      height: 200px;
      border-radius: 50%;
      border: 6px solid #007bff; /* color del borde del círculo */
      position: absolute;
      top: 0;
      left: 0;
      animation: pulse 1s ease-in-out infinite; /* animación de "pulso" infinita */
    }

    /* Define un segundo círculo animado que rota */
    .loader:after {
      content: "";
      width: 200px;
      height: 200px;
      border-radius: 50%;
      border: 6px solid transparent;
      border-top-color: #007bff; /* color del borde superior que creará el efecto de rotación */
      position: absolute;
      top: 0;
      left: 0;
      animation: spin 2s linear infinite; /* animación de "giro" infinita */
    }

    /* Estilos para el texto de carga debajo del loader */
    .loader-text {
      font-size: 24px;
      margin-top: 20px;
      color: #007bff; /* color azul */
      font-family: Arial, sans-serif;
      text-align: center;
      text-transform: uppercase;
    }

    /* Animación de "pulso" para el círculo expansivo */
    @keyframes pulse {
      0% {
        transform: scale(0.6); /* reduce el tamaño inicial */
        opacity: 1;
      }
      50% {
        transform: scale(1.2); /* aumenta el tamaño a su punto máximo */
        opacity: 0; /* se desvanece */
      }
      100% {
        transform: scale(0.6); /* regresa al tamaño inicial */
        opacity: 1;
      }
    }

    /* Animación de "giro" para el círculo rotatorio */
    @keyframes spin {
      0% {
        transform: rotate(0deg); /* comienza sin rotación */
      }
      100% {
        transform: rotate(360deg); /* completa una rotación */
      }
    }

    /* Define estilos para el contenido que se muestra después de cargar */
    .content {
      display: none;
    }

    /* Clase para ocultar el loader y mostrar el contenido después de cargar */
    .loaded .loader-container {
      display: none;
    }
    .loaded .content {
      display: block;
    }

  </style>
</head>

<body>
  <!-- Contenedor del loader y el mensaje de inicio -->
  <div class="loader-container">
    <div class="loader"></div>
    <div class="loader-text"> INICIANDO...</div>
  </div>

  <script>
    // Redirecciona al usuario a otra página después de 900 ms
    setTimeout(function () {
      window.location.href = "Programas/Roleslogin.php"; // URL de redireccionamiento
    }, 500); // El tiempo de espera es de 900 milisegundos (0.9 segundos)
  </script>
</body>

</html>
