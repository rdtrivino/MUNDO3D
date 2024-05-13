<?php
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

$sql_pedidos = "SELECT * FROM pedidos WHERE Acciones <> 'inactivo'";
$resultado_pedidos = mysqli_query($link, $sql_pedidos);

function obtenerNombreProducto($IdentificadorProducto, $conexion) {
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
function obtenerNombreEstado($IdentificadorEstado, $conexion) {
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
  <style>
    /* Estilos adicionales personalizados */
    .table-responsive {
      overflow-x: auto;
    }
    .table {
      background-color: #fff; /* Fondo blanco */
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra */
    }
    .table thead th {
      background-color: #343a40; /* Fondo oscuro para el encabezado */
      color: #fff;
      font-weight: bold; /* Texto en negrita */
    }
    .table tbody tr:nth-of-type(odd) {
      background-color: #f2f2f2;
    }
    .table tbody tr:hover {
      background-color: #e9ecef;
    }
    .home-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            cursor: pointer;
            z-index: 999;
        }

        .home-icon img {
            width: 50px; 
            height: 50px;
            background-color: white; 
            padding: 5px; 
            border-radius: 50%; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }

  </style>
</head>
<body style="background: linear-gradient(135deg, #2980b9, #2c3e50); color: white;">
<a href="Catalogologin.php" class="home-icon">
        <img src="/../MUNDO 3D/images/bx-home-alt-2.svg" alt="Ir a Inicio">
    </a>
<div class="container-fluid mt-4">
  <h2 class="text-center mb-4">Mis Pedidos</h2>
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead class="thead-dark">
        <tr>
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
         </tr>
      </thead>
      <tbody>
        <?php
         // Verificar si la consulta tuvo éxito
         if ($resultado_pedidos && mysqli_num_rows($resultado_pedidos) > 0) {
            while ($row = mysqli_fetch_assoc($resultado_pedidos)) {
                ?>
                <tr id="pedidoRow<?php echo $row['Identificador']; ?>">
                    <td><?php echo $row['Identificador']; ?></td>
                    <td><?php echo obtenerNombreEstado($row['Pe_Estado'], $link); ?></td>
                    <td><?php echo obtenerNombreProducto($row['Pe_Producto'], $link); ?></td>
                    <td><?php echo $row['Pe_Cantidad']; ?></td>
                    <td><?php echo $row['Pe_Fechapedido']; ?></td>
                    <td><?php echo $row['Pe_Fechaentrega']; ?></td>
                    <td><?php echo $row['pe_nombre_pedido']; ?></td>
                    <td><img src="data:image/png;base64,<?php echo base64_encode($row['pe_imagen_pedido']); ?>" alt="Imagen del pedido" style="width: 200px; height: 200px;"></td>
                    <td><?php echo $row['pe_tipo_impresion']; ?></td>
                    <td><?php echo $row['pe_color']; ?></td>
                    <td><?php echo $row['Pe_Observacion']; ?></td>
                </tr>
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

</body>
</html>
