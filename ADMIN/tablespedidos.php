
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
                                window.open("generar_reporte_pedidos.php", "_blank");
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
                    <!-- Modal de agregar nuevo pedido -->
                    <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="agregarModalLabel">Agregar Nuevo Pedido</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario para agregar nuevo pedido -->
                                    <form id="formularioAgregarPedido">
                                        <!-- Campo Pe_Codigo (oculto) -->
                                        <input type="hidden" id="codigo" name="codigo">

                                        <!-- Campo Pe_Estado (oculto) -->
                                        <input type="hidden" id="estado" name="estado" value="1">

                                        <!-- Campo Pe_Producto -->
                                        <div class="mb-3">
                                            <label for="producto" class="form-label">Producto</label>
                                            <select class="form-select" id="producto" name="producto" required>
                                                <?php
                                                // Consulta SQL para obtener los productos que estén en modo activo
                                                $sql_productos_activos = "SELECT * FROM productos WHERE Pro_Estado = 'Activo'";
                                                $resultado_productos_activos = mysqli_query($link, $sql_productos_activos);

                                                // Verificar si la consulta tuvo éxito
                                                if ($resultado_productos_activos && mysqli_num_rows($resultado_productos_activos) > 0) {
                                                    // Iterar sobre cada fila de resultado para obtener los productos activos
                                                    while ($row_producto = mysqli_fetch_assoc($resultado_productos_activos)) {
                                                        // Mostrar los productos activos en la lista desplegable
                                                        echo "<option value=\"{$row_producto['Identificador']}\">{$row_producto['Pro_Nombre']}</option>";
                                                    }
                                                } else {
                                                    // Si no hay productos activos, mostrar un mensaje
                                                    echo "<option value=\"\">No hay productos activos disponibles</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Campo Pe_Cantidad -->
                                        <div class="mb-3">
                                            <label for="cantidad" class="form-label">Cantidad</label>
                                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                                        </div>

                                        <!-- Campo Pe_Precio -->
                                        <div class="mb-3">
                                            <label for="precio" class="form-label">Precio</label>
                                            <input type="number" class="form-control" id="precio" name="precio" required>
                                        </div>

                                        <!-- Campo Pe_Fechaentrega -->
                                        <div class="mb-3">
                                            <label for="fechaEntrega" class="form-label">Fecha de Entrega</label>
                                            <input type="date" class="form-control" id="fechaEntrega" name="fechaEntrega" required>
                                        </div>

                                        <!-- Campo Pe_Fechapedido -->
                                        <div class="mb-3">
                                            <label for="fechaPedido" class="form-label">Fecha de Pedido</label>
                                            <input type="date" class="form-control" id="fechaPedido" name="fechaPedido" required>
                                        </div>

                                        <!-- Campo Pe_Cliente -->
                                        <div class="mb-3">
                                            <label for="cliente" class="form-label">Cliente</label>
                                            <select class="form-select" id="cliente" name="cliente" required>
                                                <?php
                                                // Consulta SQL para obtener los usuarios que estén en modo activo
                                                $sql_usuarios_activos = "SELECT * FROM usuario WHERE Usu_Estado = 'Activo'";
                                                $resultado_usuarios_activos = mysqli_query($link, $sql_usuarios_activos);

                                                // Verificar si la consulta tuvo éxito
                                                if ($resultado_usuarios_activos && mysqli_num_rows($resultado_usuarios_activos) > 0) {
                                                    // Iterar sobre cada fila de resultado para obtener los usuarios activos
                                                    while ($row_usuario = mysqli_fetch_assoc($resultado_usuarios_activos)) {
                                                        // Mostrar los nombres de usuario activos en la lista desplegable
                                                        echo "<option value=\"{$row_usuario['Usu_Identificacion']}\">{$row_usuario['Usu_Nombre_completo']}</option>";
                                                    }
                                                } else {
                                                    // Si no hay usuarios activos, mostrar un mensaje
                                                    echo "<option value=\"\">No hay usuarios activos disponibles</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Campo Pe_Observacion -->
                                        <div class="mb-3">
                                            <label for="observacion" class="form-label">Observación</label>
                                            <textarea class="form-control" id="observacion" name="observacion" rows="3" required></textarea>
                                        </div>

                                        <!-- Botones para enviar el formulario y cerrar el modal -->
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                            <button type="submit" class="btn btn-primary">Agregar Pedido</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
    $(document).ready(function() {
        $('#formularioAgregarPedido').submit(function(event) {
            // Detener el envío del formulario por defecto
            event.preventDefault();

            // Obtener los datos del formulario
            var formData = $(this).serialize();

            // Enviar la solicitud AJAX
            $.ajax({
                type: 'POST',
                url: 'funcionestabladepedidos.php', // Ruta al script PHP que procesará la solicitud
                data: formData,
                success: function(response) {
                    // Manejar la respuesta del servidor
                    alert(response); // Puedes mostrar un mensaje de éxito o hacer alguna otra acción
                    $('#agregarModal').modal('hide'); // Cerrar el modal después de agregar el pedido
                    location.reload(); // Recargar la página para actualizar la tabla de pedidos
                },
                error: function(xhr, status, error) {
                    // Manejar los errores
                    console.error('Error al agregar el pedido:', error);
                    alert('Error al agregar el pedido. Por favor, inténtalo de nuevo.');
                }
            });
        });
    });
</script>


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
                                            <th>Codigo</th>
                                            <th>Estado</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
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
                                        $sql_pedidos = "SELECT * FROM pedidos WHERE Pe_Estado <> 'inactivo'";
                                        $resultado_pedidos = mysqli_query($link, $sql_pedidos);                                        
                                        // Verificar si la consulta tuvo éxito
                                        if ($resultado_pedidos) {
                                            // Iterar sobre cada fila de resultado
                                            while ($row = mysqli_fetch_assoc($resultado_pedidos)) {
                                                // Asignar los valores a variables
                                                $identificador = $row['identificador'];
                                                $estado = obtenerNombreEstado($row['Pe_Estado'], $link);
                                                $producto = obtenerNombreProducto($row['Pe_Producto'], $link);
                                                $cantidad = $row['Pe_Cantidad'];
                                                $fechaEntrega = $row['Pe_Fechaentrega'];
                                                $fechaPedido = $row['Pe_Fechapedido'];
                                                $cliente = $row['Pe_Cliente'];
                                                $observacion = $row['Pe_Observacion'];
                                        ?>

                                                <tr>
                                                    <td><?php echo $row['Identificador']; ?></td>
                                                    <td><?php echo obtenerNombreEstado($row['Pe_Estado'], $link); ?></td>
                                                    <td><?php echo obtenerNombreProducto($row['Pe_Producto'], $link); ?></td>
                                                    <td><?php echo $row['Pe_Cantidad']; ?></td>
                                                    <td><?php echo $row['Pe_Fechaentrega']; ?></td>
                                                    <td><?php echo $row['Pe_Fechapedido']; ?></td>
                                                    <td><?php echo $row['Pe_Cliente']; ?></td>
                                                    <td><?php echo $row['Pe_Observacion']; ?></td>
                                                    <?php
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
                                                    <div class="btn-group" role="group" aria-label="Acciones">
                                                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editarModal<?php echo $codigo; ?>' data-toggle='tooltip' data-placement='top' title='Editar'>
                                                            <i class='fas fa-edit'></i>
                                                        </button>
                                                            <div class="modal fade" id="editarModal<?php echo $row['Identificador']; ?>" tabindex="-1" aria-labelledby="editarModalLabel<?php echo $row['Pe_Codigo']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editarModalLabel<?php echo $row['Pe_Codigo']; ?>">Editar Pedido</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form id="formulario-edicion-<?php echo $row['Pe_Codigo']; ?>">
                                                                                <div class="mb-3">
                                                                                    <label for="codigo" class="form-label">Código</label>
                                                                                    <input type="text" class="form-control form-control-dark" id="codigo-<?php echo $row['Pe_Codigo']; ?>" name="codigo" value="<?php echo $row['Pe_Codigo']; ?>" disabled style="background-color: #6c757d; color: #fff; cursor: not-allowed;">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="estado" class="form-label">Estado</label>
                                                                                    <select class="form-select" id="estado-<?php echo $row['Pe_Codigo']; ?>" name="estado" required>
                                                                                        <?php
                                                                                        $sql_estados = "SELECT Es_Codigo, Es_Nombre FROM pedido_estado";
                                                                                        $resultado_estados = mysqli_query($link, $sql_estados);

                                                                                        if ($resultado_estados && mysqli_num_rows($resultado_estados) > 0) {
                                                                                            while ($estado = mysqli_fetch_assoc($resultado_estados)) {
                                                                                                $selected = ($estado['Es_Codigo'] == $row['Pe_Estado']) ? 'selected' : '';
                                                                                                
                                                                                                echo "<option value=\"{$estado['Es_Codigo']}\" $selected>{$estado['Es_Nombre']}</option>";
                                                                                            }
                                                                                        } else {
                                                                                            echo "<option value=\"\">No hay estados disponibles</option>";
                                                                                        }
                                                                                        
                                                                                        mysqli_free_result($resultado_estados);
                                                                                        ?>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="producto" class="form-label">Producto</label>
                                                                                    <select class="form-select" id="producto-<?php echo $row['Pe_Codigo']; ?>" name="producto" required>
                                                                                        <?php
                                                                                        $sql_productos = "SELECT * FROM producto";
                                                                                        $resultado_productos = mysqli_query($link, $sql_productos);

                                                                                        if ($resultado_productos) {
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
                                                                                    $cedula_cliente = $row['Pe_Cliente'];
                                                                                    $sql_nombre_cliente = "SELECT Usu_Nombre_completo FROM usuario WHERE Usu_Identificacion = '$cedula_cliente'";
                                                                                    $resultado_nombre_cliente = mysqli_query($link, $sql_nombre_cliente);

                                                                                    if ($resultado_nombre_cliente && mysqli_num_rows($resultado_nombre_cliente) > 0) {
                                                                                        $nombre_cliente = mysqli_fetch_assoc($resultado_nombre_cliente)['Usu_Nombre_completo'];
                                                                                    } else {
                                                                                        $nombre_cliente = $cedula_cliente;
                                                                                    }
                                                                                    ?>
                                                                                    <input type="text" class="form-control form-control-dark" id="cliente-<?php echo $row['Pe_Codigo']; ?>" name="cliente" value="<?php echo $nombre_cliente; ?>" readonly style="background-color: #6c757d; color: #fff; cursor: not-allowed;">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="observacion" class="form-label">Observación</label>
                                                                                    <textarea class="form-control" id="observacion-<?php echo $row['Pe_Codigo']; ?>" name="observacion" rows="3"><?php echo htmlspecialchars($row['Pe_Observacion']); ?></textarea>
                                                                                </div>


                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                            <button type="button" class="btn btn-primary" onclick="guardarCambiosPedido(<?php echo $row['Pe_Codigo']; ?>)">Guardar Cambios</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                    function guardarCambiosPedido(codigo) {
                                                                        var cantidad = document.getElementById('cantidad-' + codigo).value;
                                                                        var precio = document.getElementById('precio-' + codigo).value;
                                                                        var fechaEntrega = document.getElementById('fechaEntrega-' + codigo).value;
                                                                        var fechaPedido = document.getElementById('fechaPedido-' + codigo).value;
                                                                        var estado = document.getElementById('estado-' + codigo).value;
                                                                        var observacion = document.getElementById('observacion-' + codigo).value;

                                                                        var datos = {
                                                                            guardar_cambios_pedido: true, 
                                                                            codigo: codigo,
                                                                            cantidad: cantidad,
                                                                            fechaEntrega: fechaEntrega,
                                                                            fechaPedido: fechaPedido,
                                                                            estado: estado,
                                                                            observacion: observacion
                                                                        };

                                                                        $.ajax({
                                                                            url: 'funcionestabladepedidos.php',
                                                                            type: 'POST',
                                                                            data: datos,
                                                                            success: function(response) {
                                                                                alert(response);

                                                                                $('#editarModal' + codigo).modal('hide');

                                                                                setTimeout(function() {
                                                                                    location.reload();
                                                                                }, 1000);
                                                                            },
                                                                            error: function(xhr, status, error) {
                                                                                alert('Error al guardar los cambios: ' + error);
                                                                            }
                                                                        });
                                                                    }




                                                            </script>
                                                                    <button type="button" class="btn btn-danger" onclick="eliminarPedido(<?php echo $row['Pe_Codigo']; ?>)" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>

                                                                    <div class="modal fade" id="modalConfirmacion_<?php echo $row['Pe_Codigo']; ?>" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar acción</h5>
                                                                                    <button type="button" class="btn-close" aria-label="Close" onclick="cerrarModalConfirmacion(<?php echo $row['Pe_Codigo']; ?>)"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    ¿Estás seguro de que deseas eliminar este pedido?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" onclick="cerrarModalConfirmacion(<?php echo $row['Pe_Codigo']; ?>)">Cancelar</button>
                                                                                    <button type="button" class="btn btn-danger" onclick="confirmarEliminacion(<?php echo $row['Pe_Codigo']; ?>)">Aceptar</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <script>
                                                                        function eliminarPedido(codigoPedido) {
                                                                            // Detener la propagación del evento de clic
                                                                            event.stopPropagation();

                                                                            // Mostrar el modal de confirmación
                                                                            $('#modalConfirmacion_' + codigoPedido).modal('show');
                                                                            
                                                                            // También puedes incluir aquí la lógica para hacer la solicitud AJAX si el usuario confirma la eliminación
                                                                        }

                                                                        function confirmarEliminacion(codigoPedido) {
                                                                            $.ajax({
                                                                                type: 'POST',
                                                                                url: 'funcionestabladepedidos.php',
                                                                                data: { codigo: codigoPedido },
                                                                                success: function(response) {
                                                                                    alert(response);
                                                                                    location.reload();
                                                                                },
                                                                                error: function(xhr, status, error) {
                                                                                    console.error('Error al eliminar el pedido:', error);
                                                                                }
                                                                            });
                                                                        }
                                                                        </script>

                                                                        </div>
                                                                    </td>

                                                            <?php
                                                                }
                                                            } else {
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
