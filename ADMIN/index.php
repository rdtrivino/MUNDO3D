<?php
    session_start();
    include __DIR__ . '/../conexion.php';
        //Confirmacion de que el usuario ha realizado el proceso de autenticación
        if(!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false){
            //die("No ha iniciado sesión !!!");
            header("Location: ../Programas/autenticacion.php");
        }

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];
$sql = "SELECT Identificador, Pe_Estado, Pe_Producto, Pe_Cantidad,  Pe_Fechaentrega, Pe_Fechapedido, Pe_Cliente, Pe_Observacion FROM pedidos";
$resultado = mysqli_query($link, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($link));
}

function obtenerNombreProducto($codigoProducto, $tu_conexion) {
    // Realiza una consulta SQL para obtener el nombre del producto a partir del código
    $sql = "SELECT pro_nombre FROM productos
     WHERE Identificador = " . $codigoProducto;

    // Ejecuta la consulta
    $resultado = mysqli_query($tu_conexion, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['pro_nombre'];
    } else {
        return "Producto no encontrado";
    }
}
function obtenerNombreEstado($codigoEstado, $tu_conexion) {
    // Realiza una consulta SQL para obtener el nombre del estado a partir del código
    $sql = "SELECT Es_Nombre FROM pedido_estado WHERE Es_Codigo = " . $codigoEstado;

    // Ejecuta la consulta
    $resultado = mysqli_query($tu_conexion, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['Es_Nombre'];
    } else {
        return "Estado no encontrado";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_cambios'])) {
    // Verifica que los campos estén definidos en el formulario
    if (isset($_POST['Identificador'], $_POST['Pe_Estado'], $_POST['Pe_Producto'], $_POST['Pe_Cantidad'], $_POST['Pe_Observacion'], $_POST['Pe_Fechaentrega'], $_POST['cliente'])) {
        $Identificador = $_POST['Identificador'];
        $estado = $_POST['Pe_Estado'];
        $producto = $_POST['Pe_Producto'];
        $cantidad = $_POST['Pe_Cantidad'];
        $observacion = $_POST['Pe_Observacion'];
        $fecha_entrega = $_POST['Pe_Fechaentrega'];
        $cliente = $_POST['cliente'];

        // Validar y escapar los datos para evitar inyección SQL
        $identificador = intval($identificador);
        $estado = intval($estado);
        $cantidad = intval($cantidad);
        $precio = intval($precio);
        // Validar y escapar otros campos según el tipo de dato en la base de datos

        // Realiza una consulta SQL para actualizar los datos en la base de datos
        $sql_actualizar = "UPDATE pedidos
                          SET Identificaror = $identificador, 
                              Pe_Producto = '$producto', 
                              Pe_Cantidad = $cantidad, 
                              Pe_Observacion = '$observacion', 
                              Pe_Fechaentrega = '$fecha_entrega', 
                              Pe_Cliente = $cliente 
                          WHERE Pe_Codigo = $codigo";

        if (mysqli_query($link, $sql_actualizar)) {
            echo "Cambios guardados con éxito.";
        } else {
            echo "Error al guardar los cambios: " . mysqli_error($link);
        }

        // Cierra la conexión a la base de datos
        mysqli_close($link);
    } else {
        echo "Datos del formulario incompletos o incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>MUNDO3D-ADMIN</title>
        <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">ADMINISTRADOR</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>        
            <ul class="navbar-nav ms-auto ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombreCompleto; ?><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="confi.php">Configuracion de cuenta</a></li>
                         <li><hr class="dropdown-divider" /></li>
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
                                Inicio
                            </a>
                            <div class="sb-sidenav-menu-heading">MENU</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Modulos
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../Administrador.html">Catalogo</a>
                                </nav>
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../usuariologincatalogo.php">Repuestos</a>
                                </nav>
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../Administrador.html">Archivos 3D</a>
                                </nav>
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../Administrador.html">Servicio de impresión</a>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Administrar</div>

                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tabla usuarios
                            </a>
                            <a class="nav-link" href="tablespedidos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tabla Pedidos
                            </a>
                            <a class="nav-link" href="tablesproductos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tabla Productos
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"></div>
                        Mundo 3D
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">MUNDO 3D</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">PANEL DE CONTROL </li>
                        </ol>
                        <div class="row justify-content-around">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">stock lleno</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a id="verDetallesLink" class="small text-white stretched-link" href="#" onclick="cargarProductos()">Ver Detalles</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 90%; margin: 5% auto;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="d-flex align-items-center">
                                            <img class="logo" src="../images/Logo Mundo 3d.png" alt="Logo de la empresa" style="max-width: 100px;"><br/>
                                            <h5 class="modal-title" id="stockMedioModalLabel">Productos con stock lleno</h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table" id="productosTable">
                                            <!-- Aquí se mostrarán los detalles de los productos -->
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                        <script>
                                            function cargarProductos() {
                                                $.ajax({
                                                    url: 'stocklleno.php',  
                                                    type: 'GET',
                                                    success: function(data) {
                                                        $('#productosTable').html(data);  
                                                        $('#productosModal').modal('show'); 
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error(xhr.responseText); 
                                                    }
                                                });
                                            }
                                        </script>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">stock medio</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" data-bs-toggle="modal" data-bs-target="#stockMedioModal" onclick="cargarProductosStockMedio()">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para mostrar los productos con stock medio -->
                            <div class="modal fade" id="stockMedioModal" tabindex="-1" aria-labelledby="stockMedioModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 90%; margin: 5% auto;">
                                    <div class="modal-content">
                                        <!-- Encabezado del modal con el logo y el texto "Stock medio" -->
                                        <div class="modal-header">
                                            <div class="d-flex align-items-center">
                                                <img class="logo" src="../images/Logo Mundo 3d.png" alt="Logo de la empresa" style="max-width: 100px;"><br/>
                                                <h5 class="modal-title" id="stockMedioModalLabel">Productos con stock medio</h5>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Agregamos el botón de cierre -->
                                        </div>
                                        <div class="modal-body">
                                            <!-- Aquí se mostrará la tabla de productos -->
                                            <table class="table" id="stockMedioTable">
                                                <!-- La tabla de productos se insertará aquí dinámicamente -->
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Script para cargar los productos con stock medio -->
                            <script>
                                function cargarProductosStockMedio() {
                                    var xhr = new XMLHttpRequest();
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState == 4 && xhr.status == 200) {
                                            document.getElementById("stockMedioTable").innerHTML = xhr.responseText;
                                        }
                                    };
                                    xhr.open("GET", "stockmedio.php", true);
                                    xhr.send();
                                }
                            </script>

                            <!-- Coloca este código donde quieras que aparezca el botón de "Ver Detalles" -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">stock vacio</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" data-bs-toggle="modal" data-bs-target="#stockVacioModal">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para mostrar los productos con stock vacío -->
                            <div class="modal fade" id="stockVacioModal" tabindex="-1" aria-labelledby="stockVacioModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 90%; margin: 5% auto;">
                                    <div class="modal-content">
                                        <!-- Encabezado del modal con el logo y el texto "Stock vacío" -->
                                        <div class="modal-header">
                                            <div class="d-flex align-items-center">
                                                <img class="logo" src="../images/Logo Mundo 3d.png" alt="Logo de la empresa" style="max-width: 100px;"><br/>
                                                <h5 class="modal-title" id="stockVacioModalLabel">Productos con stock vacío</h5>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Aquí se mostrará la tabla de productos -->
                                            <table class="table" id="stockVacioTable">
                                                <!-- La tabla de productos se insertará aquí dinámicamente -->
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Coloca este script en el lugar apropiado en tu página -->
                            <script>
                                // Llamar a la función para cargar los productos con stock vacío al cargar la página
                                window.onload = function() {
                                    cargarProductosStockVacio();
                                };

                                function cargarProductosStockVacio() {
                                    var xhr = new XMLHttpRequest();
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState == 4 && xhr.status == 200) {
                                            document.getElementById("stockVacioTable").innerHTML = xhr.responseText;
                                        }
                                    };
                                    xhr.open("GET", "stockvacio.php", true);
                                    xhr.send();
                                }
                            </script>


                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        VENTAS ULTIMO AÑO
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        VENTAS ULTIMO AÑO
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                        <div class="card-body">
                        <table id="datatablesSimple" class="table">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($resultado)) {
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
                                        </td>
                                        </tr>

                                            </div>
                                        </div>
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
                            <div class="text-muted">Copyright &copy; Mundo3d 2023</div>
                            <div>
                                <a href="#">politica de privacidad</a>
                                &middot;
                                <a href="#">Terminos &amp; Condiciones</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>