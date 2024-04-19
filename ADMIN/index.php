<?php
        session_start();
        include __DIR__ . '/../conexion.php';

        // Confirmación de que el usuario ha realizado el proceso de autenticación
        if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
            header("Location: ../Programas/autenticacion.php");
            exit(); // Terminamos la ejecución del script después de redirigir
        }

        // Realizamos la consulta para obtener el rol del usuario
        $peticion = "SELECT Usu_rol FROM usuario WHERE Usu_Identificacion = '".$_SESSION['user_id']."'";
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

        // Verificar si el rol del usuario es diferente de 1
        if ($rolUsuario != 1) {
            // Si el rol no es 1, redirigir a la página de autenticación
            header("Location: ../Programas/autenticacion.php");
            exit(); // Terminamos la ejecución del script después de redirigir
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
function obtenerNombreMes($numero_mes) {
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    // Verificar si el índice existe en el array antes de acceder a él
    if (array_key_exists($numero_mes, $meses)) {
        return $meses[$numero_mes];
    } else {
        return 'Mes inválido';
    }
}

// Consulta para obtener la cantidad de pedidos por mes
$sql_pedidos_por_mes = "SELECT MONTH(Pe_Fechapedido) AS Mes, COUNT(*) AS CantidadPedidos
                        FROM pedidos
                        WHERE Pe_Estado <> 'inactivo'
                        GROUP BY MONTH(Pe_Fechapedido)";

// Ejecutar la consulta
$resultado_pedidos_por_mes = mysqli_query($link, $sql_pedidos_por_mes);

// Verificar si la consulta tuvo éxito y si hay al menos un resultado
if ($resultado_pedidos_por_mes && mysqli_num_rows($resultado_pedidos_por_mes) > 0) {
    // Arreglo para almacenar los datos del primer gráfico (doughnut)
    $data1 = [
        'labels' => [],
        'datasets' => [
            [
                'label' => 'Cantidad de Pedidos',
                'data' => [],
                'backgroundColor' => ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                'hoverOffset' => 4
            ]
        ]
    ];

    // Arreglo para almacenar los datos del segundo gráfico (bar)
    $data2 = [
        'labels' => [],
        'datasets' => [
            [
                'label' => 'Cantidad de Pedidos',
                'data' => [],
                'backgroundColor' => 'rgb(54, 162, 235)',
                'borderColor' => 'rgb(54, 162, 235)',
                'borderWidth' => 1
            ]
        ]
    ];

    // Procesar los resultados de la consulta y llenar los arreglos de datos
    while ($row = mysqli_fetch_assoc($resultado_pedidos_por_mes)) {
        // Agregar el mes y la cantidad de pedidos al arreglo de datos del primer gráfico (doughnut)
        $nombre_mes = obtenerNombreMes($row['Mes']); // Función para obtener el nombre del mes
        $data1['labels'][] = $nombre_mes;
        $data1['datasets'][0]['data'][] = $row['CantidadPedidos'];

        // Agregar el mes y la cantidad de pedidos al arreglo de datos del segundo gráfico (bar)
        $data2['labels'][] = $nombre_mes;
        $data2['datasets'][0]['data'][] = $row['CantidadPedidos'];
    }

    // Convertir los arreglos de datos a JSON para utilizarlos en el script de JavaScript
    $data1_json = json_encode($data1);
    $data2_json = json_encode($data2);
} else {
    // Si no hay resultados en la consulta, asignar valores predeterminados
    $data1_json = json_encode(['labels' => [], 'datasets' => []]);
    $data2_json = json_encode(['labels' => [], 'datasets' => []]);
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>MUNDO3D-ADMINISTRADOR</title>
        <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body style="background: linear-gradient(135deg, #2980b9, #2c3e50); color: white;">
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
                        <li><a class="dropdown-item" href="../Programas/logout.php" id="cerrar-sesion-button">Cerrar sesión</a></li>                        
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
                        <div class="mb-3 text-center" style="margin-top: 70px;"> 
                            <div style="max-width: 80%; margin: 0 auto;"> 
                                <div class="caja-giratoria" style="display: inline-block;">
                                    <img src="../images/Logo Mundo 3d.png" alt="Pedidos" class="img-fluid gira">
                                </div>
                            </div>
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
                            <div style="width: 40%; margin: 0 auto; padding: 10px; background-color: #fff; border: 1px solid #ccc; border-radius: 10px;">
                                <canvas id="chart1" width="200" height="200"></canvas>
                            </div>
                            <div style="width: 40%; margin: 20px auto; padding: 10px; background-color: #fff; border: 1px solid #ccc; border-radius: 10px;">
                                <canvas id="chart2" width="200" height="200"></canvas>
                            </div>

                            <script>
                                // Datos para el primer gráfico (doughnut)
                                const data1 = <?php echo $data1_json; ?>;

                                // Configuración para el primer gráfico (doughnut)
                                const config1 = {
                                    type: 'doughnut',
                                    data: data1,
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            title: {
                                                display: true,
                                                text: 'Cantidad de Pedidos por Mes'
                                            }
                                        },
                                    },
                                };

                                // Datos para el segundo gráfico (bar)
                                const data2 = <?php echo $data2_json; ?>;

                                // Configuración para el segundo gráfico (bar)
                                const config2 = {
                                    type: 'bar',
                                    data: data2,
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            title: {
                                                display: true,
                                                text: 'Cantidad de Pedidos por Mes'
                                            }
                                        },
                                    },
                                };

                                // Obtener los contextos de los canvas y dibujar los gráficos
                                var ctx1 = document.getElementById('chart1').getContext('2d');
                                var ctx2 = document.getElementById('chart2').getContext('2d');
                                new Chart(ctx1, config1);
                                new Chart(ctx2, config2);
                            </script>
                        </div>
                        <div class="row mt-4">
                            <div class="container mb-4">
                                <div class="col">
                                    <div class="table-responsive" style="background-color: #f8f9fa; border-radius: 10px;">
                                        <h4 style="text-align: center; color: black;">Lista de Pedidos Nuevos</h4>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_pedidos = "SELECT * FROM pedidos WHERE Pe_Estado = 1 ORDER BY Pe_Fechapedido ASC";
                                                $resultado_pedidos = mysqli_query($link, $sql_pedidos);

                                                // Verificar si la consulta tuvo éxito
                                                if ($resultado_pedidos && mysqli_num_rows($resultado_pedidos) > 0) {
                                                    while ($row = mysqli_fetch_assoc($resultado_pedidos)) {
                                                        ?>
                                                        <tr style="background-color: tomato;">
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
                                                        </tr>
                                                    <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='8'>No se encontraron pedidos en estado 'Nuevo'.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                
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