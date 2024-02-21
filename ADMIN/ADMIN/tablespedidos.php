<?php
session_start();
require '../conexion.php';

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit(); 
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

function obtenerNombreProducto($codigoProducto, $tu_conexion) {
    $sql = "SELECT pro_nombre FROM producto WHERE pro_codigo = " . $codigoProducto;
    $resultado = mysqli_query($tu_conexion, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['pro_nombre'];
    } else {
        return "Producto no encontrado";
    }
}

// Función para obtener el nombre del estado a partir del código
function obtenerNombreEstado($codigoEstado, $tu_conexion) {
    $sql = "SELECT Es_Nombre FROM pedido_estado WHERE Es_Codigo = " . $codigoEstado;
    $resultado = mysqli_query($tu_conexion, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['Es_Nombre'];
    } else {
        return "Estado no encontrado";
    }
}

// Verificar si se envió el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_cambios'])) {
    // Recuperar los datos del formulario
    $codigoPedido = $_POST['Pe_Codigo'];
    $nuevoEstado = $_POST['Pe_Estado'];
    $nuevaCantidad = $_POST['Pe_Cantidad'];
    $nuevoPrecio = $_POST['Pe_Precio'];
    $nuevaFechaEntrega = $_POST['Pe_Fechaentrega'];
    $nuevoCliente = $_POST['cliente'];
    $nuevaObservacion = $_POST['observacion'];

    // Realizar la actualización en la base de datos
    $consulta = "UPDATE pedido SET Pe_Estado = '$nuevoEstado', Pe_Cantidad = '$nuevaCantidad', Pe_Precio = '$nuevoPrecio', Pe_Fechaentrega = '$nuevaFechaEntrega', Pe_Cliente = '$nuevoCliente', Pe_Observacion = '$nuevaObservacion' WHERE Pe_Codigo = '$codigoPedido'";
    
    $resultado = mysqli_query($link, $consulta);

    if ($resultado) {
        // Éxito
        echo "Cambios guardados con éxito";
    } else {
        // Error
        echo "Error al guardar los cambios: " . mysqli_error($link);
    }
}

// Obtener datos existentes
$sql = "SELECT Pe_Codigo, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Precio, Pe_Fechaentrega, Pe_Fechapedido, Pe_Cliente, Pe_Observacion FROM pedido";
$resultado = mysqli_query($link, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($link));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tabla de pedidos</title>
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Otros scripts -->
    <script src="tu-script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />


</head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">ADMINISTRADOR</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombreCompleto; ?><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../index.html" id="cerrar-sesion-button">Cerrar sesión</a></li>     
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">INICIO</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                INICIO
                            </a>
                            <div class="sb-sidenav-menu-heading">Tablas</div>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            </div>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas usuarios
                            </a>
                            <a class="nav-link" href="tablesproductos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas Productos
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"></div>
                        MUNDO 3D
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Tabla de pedidos</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Tablas</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                Esta tabla almacena información de los pedidos registrados en el sistema.
                                <div class="animation-container">
                                    <div class="animation-item">
                                        <img src="../images/bx-package.svg" alt="Señor con paquete">
                                    </div>
                                    <div class="animation-item">
                                        <img src="../images/bxs-truck.svg" alt="Camión">
                                    </div>
                                    <div class="animation-item">
                                        <img src="../images/bxs-plane-land.svg" alt="Avión">
                                    </div>
                                    <div class="animation-item">
                                        <img src="../images/bxs-ship.svg" alt="Barco">
                                    </div>
                                </div>
                                <style>
                                    .animation-container {
                                        position: relative;
                                        width: 100%;
                                        height: 100px;
                                        overflow: hidden;
                                    }

                                    .animation-item {
                                        position: absolute;
                                        top: 50%;
                                        transform: translateY(-50%);
                                        display: inline-block;
                                        opacity: 0;
                                        animation: moveRight 20s linear infinite;
                                    }

                                    .animation-item:nth-child(1) {
                                        animation-delay: 0s;
                                    }

                                    .animation-item:nth-child(2) {
                                        animation-delay: 5s;
                                    }

                                    .animation-item:nth-child(3) {
                                        animation-delay: 10s;
                                    }

                                    .animation-item:nth-child(4) {
                                        animation-delay: 15s;
                                    }

                                    @keyframes moveRight {
                                        0% {
                                            left: -100%;
                                            opacity: 1;
                                        }
                                        100% {
                                            left: 100%;
                                            opacity: 0;
                                        }
                                    }
                                    
                                    /* Estilos para cambiar los colores */
                                    img {
                                        filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.5));
                                    }

                                    img:nth-child(odd) {
                                        filter: hue-rotate(180deg) drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.5));
                                    }
                                </style>



                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                PEDIDOS
                            </div>
                            <div class="pdf-link-container">
                                <!-- Enlace con el ícono de PDF -->
                                <a href="reporte_pedidos.php" class="pdf-link" target="_blank">
                                    Generar Reporte PDF <i class="fas fa-file-pdf pdf-icon"></i>
                                </a>
                            </div>
                            <style>
                                /* Estilo para el contenedor del enlace */
                                .pdf-link-container {
                                    position: fixed;
                                    bottom: 20px; /* Ajusta la distancia desde la parte inferior de la página */
                                    right: 20px; /* Ajusta la distancia desde el lado derecho de la página */
                                    z-index: 9999; /* Asegura que esté sobre otros elementos */
                                }

                                /* Estilo para el enlace */
                                .pdf-link {
                                    display: inline-block;
                                    text-decoration: none;
                                    font-size: 18px;
                                    background-color: #2433bd; /* Color de fondo */
                                    color: #fff; /* Color de texto */
                                    padding: 10px 15px; /* Espacio interno */
                                    border-radius: 5px; /* Bordes redondeados */
                                }

                                /* Estilo para el ícono */
                                .pdf-icon {
                                    margin-left: 5px;
                                }
                            </style>
                            <div class="card-body">
                            <body>
                            <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Estado</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Fecha de Entrega</th>
                                            <th>Fecha de Pedido</th>
                                            <th>Cliente</th>
                                            <th>Observación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($resultado)) {
                                        ?>
                                        <tr id="pedidoRow<?php echo $row['Pe_Codigo']; ?>">
                                            <td><?php echo $row['Pe_Codigo']; ?></td>
                                            <td><?php echo obtenerNombreEstado($row['Pe_Estado'], $link); ?></td>
                                            <td><?php echo obtenerNombreProducto($row['Pe_Producto'], $link); ?></td>
                                            <td><?php echo $row['Pe_Cantidad']; ?></td>
                                            <td><?php echo $row['Pe_Precio']; ?></td>
                                            <td><?php echo $row['Pe_Fechaentrega']; ?></td>
                                            <td><?php echo $row['Pe_Fechapedido']; ?></td>
                                            <td><?php echo $row['Pe_Cliente']; ?></td>
                                            <td><?php echo $row['Pe_Observacion']; ?></td>
                                            <td>
                                            <button class="btn btn-sm btn-primary edit-button" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['Pe_Codigo']; ?>">
                                                <i class="fas fa-edit"></i> 
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#deleteModal1" data-delete-id="<?php echo $row['Pe_Codigo']; ?>">
                                                <i class="fas fa-trash"></i> 
                                            </button>
                                        </td>
                                        </tr>
                                        <div class="modal fade" id="editModal<?php echo $row['Pe_Codigo']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Editar Pedido</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <form class="edit-pedido-form" method="POST" action="">
                                        <form class="edit-pedido-form" method="POST" action="">
                                        <div class="form-group">
                                                <label for="edit-Codigo">Codigo:</label>
                                                <input type="text" class="form-control edit-codigo non-editable" name="Pe_Codigo" value="<?php echo $row['Pe_Codigo']; ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                            <div class="form-group">
                                                <label for="edit-estado">Estado:</label>
                                                <select class="form-control edit-estado" name="Pe_Estado">
                                                    <?php
                                                    // Consulta para obtener los estados desde la base de datos
                                                    $sql_estados = "SELECT Estado_ID, Estado_nombre FROM estados";
                                                    $resultado_estados = mysqli_query($conexion, $sql_estados);

                                                    // Verificar si se encontraron estados
                                                    if ($resultado_estados && mysqli_num_rows($resultado_estados) > 0) {
                                                        // Iterar sobre los resultados y crear las opciones del menú desplegable
                                                        while ($estado = mysqli_fetch_assoc($resultado_estados)) {
                                                            $selected = ($row['Pe_Estado'] == $estado['Estado_ID']) ? 'selected' : '';
                                                            echo '<option value="' . $estado['Estado_ID'] . '" ' . $selected . '>' . $estado['Estado_nombre'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="edit-producto">Producto:</label>
                                                <select class="form-control edit-producto" name="Pe_Producto">
                                                    <?php
                                                    // Consulta para obtener los productos desde la base de datos
                                                    $sql_productos = "SELECT Pro_Codigo, Pro_Nombre FROM producto";
                                                    $resultado_productos = mysqli_query($conexion, $sql_productos);

                                                    // Verificar si se encontraron productos
                                                    if ($resultado_productos && mysqli_num_rows($resultado_productos) > 0) {
                                                        // Iterar sobre los resultados y crear las opciones del menú desplegable
                                                        while ($producto = mysqli_fetch_assoc($resultado_productos)) {
                                                            $selected = ($row['Pe_Producto'] == $producto['Pro_Codigo']) ? 'selected' : '';
                                                            echo '<option value="' . $producto['Pro_Codigo'] . '" ' . $selected . '>' . $producto['Pro_Nombre'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="edit-cantidad">Cantidad:</label>
                                                <input type="number" class="form-control edit-cantidad" name="Pe_Cantidad" min="0" max="30" value="<?php echo $row['Pe_Cantidad']; ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="edit-precio">Precio:</label>
                                                <input type="text" class="form-control edit-precio" name="Pe_Precio" value="<?php echo $row['Pe_Precio']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-fecha-entrega">Fecha de Entrega:</label>
                                                <input type="text" class="form-control edit-fecha-entrega" name="Pe_Fechaentrega" id="edit-fecha-entrega" value="<?php echo $row['Pe_Fechaentrega']; ?>">
                                            </div>
                                            <script>
                                                $(function() {
                                                    $("#edit-fecha-entrega").datepicker();
                                                });
                                            </script>
                                            <div class="form-group">
                                                <label for="edit-fecha-pedido">Fecha de Pedido:</label>
                                                <input type="text" class="form-control edit-fecha-pedido non-editable" name="Pe_Fechapedido" value="<?php echo $row['Pe_Fechapedido']; ?>" readonly>
                                            </div>
                                            <style>
                                            .non-editable {
                                                background-color: #f1f1f1; /* Cambia el color de fondo a un gris claro */
                                                border: 1px solid #ccc; /* Añade un borde gris claro */
                                                cursor: not-allowed; /* Cambia el cursor a "no permitido" */
                                            }
                                            </style>
                                            <div class="form-group">
                                                <label for="edit-cliente">Cliente:</label>
                                                <input type="text" class="form-control edit-cliente" name="cliente" value="<?php echo $row['Pe_Cliente']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-observacion">Observación:</label>
                                                <textarea class="form-control edit-observacion" name="observacion"><?php echo $row['Pe_Observacion']; ?></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary" name="guardar_cambios">Guardar Cambios</button>
                                                </div>
                                            <!-- Agrega más campos de edición según tus necesidades -->
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="modal fade" id="deleteModal1" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Eliminar Pedido</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Estás seguro de que deseas ocultar este pedido?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-danger" data-delete-id="1">Ocultar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    .oculto {
                                        display: none;
                                    }

                                </style>

                                <script>
                                    $(document).on("click", ".btn-danger", function () {
                                        console.log("Botón de ocultar clicado");
                                        var codigoPedido = $(this).data("delete-id");
                                        var pedidoRow = $("#pedidoRow" + codigoPedido);
                                        console.log("PedidoRow:", pedidoRow);
                                        console.log("Clase oculta antes de toggle:", pedidoRow.hasClass("oculto"));

                                        // Agregar o quitar la clase "oculto" según el estado actual
                                        pedidoRow.toggleClass("oculto");

                                        console.log("Clase oculta después de toggle:", pedidoRow.hasClass("oculto"));

                                        // Cierra el modal
                                        $("#deleteModal1").modal("hide");
                                    });
                                </script>

                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
