<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Garantiza que el navegador use el motor de renderizado más reciente -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace la página responsiva para dispositivos móviles -->
  
  <!-- Icono que aparece en la pestaña del navegador -->
  <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
  <title>Redireccionando...</title>
  
  <!-- Estilos CSS para la animación de carga -->
  <style>
    /* Estilo general del loader (la animación de "Cargando...") */
    .loader {
      width: fit-content; /* Ajusta el ancho del contenedor al contenido */
      font-weight: bold; /* El texto será en negrita */
      font-family: monospace; /* Usamos una fuente monoespaciada */
      font-size: 30px; /* Tamaño de la fuente */
      
      /* Aplicación de un fondo con gradiente radial que se moverá durante la animación */
      background: radial-gradient(circle closest-side, #000 94%, #0000) right/calc(200% - 1em) 100%;
      animation: l24 1s infinite alternate linear; /* Aplica la animación que mueve el fondo */
    }

    /* Pseudo-elemento ::before para mostrar el texto "Cargando..." dentro del loader */
    .loader::before {
      content: "Cargando..."; /* El texto que aparece en la animación */
      line-height: 1em; /* Alineación vertical del texto */
      color: #0000; /* Hacemos el texto transparente para que solo se vea el fondo */
      background: inherit; /* Hereda el fondo del elemento principal .loader */
      
      /* Fondo con gradiente radial */
      background-image: radial-gradient(circle closest-side, #fff 94%, #000); 
      
      /* Recorta el fondo en el texto para darle el efecto de color de texto */
      -webkit-background-clip: text; 
      background-clip: text; 
    }

    /* Definición de la animación que mueve el gradiente de fondo */
    @keyframes l24 {
      100% {
        background-position: left; /* Mueve el fondo a la izquierda durante la animación */
      }
    }

    /* Centra el loader en la página */
    .loader {
      margin: 45%; /* Centra horizontalmente */
      width: 80%; /* El ancho es el 80% de la página */
      max-width: 400px; /* El ancho máximo es 400px */
      margin-top: 20%; /* Añade un margen superior para que el loader no esté tan pegado al borde superior */
    }

    /* Asegura que el loader ocupe todo el ancho y mantenga la proporción */
    .loader {
      width: 100%; /* Ocupa el 100% del ancho disponible */
      height: auto; /* Mantiene la proporción de la imagen */
    }
  </style>
  
  <!-- Script para redirigir a la página de destino después de un retraso -->
  <script>
    setTimeout(function () {
      // Redirige a la URL después de 3 segundos (3000 milisegundos)
      window.location.href = '../carrito'; // Reemplaza '../carrito' con la URL de destino deseada
    }, 3000); // El tiempo de espera en milisegundos (3 segundos)
  </script>
</head>

<body style="background-color: #D3D3D3;"> <!-- Establece un color de fondo gris claro para la página -->
  
  <!-- Contenedor del loader que muestra el texto "Cargando..." -->
  <div class="loader"></div>

</body>

</html>