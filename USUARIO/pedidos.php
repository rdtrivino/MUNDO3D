<?php
session_start();
include __DIR__ . '/../conexion.php';

// Confirmación de que el usuario ha realizado el proceso de autenticación
if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
  header("Location: ../Programas/autenticacion.php");
  exit();
}

// Realizamos la consulta para obtener el rol del usuario
$peticion = "SELECT Usu_rol FROM usuario WHERE Usu_Identificacion = ?";
$stmt = mysqli_prepare($link, $peticion);
if (!$stmt) {
  die('Error en la preparación de la consulta: ' . mysqli_error($link));
}
mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verificamos si la consulta tuvo éxito
if (!$result || mysqli_num_rows($result) != 1) {
  header("Location: ../Programas/autenticacion.php");
  exit();
}

// Obtenemos el rol del usuario
$fila = mysqli_fetch_assoc($result);
$rolUsuario = $fila['Usu_rol'];

// Verificar si el rol del usuario es diferente de 3
if ($rolUsuario != 3) {
  header("Location: ../Programas/autenticacion.php");
  exit();
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

// Realizar la conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$link = mysqli_connect($host, $user, $password, $dbname);

if (!$link) {
  die("Error al conectarse al servidor: " . mysqli_connect_error());
}

// Consulta para obtener los pedidos del usuario logueado
$sql_pedidos_usuario = "
    SELECT 
        c.Compra_ID,
        c.Pe_Estado,
        GROUP_CONCAT(p.Pe_Producto SEPARATOR ', ') AS Productos,
        GROUP_CONCAT(p.Pe_Cantidad SEPARATOR ', ') AS Cantidades,
        c.Pe_Fechapedido,
        c.Pe_Fechaentrega,
        c.pe_nombre_pedido,
        c.nombre_imagen,
        c.pe_tipo_impresion,
        c.pe_color,
        c.Pe_Observacion
    FROM 
        pedidos c
    INNER JOIN 
        pedidos p ON c.Compra_ID = p.Compra_ID
    WHERE 
        c.Pe_Cliente = ? AND p.Acciones <> 'inactivo'
    GROUP BY 
        c.Compra_ID
";


$stmt = mysqli_prepare($link, $sql_pedidos_usuario);
if (!$stmt) {
  die('Error en la preparación de la consulta: ' . mysqli_error($link));
}
mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);
$resultado_pedidos_usuario = mysqli_stmt_get_result($stmt);

// Función para obtener el nombre del producto a partir de su identificador
function obtenerNombreProducto($IdentificadorProducto, $conexion)
{
  $sql = "SELECT pro_nombre FROM productos WHERE Identificador = ?";
  $stmt = mysqli_prepare($conexion, $sql);
  if (!$stmt) {
    return "Error en la preparación de la consulta: " . mysqli_error($conexion);
  }
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
  if (!$stmt) {
    return "Error en la preparación de la consulta: " . mysqli_error($conexion);
  }
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
      <div class="row mt-4">
        <div class="col">
          <div class="table-responsive" style="background-color: #f8f9fa; border-radius: 10px;">
            <table id="datatables" class="table table-striped table-bordered table-hover text-center">
              <thead>
                <tr>
                  <th class="align-middle">ID</th>
                  <th class="align-middle">Fecha Pedido</th>
                  <th class="align-middle">Fecha Entrega</th>
                  <th class="align-middle">Cantidad-Producto</th>
                  <th class="align-middle">Nombre Pedido</th>
                  <th class="align-middle">Tipo Impresion</th>
                  <th class="align-middle">Color</th>
                  <th class="align-middle">Observación</th>
                  <th class="align-middle">Estado Pedido</th>
                  <th class="align-middle">Factura</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql_pedidos = "
              SELECT 
                  p.compra_ID AS pedido_id,
                  MIN(p.Pe_Fechapedido) AS fecha_pedido,
                  MIN(p.Pe_Fechaentrega) AS fecha_entrega,
                  GROUP_CONCAT(DISTINCT CONCAT(p.Pe_Cantidad, ' - ', pr.Pro_Nombre) ORDER BY p.Pe_Producto SEPARATOR '<br>') AS producto,
                  MIN(p.pe_nombre_pedido) AS nombre_pedido,
                  MIN(p.pe_tipo_impresion) AS tipo_impresion,
                  MIN(p.pe_color) AS color,
                  MIN(p.Pe_Observacion) AS observacion,
                  ep.Es_Nombre AS estado_pedido,
                  MIN(f.id) AS factura_id
              FROM 
                  pedidos p
              LEFT JOIN 
                  factura f ON p.compra_ID = f.pedido_id
              LEFT JOIN 
                  pedido_estado ep ON p.Pe_Estado = ep.Es_Codigo
              LEFT JOIN 
                  productos pr ON p.Pe_Producto = pr.Identificador
              WHERE 
                  p.Pe_Estado <> 'inactivo'
              GROUP BY 
                  p.compra_ID
              ORDER BY 
                  p.compra_ID
          ";

                $resultado_pedidos = mysqli_query($link, $sql_pedidos);

                if ($resultado_pedidos && mysqli_num_rows($resultado_pedidos) > 0) {
                  while ($row = mysqli_fetch_assoc($resultado_pedidos)) {
                    ?>
                    <tr id="pedidoRow<?php echo $row['pedido_id']; ?>">
                      <td><?php echo $row['pedido_id']; ?></td>
                      <td><?php echo $row['fecha_pedido']; ?></td>
                      <td><?php echo $row['fecha_entrega']; ?></td>
                      <td><?php echo $row['producto']; ?></td>
                      <td><?php echo $row['nombre_pedido']; ?></td>
                      <td><?php echo $row['tipo_impresion']; ?></td>
                      <td><?php echo $row['color']; ?></td>
                      <td><?php echo $row['observacion']; ?></td>
                      <td><?php echo $row['estado_pedido']; ?></td>
                      <td style="display: flex; align-items: center;">
                        <div class="mr-2">
                          <?php if ($row['factura_id']) { ?>
                            <a href="factura.php?id=<?php echo $row['factura_id']; ?>" class="btn btn-sm btn-success">
                              <i class="fas fa-download"></i> Descargar Factura
                            </a>
                          <?php } else { ?>
                            <span class="text-muted">Sin factura</span>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <style>
                      a {
                        text-decoration: none;
                      }

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