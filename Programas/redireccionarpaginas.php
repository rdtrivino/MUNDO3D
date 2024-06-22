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
    <!--
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
    </style>-->
    <style>
        .container {
  position: absolute;
  top: 45%;
  left: 48%;
}

.square {
  width: 20px;
  height: 60px;
  background: rgb(71, 195, 248);
  border-radius: 10px;
  display: block;
  /*margin:10px;*/
  -webkit-animation: turn 2.5s ease infinite;
  animation: turn 2.5s ease infinite;
  box-shadow: rgb(71, 195, 248) 0px 1px 15px 0px;
}

.top {
  position: absolute;
  left: 40%;
  top: 50%;
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
}

.bottom {
  position: absolute;
  left: 40%;
  top: 50%;
  -webkit-transform: rotate(-90deg);
  transform: rotate(-90deg);
}

.left {
  position: absolute;
  left: 40%;
  top: 50%;
}

.right {
  position: absolute;
  left: 40%;
  top: 50%;
  -webkit-transform: rotate(-180deg);
  transform: rotate(-180deg);
}

@-webkit-keyframes turn {
  0% {
    transform: translateX(0) translateY(0) rotate(0);
  }

  50% {
    transform: translateX(400%) translateY(100%) rotate(90deg);
  }

  100% {
    transform: translateX(0) translateY(0) rotate(0);
  }
}

@keyframes turn {
  0% {
    transform: translateX(0) translateY(0) rotate(0);
  }

  70% {
    transform: translateX(400%) translateY(100%) rotate(90deg);
  }

  100% {
    transform: translateX(0) translateY(0) rotate(0);
  }
}
    </style>
</head>
<div class="container">
  <div class="top">
    <div class="square">
      <div class="square">
        <div class="square">
          <div class="square">
            <div class="square"><div class="square">
            </div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bottom">
    <div class="square">
      <div class="square">
        <div class="square">
          <div class="square">
            <div class="square"><div class="square">
            </div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="left">
    <div class="square">
      <div class="square">
        <div class="square">
          <div class="square">
            <div class="square"><div class="square">
            </div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="right">
    <div class="square">
      <div class="square">
        <div class="square">
          <div class="square">
            <div class="square"><div class="square">
            </div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <script>
        // Redirecciona al usuario después de 3 segundos
        setTimeout(function () {
            var redirectUrl = "<?php echo $redirectUrl; ?>";
            window.location.href = redirectUrl;
        }, 2000); // Espera 3 segundos antes de redirigir (3000 milisegundos)
    </script>
</body>

</html>