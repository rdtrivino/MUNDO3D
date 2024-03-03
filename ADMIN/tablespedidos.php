
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
    <?php include 'funcionestabladepedidos.php'; ?>
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
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                                <i class="fas fa-plus-circle me-1"></i> Agregar Nuevos pedidos
                            </button>
                        </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary w-100" onclick="generarReportePDF()">
                                    <i class="fas fa-file-pdf me-1"></i> Generar Reporte PDF
                                </button>
                            </div>
                        <script>
                            function generarReportePDF() {
                                // Redirige a la página que genera el reporte PDF
                                window.open("generar_reporte.php", "_blank");
                            }
                        </script>
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
                                        // Realizar consulta SQL para obtener los pedidos
                                        $sql_pedidos = "SELECT * FROM pedido";
                                        $resultado_pedidos = mysqli_query($link, $sql_pedidos);

                                        // Verificar si la consulta tuvo éxito
                                        if ($resultado_pedidos) {
                                            // Iterar sobre cada fila de resultado
                                            while ($row = mysqli_fetch_assoc($resultado_pedidos)) {
                                                // Asignar los valores a variables
                                                $codigo = $row['Pe_Codigo'];
                                                $estado = obtenerNombreEstado($row['Pe_Estado'], $link);
                                                $producto = obtenerNombreProducto($row['Pe_Producto'], $link);
                                                $cantidad = $row['Pe_Cantidad'];
                                                $precio = $row['Pe_Precio'];
                                                $fechaEntrega = $row['Pe_Fechaentrega'];
                                                $fechaPedido = $row['Pe_Fechapedido'];
                                                $cliente = $row['Pe_Cliente'];
                                                $observacion = $row['Pe_Observacion'];
                                        ?>

                                                <tr>
                                                    <td><?php echo $codigo; ?></td>
                                                    <td><?php echo $estado; ?></td>
                                                    <td><?php echo $producto; ?></td>
                                                    <td><?php echo $cantidad; ?></td>
                                                    <td><?php echo $precio; ?></td>
                                                    <td><?php echo $fechaEntrega; ?></td>
                                                    <td><?php echo $fechaPedido; ?></td>
                                                    <?php
                                                    // Realizar consulta SQL para obtener el nombre del cliente
                                                    $documento_cliente = $row['Pe_Cliente'];
                                                    $sql_nombre_cliente = "SELECT Usu_Nombre_completo FROM usuario WHERE Usu_Identificacion = '$documento_cliente'";
                                                    $resultado_nombre_cliente = mysqli_query($link, $sql_nombre_cliente);

                                                    // Verificar si la consulta tuvo éxito
                                                    if ($resultado_nombre_cliente && mysqli_num_rows($resultado_nombre_cliente) > 0) {
                                                        // Obtener el nombre del cliente
                                                        $nombre_cliente = mysqli_fetch_assoc($resultado_nombre_cliente)['Usu_Nombre_completo'];
                                                    } else {
                                                        // Si no se encuentra el cliente, mostrar el documento
                                                        $nombre_cliente = $documento_cliente;
                                                    }
                                                    ?>
                                                    <td><?php echo $nombre_cliente; ?></td>
                                                    <td><?php echo $observacion; ?></td>
                                                    <td>
                                                    <!-- Contenedor para los botones -->
                                                    <div class="btn-group" role="group" aria-label="Acciones">
                                                        <!-- Botón de Editar -->
                                                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editarModal<?php echo $codigo; ?>' data-toggle='tooltip' data-placement='top' title='Editar'>
                                                            <i class='fas fa-edit'></i>
                                                        </button>
                                                            <!-- Modal de edición para pedidos -->
                                                            <div class="modal fade" id="editarModal<?php echo $row['Pe_Codigo']; ?>" tabindex="-1" aria-labelledby="editarModalLabel<?php echo $row['Pe_Codigo']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editarModalLabel<?php echo $row['Pe_Codigo']; ?>">Editar Pedido</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Formulario para editar el pedido -->
                                                                            <form id="formulario-edicion-<?php echo $row['Pe_Codigo']; ?>">
                                                                                <div class="mb-3">
                                                                                    <label for="codigo" class="form-label">Código</label>
                                                                                    <input type="text" class="form-control form-control-dark" id="codigo-<?php echo $row['Pe_Codigo']; ?>" name="codigo" value="<?php echo $row['Pe_Codigo']; ?>" disabled style="background-color: #6c757d; color: #fff; cursor: not-allowed;">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="estado" class="form-label">Estado</label>
                                                                                    <select class="form-select" id="estado-<?php echo $row['Pe_Codigo']; ?>" name="estado" required>
                                                                                        <?php
                                                                                        // Iterar sobre los estados posibles
                                                                                        foreach ($estados_posibles as $estado_posible) {
                                                                                            $selected = ($estado_posible['Es_Codigo'] == $row['Es_pedido']) ? 'selected' : '';
                                                                                            echo "<option value=\"{$estado_posible['Es_Codigo']}\" $selected>{$estado_posible['Es_Nombre']}</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="producto" class="form-label">Producto</label>
                                                                                    <select class="form-select" id="producto-<?php echo $row['Pe_Codigo']; ?>" name="producto" required>
                                                                                        <?php
                                                                                        // Realizar consulta SQL para obtener los productos
                                                                                        $sql_productos = "SELECT * FROM producto";
                                                                                        $resultado_productos = mysqli_query($link, $sql_productos);

                                                                                        // Verificar si la consulta tuvo éxito
                                                                                        if ($resultado_productos) {
                                                                                            // Iterar sobre cada fila de resultado para obtener los productos
                                                                                            while ($row_producto = mysqli_fetch_assoc($resultado_productos)) {
                                                                                                $selected = ($row_producto['Pro_Codigo'] == $row['Pe_Producto']) ? 'selected' : '';
                                                                                                echo "<option value=\"{$row_producto['Pro_Codigo']}\" $selected>{$row_producto['Pro_Nombre']}</option>";
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="cantidad" class="form-label">Cantidad</label>
                                                                                    <input type="number" class="form-control" id="cantidad-<?php echo $row['Pe_Codigo']; ?>" name="cantidad" value="<?php echo $row['Pe_Cantidad']; ?>" required>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="precio" class="form-label">Precio</label>
                                                                                    <input type="number" class="form-control" id="precio-<?php echo $row['Pe_Codigo']; ?>" name="precio" value="<?php echo $row['Pe_Precio']; ?>" required>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="fechaEntrega" class="form-label">Fecha de Entrega</label>
                                                                                    <input type="date" class="form-control" id="fechaEntrega-<?php echo $row['Pe_Codigo']; ?>" name="fechaEntrega" value="<?php echo $row['Pe_Fechaentrega']; ?>" required>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="fechaPedido" class="form-label">Fecha de Pedido</label>
                                                                                    <input type="date" class="form-control" id="fechaPedido-<?php echo $row['Pe_Codigo']; ?>" name="fechaPedido" value="<?php echo $row['Pe_Fechapedido']; ?>" required>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="cliente" class="form-label">Cliente</label>
                                                                                    <?php
                                                                                    // Realizar consulta SQL para obtener el nombre del cliente
                                                                                    $cedula_cliente = $row['Pe_Cliente'];
                                                                                    $sql_nombre_cliente = "SELECT Usu_Nombre_completo FROM usuario WHERE Usu_Identificacion = '$cedula_cliente'";
                                                                                    $resultado_nombre_cliente = mysqli_query($link, $sql_nombre_cliente);

                                                                                    // Verificar si la consulta tuvo éxito
                                                                                    if ($resultado_nombre_cliente && mysqli_num_rows($resultado_nombre_cliente) > 0) {
                                                                                        // Obtener el nombre del cliente
                                                                                        $nombre_cliente = mysqli_fetch_assoc($resultado_nombre_cliente)['Usu_Nombre_completo'];
                                                                                    } else {
                                                                                        // Si no se encuentra el cliente, mostrar la cédula
                                                                                        $nombre_cliente = $cedula_cliente;
                                                                                    }
                                                                                    ?>
                                                                                    <input type="text" class="form-control form-control-dark" id="cliente-<?php echo $row['Pe_Codigo']; ?>" name="cliente" value="<?php echo $nombre_cliente; ?>" readonly style="background-color: #6c757d; color: #fff; cursor: not-allowed;">
                                                                                </div>


                                                                                <div class="mb-3">
                                                                                    <label for="observacion" class="form-label">Observación</label>
                                                                                    <textarea class="form-control" id="observacion-<?php echo $row['Pe_Codigo']; ?>" name="observacion" rows="3"><?php echo $row['Pe_Observacion']; ?></textarea>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                            <button type="button" class="btn btn-primary" onclick="guardar_cambios(<?php echo $row['Pe_Codigo']; ?>)">Guardar Cambios</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                function guardar_cambios(codigo) {
                                                                    // Obtener los valores del formulario
                                                                    var cantidad = document.getElementById('cantidad-' + codigo).value;
                                                                    var precio = document.getElementById('precio-' + codigo).value;
                                                                    var fechaEntrega = document.getElementById('fechaEntrega-' + codigo).value;
                                                                    var fechaPedido = document.getElementById('fechaPedido-' + codigo).value;
                                                                    var cliente = document.getElementById('cliente-' + codigo).value;
                                                                    var observacion = document.getElementById('observacion-' + codigo).value;

                                                                    // Realizar la solicitud AJAX o ejecutar el código para guardar los cambios en la base de datos
                                                                    // Aquí debes colocar la lógica correspondiente

                                                                    // Ejemplo de alerta de éxito
                                                                    alert("Los cambios se han realizado con éxito.");

                                                                    // Cerrar el modal después de realizar los cambios
                                                                    $('#editarModal' + codigo).modal('hide');

                                                                    // Recargar la página después de un cierto tiempo (opcional)
                                                                    setTimeout(function() {
                                                                        location.reload();
                                                                    }, 1000);
                                                                }
                                                            </script>
                                                            <!-- Botón de Eliminar -->
                                                            <button type="button" class="btn btn-danger" onclick="mostrarModalConfirmacion(<?php echo $codigo; ?>)" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>

                                                            <!-- Modal de confirmación -->
                                                            <div class="modal fade" id="eliminarModal<?php echo $codigo; ?>" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="eliminarModalLabel">Confirmación de eliminación</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            ¿Seguro que quieres eliminar este pedido?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                            <button type="button" class="btn btn-danger" onclick="eliminarPedido(<?php echo $codigo; ?>)">Eliminar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                function mostrarModalConfirmacion(codigo) {
                                                                    $('#eliminarModal' + codigo).modal('show');
                                                                }

                                                                function eliminarPedido(codigo) {
                                                                    // Aquí puedes realizar la solicitud AJAX para eliminar el pedido
                                                                    // Reemplaza esta línea con tu lógica para eliminar el pedido
                                                                    
                                                                    // Después de eliminar el pedido, cierra el modal
                                                                    $('#eliminarModal' + codigo).modal('hide');

                                                                    // Puedes agregar aquí más acciones después de eliminar el pedido, como actualizar la tabla de pedidos
                                                                }
                                                            </script>

                                                    </div>
                                                </td>

                                        <?php
                                            }
                                        } else {
                                            // La consulta no tuvo éxito, mostrar un mensaje de error
                                            echo "<tr><td colspan='10'>No se pudieron obtener los pedidos.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </body>
                                        <?php
                                        
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
