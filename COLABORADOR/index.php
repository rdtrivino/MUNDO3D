
<!DOCTYPE html>
<!-- http://localhost/MUNDO 3D/COLABORADOR/index.php -->
<html lang="es">
    <?php 
    include __DIR__ . '/../conexion.php';
    include("Programas/controlsesion.php");
    ?>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>COLABORADOR</title>
        <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/all.js" crossorigin="anonymous"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/scripts.js"></script>

    </head>

    <body class="sb-nav-fixed">
        <!--Inicia el codigo de la barra lateral izquierda de navegacion-->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">COLABORADOR</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>        
            <ul class="navbar-nav ms-auto ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown" data-bs-toggle="" aria-expanded="">Bienvenid@ <?php echo $nombreCompleto; ?></a>
                <div>
                    <li><a class="nav-link dropdown" href="Programas/config.php">Configuracion de cuenta</a></li>
                    <li><a class="nav-link dropdown" href="../Programas/logout.php" id="cerrar-sesion-button">Cerrar sesión</a></li>                       
                </div>
            </li>
            </ul>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">PROCESOS</div>
                            <!--Listar las tablas de productos y pedidos-->
                            <?php
                                $peticion = "SHOW TABLES WHERE Tables_in_mundo3d IN ('productos', 'pedidos');";
                                $result = mysqli_query($link, $peticion);

                                while ($fila = $result->fetch_assoc()) {
                                    $nombre_tabla = ucfirst($fila['Tables_in_mundo3d']); // Capitalizar la primera letra
                                    echo '
                                    <li class="nav-item">
                                    <a class="nav-link" href="?tabla='.$fila['Tables_in_mundo3d'].'">
                                        <span data-feather="file"></span>
                                        '.$nombre_tabla.'
                                    </a>
                                    </li>
                                    ';
                                }
                            ?>
                            <!--Listar los reportes requeridos-->
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                <span>REPORTES</span>
                                <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                                    <span data-feather="plus-circle"></span>
                                </a>
                            </h6>
                            <ul class="nav flex-column mb-2">
                                <!--Mostrar todas las vistas creadas la base de datos-->
                                <?php
                                    /*include "../conexion.php";
                                    $peticion = "SHOW FULL TABLES IN mundo3d WHERE TABLE_TYPE LIKE 'VIEW'";
                                        $result = mysqli_query($link, $peticion);
                                        while ($fila = $result->fetch_assoc()){
                                            echo '
                                            <li class="nav-item">
                                            <a class="nav-link" href="#">
                                                <span data-feather="file-text"></span>
                                                '.$fila['Tables_in_mundo3d'].'
                                            </a>
                                            </li>
                                            ';
                                        }*/
                                ?>
                            </ul>   
                        </div>
                    </div>

                    <div class="mb-3 text-center" style="margin-top: 70px;"> 
                        <div style="max-width: 80%; margin: 0 auto;"> 
                            <div class="caja-giratoria" style="display: inline-block;">
                                <img src="../images/Logo Mundo 3d.png" alt="Pedidos" class="img-fluid gira">
                            </div>
                        </div>
                    </div>

                    <div class="sb-sidenav-footer">
                        <div class="small"></div>
                    </div>
                </nav>
            </div>

        <!--Inicia el contenido del cuerpo principal de la pagina-->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!--Definir el titulo de la pagina-->
                        <?php 
                        $titulo = "";

                        if (isset($_GET['tabla'])) { 
                            // Si 'tabla' es 'pedidos', asignar el título correspondiente
                            if ($_GET['tabla'] == 'pedidos'){
                                $titulo = "Gestión de Pedidos";
                            } 
                            // Si 'tabla' es 'productos', asignar el título correspondiente
                            else if ($_GET['tabla'] == 'productos') {
                                $titulo = "Gestión de Productos";
                            }
                        }
                    ?>
                    <?php if (!empty($titulo)): ?>
                        <h1 class="mt-4"><?php echo $titulo; ?></h1>
                    <?php endif; ?>

                        <div class="btn-group mr-2">
                            <!--Si hay una tabla seleccionada mostrar los botones adicionar, exportar e imprimir-->  
                            <?php
                            if (isset($_GET['tabla'])) {
                                echo '<a href="adicionar.php?tabla=' . $_GET['tabla'] . '" class="btn btn-sm btn-outline-secondary">Adicionar registro</a>';
                                echo '<a href="crear_excel.php?tabla=' . $_GET['tabla'] . '" type="button" class="btn btn-sm btn-outline-secondary">Exportar</a>';
                                echo '<a href="crear_pdf.php?tabla=' . $_GET['tabla'] . '" type="button" class="btn btn-sm btn-outline-secondary" target="_blank">Imprimir</a>';
                            }
                            ?>
                        </div>
                         
                    <style>.table-responsive{overflow-x: visible !important;}</style>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                            <!--Mostrar los encabezados de la tabla seleccionada-->
                            <?php  
                                if (isset($_GET['tabla'])) {
                                    $tabla_seleccionada = $_GET['tabla'];
                                    
                                    // Definir encabezados específicos para cada tabla
                                    $encabezados_pedidos = array("ID", "Cliente", "Estado", "Producto", "Cantidad", "Fecha Pedido", "Fecha Entrega", "Imagen", "Tipo", "Color", "Observación", "Editar");
                                    $encabezados_productos = array("ID", "Nombre", "Descripción", "Categoría", "Cantidad", "Precio Venta", "Costo", "Imagen", "Estado", "Editar");
                                    
                                    // Mostrar los encabezados según la tabla seleccionada
                                    if ($tabla_seleccionada === 'pedidos') {
                                        foreach ($encabezados_pedidos as $encabezado) {
                                            echo '<th>' . $encabezado . '</th>';
                                        }
                                    } elseif ($tabla_seleccionada === 'productos') {
                                        foreach ($encabezados_productos as $encabezado) {
                                            echo '<th>' . $encabezado . '</th>';
                                        }
                                    }
                                }
                            ?>
                
                            </tr>
                        </thead>
                        <!--Mostrar contenido de la tabla-->
                        <tbody>
                
                        <?php
                            include __DIR__ . '/../conexion.php';

                            if (isset($_GET['tabla'])) {
                                if ($_GET['tabla'] == 'pedidos') {
                                    $peticion = "SELECT pedidos.*, pedido_estado.Es_Nombre AS Pe_Estado, productos.Pro_Nombre AS Pe_Producto 
                                                FROM pedidos
                                                INNER JOIN pedido_estado ON pedidos.Pe_Estado = pedido_estado.Es_Codigo
                                                INNER JOIN productos ON pedidos.Pe_Producto = productos.Identificador";           
                                    
                                    $result = mysqli_query($link, $peticion);
                                    foreach ($result as $row) {
                                        echo '<tr>
                                            <th scope="row">' . $row['Identificador'] . '</th>
                                            <td>' . $row['Pe_Cliente'] . '</td>
                                            <td>' . $row['Pe_Estado'] . '</td>
                                            <td>' . $row['Pe_Producto'] . '</td>
                                            <td>' . $row['Pe_Cantidad'] . '</td>
                                            <td>' . $row['Pe_Fechapedido'] . '</td>
                                            <td>' . $row['Pe_Fechaentrega'] . '</td>
                                            <td><img height="150px" src=' . $row['nombre_imagen'] . '></td>
                                            <td>' . $row['pe_tipo_impresion'] . '</td>
                                            <td>' . $row['pe_color'] . '</td>
                                            <td>' . $row['Pe_Observacion'] . '</td>
                                            <td><a href="editar.php?tabla=' . $_GET['tabla'] . '&id=' . $row['Identificador'] . '"><i class="fas fa-edit"></i></a></td>
                                            </tr>';
                                    }
                                } elseif ($_GET['tabla'] == 'productos') {
                                    $peticion2 = "SELECT productos.*, categoria.Cgo_Nombre AS Pro_Categoria 
                                                FROM productos
                                                INNER JOIN categoria ON productos.Pro_Categoria = categoria.Cgo_Codigo";
                                    $result = mysqli_query($link, $peticion2);
                                    foreach ($result as $row) {
                                        echo '<tr>
                                            <th scope="row">' . $row['Identificador'] . '</th>
                                            <td>' . $row['Pro_Nombre'] . '</td>
                                            <td>' . $row['Pro_Descripcion'] . '</td>
                                            <td>' . $row['Pro_Categoria'] . '</td>
                                            <td>' . $row['Pro_Cantidad'] . '</td>
                                            <td>' . $row['Pro_PrecioVenta'] . '</td>
                                            <td>' . $row['Pro_Costo'] . '</td>
                                            <td><img height="150px" src=' . $row['nombre_imagen'] . '></td>
                                            <td>' . $row['Pro_Estado'] . '</td>
                                            <td><a href="editar.php?tabla=' . $_GET['tabla'] . '&id=' . $row['Identificador'] . '"><i class="fas fa-edit"></i></a></td>
                                            </tr>';
                                    }
                                }
                                } else {
                                    // Mensaje cuando no se selecciona ninguna tabla
                                    echo '<tr><td colspan="35" style="text-align:center; font-weight: bold;">¿Qué quieres hacer hoy?</td></tr>';
                                }
                        ?>
                        </tbody>
                    </table>       
                    </div>
                        <!--Definicion para incluir o no el calendario-->
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Verifica si se debe mostrar el calendario -->
                                    <?php if (isset($_GET['tabla']) && ($_GET['tabla'] == 'pedidos' || $_GET['tabla'] == 'productos')) { 
                                        $mostrarCalendario = false;
                                    } else {
                                        //Incluir el archivo calendario.php
                                        include('calendario.php');
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <?php
                        // Obtener el año actual
                        $anio = date("Y");
                        ?>
                        <div class="text-muted">Copyright &copy; Mundo3d <?php echo $anio;?></div>
                        <div>
                            <a href="#">Política de privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>   
        </div>
    |</div>
    </body>
</html>