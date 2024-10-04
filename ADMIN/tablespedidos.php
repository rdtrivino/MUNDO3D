<!DOCTYPE html>
<html lang="en">
<?php
include __DIR__ . '/../conexion.php';
include ("Programas/controlsesion.php");
?>

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
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />


</head>

<body style="background: linear-gradient(135deg, #2980b9, #2c3e50); color: white;">
    <style>
        .modal-content {
            background-color: rgba(255, 255, 255, 0.9) !important;
            /* Color de fondo */
            color: #000 !important;
            /* Color del texto */
        }

        .modal-title {
            color: #000 !important;
        }
    </style>


    <body class="sb-nav-fixed">
        <?php include 'funcionestabladepedidos.php'; ?>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                    class="fas fa-bars"></i></button>
            <a class="navbar-brand ps-3" href="index.php">ADMINISTRADOR</a>
            <ul class="navbar-nav ms-auto ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombreCompleto; ?><i
                            class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="confi.php">Configuracion de cuenta</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="../Programas/logout.php" id="cerrar-sesion-button">Cerrar
                                sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                INICIO
                            </a>
                            <div class="sb-sidenav-menu-heading">Tablas</div>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                            </div>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas usuarios
                            </a>
                            <a class="nav-link" href="tablesproductos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas Productos
                            </a>
                            <a class="nav-link" href="tablesfacturas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Facturas
                            </a>
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
                        <div class="mb-3 text-center" style="margin-top: 50px;">
                            <h4>PEDIDOS</h4>
                            <div style="max-width: 80%; margin: 0 auto;">
                                <div class="caja-giratoria" style="display: inline-block;">
                                    <img src="..\images\pedidos.png" alt="Pedidos" class="img-fluid gira">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#agregarModal">
                            <i class="fas fa-plus-circle me-1"></i> Agregar Nuevos pedidos
                        </button>

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
                    <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="agregarModalLabel">Agregar Nuevo Pedido</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario para agregar nuevo pedido -->
                                    <form id="formularioAgregarPedido">
                                        <!-- Campo Identificador (oculto) -->
                                        <input type="hidden" id="Identificador" name="Identificador">

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
                                            <input type="number" class="form-control" id="cantidad" name="cantidad"
                                                required>
                                        </div>
                                        <!-- Campo Pe_Fechaentrega -->
                                        <div class="mb-3">
                                            <label for="fechaEntrega" class="form-label">Fecha de Entrega</label>
                                            <input type="date" class="form-control" id="fechaEntrega"
                                                name="fechaEntrega" required>
                                        </div>

                                        <!-- Campo Pe_Fechapedido -->
                                        <div class="mb-3">
                                            <label for="fechaPedido" class="form-label">Fecha de Pedido</label>
                                            <input type="date" class="form-control" id="fechaPedido" name="fechaPedido"
                                                required>
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
                                            <textarea class="form-control" id="observacion" name="observacion" rows="3"
                                                required></textarea>
                                        </div>

                                        <!-- Botones para enviar el formulario y cerrar el modal -->
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                            <button type="submit" class="btn btn-primary">Agregar Pedido</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $('#formularioAgregarPedido').submit(function (event) {
                                // Detener el envío del formulario por defecto
                                event.preventDefault();

                                // Obtener los datos del formulario
                                var formData = $(this).serialize();

                                // Enviar la solicitud AJAX
                                $.ajax({
                                    type: 'POST',
                                    url: 'funcionestabladepedidos.php', // Ruta al script PHP que procesará la solicitud
                                    data: formData,
                                    success: function (response) {
                                        // Manejar la respuesta del servidor
                                        alert(response); // Puedes mostrar un mensaje de éxito o hacer alguna otra acción
                                        $('#agregarModal').modal('hide'); // Cerrar el modal después de agregar el pedido
                                        location.reload(); // Recargar la página para actualizar la tabla de pedidos
                                    },
                                    error: function (xhr, status, error) {
                                        // Manejar los errores
                                        console.error('Error al agregar el pedido:', error);
                                        alert('Error al agregar el pedido. Por favor, inténtalo de nuevo.');
                                    }
                                });
                            });
                        });
                    </script>
                    <div class="container-fluid px-4" style="padding-top: 20px; padding-bottom: 20px;">
                        <div class="row mt-4">
                            <div class="col text-center">
                                <h1 class="display-2 mb-0" style="font-family: 'Arial Black', sans-serif;">PEDIDOS</h1>
                                <!-- Cambiar tamaño del texto y fuente -->
                            </div>
                        </div>
                    <!--boton de busqueda de la tabla-->
                        <div class="col d-flex justify-content-end mt-4 align-items-center">
                            <div class="d-flex justify-content-end ">
                                <div class="input-group input-group-sm rounded-pill" style="width: 300px;">
                                    <span class="input-group-text" id="basic-addon1">
                                     <!-- Ajusta el ancho total aquí -->
                                        <i class="fas fa-search"></i></span>
                                     <!-- Espacio adicional para la izquierda -->
                                    <input type="text" class="form-control rounded-end" id="searchInput"
                                        placeholder="Buscar..." oninput="searchTable()" style="width: 250px;">
                                     <!-- Ajusta el ancho del campo de entrada aquí -->
                                </div>
                            </div>
                        </div>
                    <!--paginacion -->
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <label for="num_registros" class="col-form-label"></label>
                            </div>
                            <div class="col-auto">
                                <select name="num_registros" id="num_registros" class="form-select" onchange="cambiarRegistrosPorPagina()">
                                    <option value="10" <?php if ($registrosPorPagina == 10) echo 'selected'; ?>>10</option>
                                    <option value="25" <?php if ($registrosPorPagina == 25) echo 'selected'; ?>>25</option>
                                    <option value="50" <?php if ($registrosPorPagina == 50) echo 'selected'; ?>>50</option>
                                    <option value="100" <?php if ($registrosPorPagina == 100) echo 'selected'; ?>>100</option>
                                </select>
                            </div>
                        </div>

                        <script>
                            function searchTable() {
                                var input, filter, table, tr, td, i, txtValue;
                                input = document.getElementById("searchInput");
                                filter = input.value.toUpperCase();
                                table = document.getElementById("datatables");
                                tr = table.getElementsByTagName("tr");
                                for (i = 0; i < tr.length; i++) {
                                    // Verifica si es la fila del encabezado
                                    if (tr[i].getElementsByTagName("th").length > 0) {
                                        continue; // Si es el encabezado, pasa a la siguiente fila
                                    }
                                    td = tr[i].getElementsByTagName("td");
                                    var found = false;
                                    for (var j = 0; j < td.length; j++) {
                                        if (td[j]) {
                                            txtValue = td[j].textContent || td[j].innerText;
                                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                found = true;
                                                break;
                                            }
                                        }
                                    }
                                    if (found) {
                                        tr[i].style.display = "";
                                    } else {
                                        tr[i].style.display = "none";
                                    }
                                }
                            }
                        </script>
                        <div class="row mt-4">
                            <div class="col">
                                <div class="table-responsive" style="background-color: #f8f9fa; border-radius: 10px;">
                                    <table id="datatables" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Estado</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Fecha de Entrega</th>
                                                <th>Fecha de Pedido</th>
                                                <th>Cliente</th>
                                                <th>Nombre de Pedido</th>
                                                <th>Imagen</th>
                                                <th>Tipo de Impresión</th>
                                                <th>Color</th>
                                                <th>Observación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $sql_pedidos = "SELECT * FROM pedidos WHERE Acciones <> 'inactivo'";
                                        $resultado_pedidos = mysqli_query($link, $sql_pedidos);

                                        // Verificar si la consulta tuvo éxito
                                        if ($resultado_pedidos && mysqli_num_rows($resultado_pedidos) > 0) {
                                            while ($row = mysqli_fetch_assoc($resultado_pedidos)) {
                                                ?>
                                                <tr id="pedidoRow<?php echo $row['Identificador']; ?>">
                                                    <td><?php echo $row['Identificador']; ?></td>

                                                    <td><?php echo obtenerNombreEstado($row['Pe_Estado'], $link); ?></td>
                                                    <td><?php echo obtenerNombreProducto($row['Pe_Producto'], $link); ?></td>
                                                    <td><?php echo $row['Pe_Cantidad']; ?></td>
                                                    <td><?php echo $row['Pe_Fechaentrega']; ?></td>
                                                    <td><?php echo $row['Pe_Fechapedido']; ?></td>
                                                    <td>
                                                        <?php
                                                        // ID del cliente asociado al pedido
                                                        $id_cliente = $row['Pe_Cliente'];

                                                        // Consulta para obtener el nombre del cliente
                                                        $sql_cliente = "SELECT Usu_Nombre_completo FROM usuario WHERE Usu_Identificacion = ?";
                                                        $stmt_cliente = mysqli_prepare($link, $sql_cliente);
                                                        mysqli_stmt_bind_param($stmt_cliente, "i", $id_cliente);
                                                        mysqli_stmt_execute($stmt_cliente);
                                                        mysqli_stmt_bind_result($stmt_cliente, $nombre_cliente);

                                                        // Recuperar el nombre del cliente
                                                        if (mysqli_stmt_fetch($stmt_cliente)) {
                                                            echo $nombre_cliente;
                                                        } else {
                                                            echo "Cliente desconocido";
                                                        }

                                                        // Cerrar la consulta
                                                        mysqli_stmt_close($stmt_cliente);
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['pe_nombre_pedido']; ?></td>
                                                    <td><img src="<?php echo $row['nombre_imagen']; ?>" height="150px"></td>
                                                    <td><?php echo $row['pe_tipo_impresion']; ?></td>
                                                    <td><?php echo $row['pe_color']; ?></td>
                                                    <td><?php echo $row['Pe_Observacion']; ?></td>
                                                    <td>

                                                        <div class="btn-group" role="group" aria-label="Acciones">

                                                            <!-- Botón Editar en cada fila de la tabla -->
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="abrirModalEditar(<?php echo $row['Identificador']; ?>)"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Editar Pedido">
                                                                <i class="fas fa-edit"></i>
                                                            </button>

                                                            <!-- Modal de Edición -->
                                                            <div class="modal fade"
                                                                id="editarModal<?php echo $row['Identificador']; ?>"
                                                                tabindex="-1"
                                                                aria-labelledby="editarModalLabel<?php echo $row['Identificador']; ?>"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="editarModalLabel<?php echo $row['Identificador']; ?>">
                                                                                Editar Pedido</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Formulario para editar el pedido -->
                                                                            <form
                                                                                id="formularioEditar<?php echo $row['Identificador']; ?>">
                                                                                <div class="row">
                                                                                    <!-- Primera columna -->
                                                                                    <div class="col-md-6">
                                                                                        <!-- Campo Cliente -->
                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                for="pe_cliente_<?php echo $row['Identificador']; ?>"
                                                                                                class="form-label">Cliente</label>
                                                                                            <input type="text"
                                                                                                class="form-control disabled-input"
                                                                                                id="pe_cliente_<?php echo $row['Identificador']; ?>"
                                                                                                name="pe_cliente"
                                                                                                value="<?php echo $row['Pe_Cliente']; ?>"
                                                                                                readonly
                                                                                                title="No se puede editar este campo">
                                                                                        </div>
                                                                                        <!-- Campo Estado -->
                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                for="pe_estado_<?php echo $row['Identificador']; ?>"
                                                                                                class="form-label">Estado</label>
                                                                                            <select class="form-select"
                                                                                                id="pe_estado_<?php echo $row['Identificador']; ?>"
                                                                                                name="pe_estado"
                                                                                                onchange="comprobarEstado('<?php echo $row['Identificador']; ?>')">
                                                                                                <?php
                                                                                                $estados = obtenerEstadosPedidos($link);
                                                                                                foreach ($estados as $estado) {
                                                                                                    $selected = ($row['Pe_Estado'] == $estado['Es_Codigo']) ? 'selected' : '';
                                                                                                    echo "<option value=\"{$estado['Es_Codigo']}\" $selected>{$estado['Es_Nombre']}</option>";
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <!-- Campo Producto -->
                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                for="pe_producto_<?php echo $row['Identificador']; ?>"
                                                                                                class="form-label">Producto</label>
                                                                                            <select class="form-select"
                                                                                                id="pe_producto_<?php echo $row['Identificador']; ?>"
                                                                                                name="pe_producto">
                                                                                                <?php
                                                                                                $productos = obtenerProductos($link);
                                                                                                foreach ($productos as $producto) {
                                                                                                    $selected = ($row['Pe_Producto'] == $producto['Identificador']) ? 'selected' : '';
                                                                                                    echo "<option value=\"{$producto['Identificador']}\" $selected>{$producto['Pro_Nombre']}</option>";
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <!-- Campo Cantidad -->
                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                for="pe_cantidad_<?php echo $row['Identificador']; ?>"
                                                                                                class="form-label">Cantidad</label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="pe_cantidad_<?php echo $row['Identificador']; ?>"
                                                                                                name="pe_cantidad"
                                                                                                value="<?php echo (!empty($row['Pe_Cantidad'])) ? $row['Pe_Cantidad'] : 'No aplica'; ?>">
                                                                                        </div>
                                                                                        <!-- Campo Observaciones -->
                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                for="pe_observaciones_<?php echo $row['Identificador']; ?>"
                                                                                                class="form-label">Observaciones</label>
                                                                                            <textarea class="form-control"
                                                                                                id="pe_observaciones_<?php echo $row['Identificador']; ?>"
                                                                                                name="pe_observaciones"
                                                                                                rows="3"><?php echo (!empty($row['Pe_Observacion'])) ? $row['Pe_Observacion'] : 'No aplica'; ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Segunda columna -->
                                                                                    <div class="col-md-6">
                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                for="pe_fechapedido_<?php echo $row['Identificador']; ?>"
                                                                                                class="form-label">Fecha de
                                                                                                Pedido</label>
                                                                                            <input type="text"
                                                                                                class="form-control datepicker"
                                                                                                id="pe_fechapedido_<?php echo $row['Identificador']; ?>"
                                                                                                name="pe_fechapedido"
                                                                                                value="<?php echo (!empty($row['Pe_Fechapedido'])) ? $row['Pe_Fechapedido'] : ''; ?>">
                                                                                        </div>

                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                for="pe_fechaentrega_<?php echo $row['Identificador']; ?>"
                                                                                                class="form-label">Fecha de
                                                                                                Entrega</label>
                                                                                            <input type="text"
                                                                                                class="form-control datepicker"
                                                                                                id="pe_fechaentrega_<?php echo $row['Identificador']; ?>"
                                                                                                name="pe_fechaentrega"
                                                                                                value="<?php echo (!empty($row['Pe_Fechaentrega'])) ? $row['Pe_Fechaentrega'] : ''; ?>">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                for="pe_color_<?php echo $row['Identificador']; ?>"
                                                                                                class="form-label">Color</label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="pe_color_<?php echo $row['Identificador']; ?>"
                                                                                                name="pe_color"
                                                                                                value="<?php echo (!empty($row['pe_color'])) ? $row['pe_color'] : ''; ?>">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                for="imagen_<?php echo $row['Identificador']; ?>"
                                                                                                class="form-label">Imagen</label>
                                                                                            <input type="file"
                                                                                                class="form-control"
                                                                                                id="imagen_<?php echo $row['Identificador']; ?>"
                                                                                                name="imagen">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Cerrar</button>
                                                                            <button type="button" class="btn btn-primary"
                                                                                onclick="guardarCambios('<?php echo $row['Identificador']; ?>')">Guardar
                                                                                cambios</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <style>
                                                                .disabled-input {
                                                                    background-color: #dcdcdc !important;
                                                                    /* Gris oscuro */
                                                                    color: #333 !important;
                                                                    /* Texto en gris oscuro */
                                                                    pointer-events: none;
                                                                    /* Para deshabilitar cualquier intento de interactuar con el campo */
                                                                }
                                                            </style>

                                                            <script>
                                                                // Función para abrir el modal de edición
                                                                function abrirModalEditar(identificador) {
                                                                    $("#editarModal" + identificador).modal("show");
                                                                    comprobarEstado(identificador);
                                                                }

                                                                // Función para cerrar el modal de edición
                                                                function cerrarModalEditar(identificador) {
                                                                    $("#editarModal" + identificador).modal("hide");
                                                                }

                                                                // Función para guardar cambios
                                                                function guardarCambios(identificador) {
                                                                    // Obtener los valores del formulario
                                                                    var cliente = document.getElementById('pe_cliente_' + identificador).value;
                                                                    var estado = document.getElementById('pe_estado_' + identificador).value;
                                                                    var producto = document.getElementById('pe_producto_' + identificador).value;
                                                                    var cantidad = document.getElementById('pe_cantidad_' + identificador).value;
                                                                    var fechaPedido = document.getElementById('pe_fechapedido_' + identificador).value;
                                                                    var fechaEntrega = document.getElementById('pe_fechaentrega_' + identificador).value;
                                                                    var color = document.getElementById('pe_color_' + identificador).value;
                                                                    var observaciones = document.getElementById('pe_observaciones_' + identificador).value;
                                                                    var imagen = document.getElementById('imagen_' + identificador).files[0];

                                                                    // Crear un objeto FormData para enviar los datos del formulario
                                                                    var formData = new FormData();
                                                                    formData.append('guardar_cambios', true);
                                                                    formData.append('Identificador', identificador);
                                                                    formData.append('Pe_Cliente', cliente);
                                                                    formData.append('Pe_Estado', estado);
                                                                    formData.append('Pe_Producto', producto);
                                                                    formData.append('Pe_Cantidad', cantidad);
                                                                    formData.append('Pe_Fechapedido', fechaPedido);
                                                                    formData.append('Pe_Fechaentrega', fechaEntrega);
                                                                    formData.append('pe_color', color);
                                                                    formData.append('Pe_Observacion', observaciones);
                                                                    formData.append('imagen', imagen);

                                                                    // Realizar la solicitud AJAX
                                                                    var xhr = new XMLHttpRequest();
                                                                    xhr.open("POST", "funcionestabladepedidos.php", true);
                                                                    xhr.onreadystatechange = function () {
                                                                        if (xhr.readyState === 4) {
                                                                            if (xhr.status === 200) {
                                                                                // Mostrar un mensaje de éxito
                                                                                alert("Los cambios se han realizado con éxito.");
                                                                                // Cerrar el modal
                                                                                cerrarModalEditar(identificador);
                                                                                // Recargar la página después de 1 segundo
                                                                                setTimeout(function () {
                                                                                    location.reload();
                                                                                }, 1000);
                                                                            } else {
                                                                                // Mostrar un mensaje de error
                                                                                alert("Ha ocurrido un error al realizar los cambios.");
                                                                            }
                                                                        }
                                                                    };
                                                                    xhr.send(formData);
                                                                }

                                                                // Función para comprobar el estado y deshabilitar campos si es "Entregado"
                                                                function comprobarEstado(identificador) {
                                                                    var estado = document.getElementById('pe_estado_' + identificador).value;
                                                                    var esEditable = (estado !== '5'); // Supongamos que 'ENT' es el valor para el estado "Entregado"

                                                                    // Deshabilitar/enable todos los campos
                                                                    document.querySelectorAll(`#formularioEditar${identificador} input, #formularioEditar${identificador} select, #formularioEditar${identificador} textarea`).forEach(function (element) {
                                                                        element.disabled = !esEditable;
                                                                        if (!esEditable) {
                                                                            element.classList.add('disabled-input');
                                                                        } else {
                                                                            element.classList.remove('disabled-input');
                                                                        }
                                                                    });

                                                                    // Deshabilitar el campo de estado si no es editable
                                                                    document.getElementById(`pe_estado_${identificador}`).disabled = !esEditable;
                                                                }

                                                                // Inicializar Flatpickr para las casillas de fecha
                                                                document.querySelectorAll('.datepicker').forEach(function (el) {
                                                                    flatpickr(el, {
                                                                        dateFormat: 'Y-m-d', // Formato de fecha esperado: Año-Mes-Día
                                                                        allowInput: true,
                                                                        minDate: '2000-01-01', // Fecha mínima permitida: 1 de enero de 2000
                                                                    });
                                                                });
                                                            </script>
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="eliminarPedido(<?php echo $row['Identificador']; ?>)"
                                                                data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            <script>
                                                                function eliminarPedido(identificador) {
                                                                    if (confirm("¿Estás seguro de que deseas eliminar este pedido?")) {
                                                                        // Realizar la solicitud AJAX
                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: 'funcionestabladepedidos.php', // Ruta al script PHP que procesará la solicitud
                                                                            data: { identificador: identificador },
                                                                            success: function (response) {
                                                                                // Manejar la respuesta del servidor
                                                                                alert(response); // Puedes mostrar un mensaje de éxito o hacer alguna otra acción
                                                                                location.reload(); // Recargar la página para actualizar la tabla de pedidos
                                                                            },
                                                                            error: function (xhr, status, error) {
                                                                                // Manejar los errores
                                                                                console.error('Error al eliminar el pedido:', error);
                                                                                alert('Error al eliminar el pedido. Por favor, inténtalo de nuevo.');
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                            </script>

                                                        </div>
                                                    </td>

                                                </tr>


                                                <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='10'>No se pudieron obtener los pedidos.</td></tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    </div>
    </body>
    <?php

    ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
                   <!-- Funciones de paginación -->
                   <ul class="pagination" id="pagination">
                            <?php if ($pagina > 1): ?>
                                <li>
                                    <button onclick="cambiarPagina(<?php echo ($pagina - 1); ?>)">Anterior</button>
                                </li>
                            <?php endif; ?>

                            <?php
                            $totalPaginas = ceil($totalProductos / $registrosPorPagina);
                            $rango = 2; // Mostrar dos páginas antes y después de la actual
                            $inicio = max(1, $pagina - $rango);
                            $fin = min($totalPaginas, $pagina + $rango);
                            ?>

                            <?php if ($inicio > 1): ?>
                                <li>
                                    <button onclick="cambiarPagina(1)">1</button>
                                </li>
                                <?php if ($inicio > 2): ?>
                                    <li>...</li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $inicio; $i <= $fin; $i++): ?>
                                <li>
                                    <button onclick="cambiarPagina(<?php echo $i; ?>)" <?php if ($i == $pagina) echo 'disabled'; ?>><?php echo $i; ?></button>
                                </li>
                            <?php endfor; ?>

                            <?php if ($fin < $totalPaginas): ?>
                                <?php if ($fin < $totalPaginas - 1): ?>
                                    <li>...</li>
                                <?php endif; ?>
                                <li>
                                    <button onclick="cambiarPagina(<?php echo $totalPaginas; ?>)"><?php echo $totalPaginas; ?></button>
                                </li>
                            <?php endif; ?>

                            <?php if ($pagina < $totalPaginas): ?>
                                <li>
                                    <button onclick="cambiarPagina(<?php echo ($pagina + 1); ?>)">Siguiente</button>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <script>
                            function cambiarRegistrosPorPagina() {
                                const registrosPorPagina = document.getElementById('num_registros').value;
                                window.location.href = `?pagina=1&registrosPorPagina=${registrosPorPagina}`;
                            }

                            function cambiarPagina(pagina) {
                                const registrosPorPagina = document.getElementById('num_registros').value;
                                window.location.href = `?pagina=${pagina}&registrosPorPagina=${registrosPorPagina}`;
                            }
                        </script>
            <!--estilos de paginacion-->
            <style>
                    /* Estilos existentes de la paginación */

                    .pagination {
                        display: flex;
                        justify-content: center;
                        list-style: none;
                        padding: 0;
                    }

                    .pagination li {
                        margin: 0 5px;
                    }

                    .pagination button {
                        padding: 5px 10px;
                        cursor: pointer;
                        border: 1px solid #000; /* Borde negro */
                        background-color: #fff; /* Fondo blanco */
                        border-radius: 5px; /* Bordes redondeados */
                    }

                    .pagination button:hover {
                        background-color: #f0f0f0; /* Fondo gris claro al pasar el ratón */
                    }

                    .pagination button:disabled {
                        cursor: not-allowed;
                        background-color: #ddd; /* Fondo gris claro para botones deshabilitados */
                    }
                </style>
                <!--estilos de paginacion-->

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>