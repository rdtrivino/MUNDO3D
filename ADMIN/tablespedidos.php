
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
<body style="background: linear-gradient(135deg, #2980b9, #2c3e50); color: white;">
<style>
    .modal-content {
        background-color: rgba(255, 255, 255, 0.9) !important; /* Color de fondo */
        color: #000 !important; /* Color del texto */
    }

    .modal-title {
        color: #000 !important;
    }
</style>


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
                            <button type="button" class="btn btn-primary w-100" onclick="generarReportePDF()">
                                <i class="fas fa-file-pdf me-1"></i> Generar Reporte PDF
                            </button>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary w-100" onclick="generarReporteExcel()">
                                <i class="fas fa-file-excel me-1"></i> Generar Reporte Excel
                            </button>
                        </div>
                        <script>
                            function generarReporteExcel() {
                                // Enviar una solicitud AJAX al servidor
                                var xhr = new XMLHttpRequest();
                                xhr.open('GET', 'generar_reporte_excel.php', true);
                                xhr.responseType = 'blob';  // Especificar el tipo de respuesta como blob

                                // Manejar la respuesta
                                xhr.onload = function() {
                                    if (xhr.status === 200) {
                                        // Crear una URL del blob de respuesta
                                        var blob = new Blob([xhr.response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                                        var url = window.URL.createObjectURL(blob);

                                        // Crear un enlace para descargar el archivo Excel y hacer clic en él
                                        var a = document.createElement('a');
                                        a.href = url;
                                        a.download = 'reporte_excel.xlsx';
                                        document.body.appendChild(a);
                                        a.click();

                                        // Limpiar después de la descarga
                                        window.URL.revokeObjectURL(url);
                                        document.body.removeChild(a);
                                    } else {
                                        // Manejar errores
                                        console.error('Error al generar el reporte Excel');
                                    }
                                };

                                // Enviar la solicitud
                                xhr.send();
                            }
                        </script>

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
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#agregarModal">
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
                            <div class="container-fluid px-4" style="padding-top: 20px; padding-bottom: 20px;">
                                <div class="row mt-4">
                                    <div class="col text-center">
                                        <h1 class="display-2 mb-0" style="font-family: 'Arial Black', sans-serif;">PEDIDOS</h1> <!-- Cambiar tamaño del texto y fuente -->
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                <div class="col d-flex justify-content-end">
                                    <div class="col-auto">
                                        <div class="input-group input-group-sm rounded-pill" style="width: 300px;"> <!-- Ajusta el ancho total aquí -->
                                            <span class="input-group-text" id="basic-addon1"> <!-- Espacio adicional para la izquierda -->
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" class="form-control rounded-end" id="searchInput" placeholder="Buscar..." oninput="searchTable()" style="width: 250px;"> <!-- Ajusta el ancho del campo de entrada aquí -->
                                        </div>
                                    </div>
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
                                                        <th>Observación</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $sql_pedidos = "SELECT * FROM pedidos WHERE Pe_Estado <> 'inactivo'";
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
                                                            <td><?php echo $row['Pe_Observacion']; ?></td>
                                                            <td>
                                                            <div class="btn-group" role="group" aria-label="Acciones">
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $identificador; ?>" data-toggle="tooltip" data-placement="top" title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger" onclick="eliminarPedido(<?php echo $row['Identificador']; ?>)" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
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
