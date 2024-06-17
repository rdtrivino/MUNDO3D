<?php
session_start();
include __DIR__ . '/../conexion.php';

// Confirmación de que el usuario ha realizado el proceso de autenticación
if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
  header("Location: ../Programas/autenticacion.php");
  exit(); // Terminamos la ejecución del script después de redirigir
}

// Realizamos la consulta para obtener el rol del usuario
$peticion = "SELECT Usu_rol FROM usuario WHERE Usu_Identificacion = '" . $_SESSION['user_id'] . "'";
$result = mysqli_query($link, $peticion);

// Verificamos si la consulta tuvo éxito
if (!$result) {
  // Manejo de errores de consulta
  // Redirigir a la página de autenticación o mostrar un mensaje de error
  header("Location: ../Programas/autenticacion.php");
  exit(); // Terminamos la ejecución del script después de redirigir
}

// Verificamos si la consulta devolvió exactamente un resultado
if (mysqli_num_rows($result) != 1) {
  // Si la consulta no devuelve un solo resultado, puede ser un problema de base de datos
  // Redirigir a la página de autenticación o mostrar un mensaje de error
  header("Location: ../Programas/autenticacion.php");
  exit(); // Terminamos la ejecución del script después de redirigir
}

// Obtenemos el rol del usuario
$fila = mysqli_fetch_assoc($result);
$rolUsuario = $fila['Usu_rol'];

// Verificar si el rol del usuario es diferente de 3
if ($rolUsuario != 3) {
  // Si el rol no es 3, redirigir a la página de autenticación
  header("Location: ../Programas/autenticacion.php");
  exit(); // Terminamos la ejecución del script después de redirigir
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

// Realizar la conexión a la base de datos
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

// Consulta SQL para obtener los pedidos del usuario logueado
$sql_pedidos_usuario = "SELECT * FROM pedidos WHERE Pe_Cliente = $usuario_id AND Acciones <> 'inactivo'";
$resultado_pedidos_usuario = mysqli_query($link, $sql_pedidos_usuario);

// Función para obtener el nombre del producto a partir de su identificador
function obtenerNombreProducto($IdentificadorProducto, $conexion)
{
  $sql = "SELECT pro_nombre FROM productos WHERE Identificador = ?";
  $stmt = mysqli_prepare($conexion, $sql);
  mysqli_stmt_bind_param($stmt, "i", $IdentificadorProducto);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $nombreProducto);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);
  return $nombreProducto ? $nombreProducto : "Producto no encontrado";
}

// Función para obtener el nombre del estado a partir del código
function obtenerNombreEstado($IdentificadorEstado, $conexion)
{
  $sql = "SELECT Es_Nombre FROM pedido_estado WHERE Es_Codigo = ?";
  $stmt = mysqli_prepare($conexion, $sql);
  mysqli_stmt_bind_param($stmt, "i", $IdentificadorEstado);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $nombreEstado);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);
  return $nombreEstado ? $nombreEstado : "Estado no encontrado";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Pedidos</title>
  <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Estilos adicionales personalizados */
    .table-responsive {
      overflow-x: auto;
    }

    .table {
      background-color: #fff;
      /* Fondo blanco */
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      /* Sombra */
    }

    .table thead th {
      background-color: #343a40;
      /* Fondo oscuro para el encabezado */
      color: #fff;
      font-weight: bold;
      /* Texto en negrita */
    }

    .table tbody tr:nth-of-type(odd) {
      background-color: #f2f2f2;
    }

    .table tbody tr:hover {
      background-color: #e9ecef;
    }

    .text-white {
      color: white;
    }

    .font-small {
      font-size: 12px;
      /* Tamaño pequeño */
    }

    .font-medium {
      font-size: 16px;
      /* Tamaño mediano */
    }

    .font-large {
      font-size: 20px;
      /* Tamaño grande */
    }

    .font-small,
    .font-medium,
    .font-large {
      background-color: transparent;
      /* Quitar el fondo */
      color: black;
      /* Color de texto blanco */
      font-weight: bold;
      border: none;
      cursor: pointer;
      /* Negrita */
    }

    /* Boton Home */
    .Btn-1 {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      width: 45px;
      height: 45px;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition-duration: .3s;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
      background-color: rgb(0, 0, 0);
      margin-top: 10px;
      margin-left: 10px;
    }

    /* plus sign */
    .sign {
      width: 100%;
      transition-duration: .3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .sign svg {
      width: 17px;
    }

    .sign svg path {
      fill: white;
    }

    /* text */
    .text {
      position: absolute;
      right: -10px;
      /* Ajusta la posición a la derecha, con un margen de 10px */
      opacity: 0;
      /* Cambia la opacidad para hacer visible el texto */
      color: white;
      font-size: 1.2em;
      font-weight: 600;
      transition-duration: .3s;
    }



    /* hover effect on button width */
    .Btn-1:hover {
      width: 125px;
      border-radius: 40px;
      transition-duration: .3s;
    }

    .Btn-1:hover .sign {
      width: 30%;
      transition-duration: .3s;
      padding-left: 20px;
    }

    /* hover effect button's text */
    .Btn-1:hover .text {
      opacity: 1;
      width: 70%;
      transition-duration: .3s;
      padding-right: 10px;
    }

    /* button click effect*/
    .Btn-1:active {
      transform: translate(2px, 2px);
    }

    .title-container h2 {
      margin: 0;
      pointer-events: auto;
    }

    .title-container {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      text-align: center;
    }
  </style>
</head>

<body style="background: linear-gradient(to bottom right, #dddddd, #dddddd);">
  <div id="buttons-container"
    style="display: flex; justify-content: flex-end; align-items: center; margin-right: 10px;">
    <div class="button-box">
      <button class="font-small text-black" onclick="disminuirTamano()">A</button>
    </div>
    <div class="button-box">
      <button class="font-medium text-black" onclick="ajustarTamano('medium')">A</button>
    </div>
    <div class="button-box">
      <button class="font-large text-black" onclick="aumentarTamano()">A</button>
    </div>
    <div class="button-box" style="margin-right: 10px;">
      <i class="fas fa-wheelchair fa-lg text-black"></i>
    </div>
  </div>

  <div class="container-fluid mt-4">

    <div class="container-fluid mt-4">
      <div class="d-flex justify-content-between align-items-center mb-4 position-relative">
        <a class="Btn-1" href=../Programas/redireccionarpaginas.php?page=impresoras">
          <div class="sign">
            <img src="../images/iconizer-bx-home-alt-2.2.svg" alt="Inicio">
          </div>
          <div class="text">INICIO</div>
        </a>

        <div class="title-container">
          <h2 class="mb-0">Mis Pedidos</h2>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead class="thead-dark">
            <tr>
              <th>Código</th>
              <th>Estado</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Fecha de Pedido</th>
              <th>Fecha de Entrega</th>
              <th>Nombre de Pedido</th>
              <th>Imagen</th>
              <th>Tipo de Impresión</th>
              <th>Color</th>
              <th>Observación</th>
              <th>Factura</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Verificar si la consulta tuvo éxito
            if ($resultado_pedidos_usuario && mysqli_num_rows($resultado_pedidos_usuario) > 0) {
              while ($row = mysqli_fetch_assoc($resultado_pedidos_usuario)) {
                ?>
                <tr id="pedidoRow<?php echo $row['Identificador']; ?>">
                  <td><?php echo $row['Identificador']; ?></td>
                  <td><?php echo obtenerNombreEstado($row['Pe_Estado'], $link); ?></td>
                  <td><?php echo obtenerNombreProducto($row['Pe_Producto'], $link); ?></td>
                  <td><?php echo $row['Pe_Cantidad']; ?></td>
                  <td><?php echo $row['Pe_Fechapedido']; ?></td>
                  <td><?php echo $row['Pe_Fechaentrega']; ?></td>
                  <td><?php echo $row['pe_nombre_pedido']; ?></td>
                  <td><img src="data:image/png;base64,<?php echo base64_encode($row['pe_imagen_pedido']); ?>"
                      alt="Imagen del pedido" style="width: 200px; height: 200px;"></td>
                  <td><?php echo $row['pe_tipo_impresion']; ?></td>
                  <td><?php echo $row['pe_color']; ?></td>
                  <td><?php echo $row['Pe_Observacion']; ?></td>
                  <td>
                    <div class="button-container">
                      <!-- Botón para descargar la factura -->
                      <a href="factura.php?numero_factura=00123&fecha=16%20de%20junio%20de%202024&cliente=Juan%20Pérez&productos=%5B%7B%22descripcion%22%3A%22Producto%20A%22%2C%22cantidad%22%3A2%2C%22precio_unitario%22%3A50%2C%22total%22%3A100%7D%2C%7B%22descripcion%22%3A%22Producto%20B%22%2C%22cantidad%22%3A1%2C%22precio_unitario%22%3A75%2C%22total%22%3A75%7D%5D&total=175"
                        class="download-button">
                        <div class="docs">
                          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                          </svg>
                          Descargar Factura
                        </div>
                        <div class="download">
                          <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                          </svg>
                        </div>
                      </a>
                    </div>
                    <br>
                  </td>

                </tr>
                <style>
                  .download-button {
                    position: relative;
                    border-width: 0;
                    color: rgb(19, 19, 19);
                    font-size: 15px;
                    font-weight: 600;
                    border-radius: 4px;
                    z-index: 1;
                  }

                  .download-button .docs {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 10px;
                    min-height: 40px;
                    padding: 0 10px;
                    border-radius: 4px;
                    z-index: 1;
                    background-color: #ffffff;
                    border: solid 1px #e8e8e82d;
                    transition: all 0.5s cubic-bezier(0.77, 0, 0.175, 1);
                  }

                  .download-button:hover {
                    box-shadow: rgba(233, 233, 233, 0.555) 0px 54px 55px,
                      rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px,
                      rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
                  }

                  .download {
                    position: absolute;
                    inset: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    max-width: 90%;
                    margin: 0 auto;
                    z-index: -1;
                    border-radius: 0px 0px 4px 4px;
                    transform: translateY(0%);
                    background-color: #01e056;
                    border: solid 1px #01e0572d;
                    transition: all 0.5s cubic-bezier(0.77, 0, 0.175, 1);
                    cursor: pointer;
                  }

                  .download-button:hover .download {
                    transform: translateY(100%);
                  }

                  .download svg polyline,
                  .download svg line {
                    animation: docs 1s infinite;
                  }

                  @keyframes docs {
                    0% {
                      transform: translateY(0%);
                    }

                    50% {
                      transform: translateY(-15%);
                    }

                    100% {
                      transform: translateY(0%);
                    }
                  }
                </style>
                <?php
              }
            } else {
              echo "<tr><td colspan='13'>No se encontraron resultados</td></tr>";
            }
            mysqli_close($link);
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <Script>
      var tamanoOriginal = ''; // Variable global para almacenar el tamaño original

      function disminuirTamano() {
        var currentFontSize = parseFloat(document.body.style.fontSize) || 1;
        var newFontSize = currentFontSize - 1 + 'rem';
        document.body.style.fontSize = newFontSize;
      }

      function ajustarTamano(size) {
        switch (size) {
          case 'small':
            document.body.style.fontSize = 'small';
            break;
          case 'medium':
            document.body.style.fontSize = 'medium';
            break;
          case 'large':
            document.body.style.fontSize = 'large';
            break;
          default:
            break;
        }
      }

      function aumentarTamano() {
        // Aumentar el tamaño de fuente
        var currentFontSize = parseFloat(document.body.style.fontSize) || 1;
        var newFontSize = currentFontSize + 1 + 'rem';
        document.body.style.fontSize = newFontSize;
      }

      function restaurarTamano() {
        // Restaurar el tamaño de fuente al original guardado
        if (tamanoOriginal !== '') {
          document.body.style.fontSize = tamanoOriginal;
        }
      }

      function cambiarCursor(event) {
        event.target.style.cursor = 'pointer';
      }

      function restaurarCursor() {
        document.body.style.cursor = 'default';
      }

      // Guardar el tamaño original al cargar la página
      document.addEventListener('DOMContentLoaded', function () {
        tamanoOriginal = window.getComputedStyle(document.body).fontSize;
      });


      function checkPasswordMatch() {
        const password = document.getElementById('edit-contrasena').value;
        const confirmPassword = document.getElementById('edit-confirm-contrasena').value;
        const passwordError = document.getElementById('password-error');

        if (password !== confirmPassword) {
          passwordError.style.display = 'block';
        } else {
          passwordError.style.display = 'none';
        }
      }

      document.querySelector("#disabled-icon .fa-wheelchair").style.color = "#fff";
    </Script>
</body>

</html>