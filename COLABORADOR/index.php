
<!DOCTYPE html>
<!-- http://localhost/MUNDO 3D/COLABORADOR/colaborador.php -->
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
        <script src="js/all.js" crossorigin="anonymous"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="Librerias/DataTables/js/jquery.min.js"></script>
        <script src="js/scripts.js"></script>
        <link rel="stylesheet" href="./../Librerias/DataTables/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="./../Librerias/DataTables/css/es.css">
        <script src="js/bootstrap.bundle.min.js"></script>
        

    </head>

    <body class="sb-nav-fixed">
        <!--Inicia el codigo de la barra lateral izquierda de navegacion-->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>  
            <a class="navbar-brand ps-3" href="index.php">COLABORADOR</a>

            <ul class="navbar-nav ms-auto ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Bienvenid@ <?php echo $nombreCompleto; ?>
                    </a>
                    <ul class="menu-vertical dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="confi.php">Configuracion de cuenta</a></li>
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
                            <div class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">PROCESOS</div>
                            <!--Listar las tablas de productos y pedidos-->
                            <?php

                                if($entorno == "web"){
                                    $peticion = "SHOW TABLES WHERE Tables_in_u255704174_mundo3d IN ('productos', 'pedidos');";
                                    $result = mysqli_query($link, $peticion);

                                    while ($fila = $result->fetch_assoc()) {
                                        $nombre_tabla = ucfirst($fila['Tables_in_u255704174_mundo3d']); // Capitalizar la primera letra
                                        echo '
                                        <li class="nav-item">
                                        <a class="nav-link" href="?tabla='.$fila['Tables_in_u255704174_mundo3d'].'">
                                            <span data-feather="file"></span>
                                            '.$nombre_tabla.'
                                        </a>
                                        </li>
                                        ';
                                }
                                }elseif($entorno == "local"){
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
                                } else {
                                    die('Entorno no reconocido.');
                                }
                            ?>

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

                        <!-- Seccion para validar la variable titulo y agregar el buscador-->
                        <?php if (!empty($titulo)): ?>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h1 class="mt-4"><?php echo $titulo; ?></h1>

                            </div>
                        <?php endif; ?>

                        <!--Seccion donde se encuentran los botones adicionar, exportar e imprimir-->
                        <div class="btn-group mr-7">
                            <?php

                                if (isset($_GET['tabla'])) { 
                                // Boton adicionar dependiendo de tabla
                                if ($_GET['tabla'] == 'productos'){
                                    echo '<a href="adicionar.php?tabla=' . $_GET['tabla'] . '" class="btn btn-sm btn-outline-secondary">Adicionar registro</a>';
                                } else if ($_GET['tabla'] == 'pedidos') {
                                    echo '<a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#productosModal">Adicionar registro</a>';
                            ?>
                                    <!--Inicio modal seleccion-->
                                        <div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 50%; margin: 5% auto;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="d-flex align-items-center">
                                                            <h5 class="modal-principal-title" id="productosModalLabel">Selecciona el tipo de pédido que vas a adicionar</h5>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="modal-footer">
                                                        <div class="text-start me-auto">
                                                            <button type="button" class="btn btn-primary" id="producto-btn" data-bs-dismiss="modal">Impresora o repuesto</button>
                                                            <button type="button" class="btn btn-primary" id="impresion-btn" data-bs-dismiss="modal">Servicio de impresión</button>
                                                        </div>
                                                        
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {

                                                // Capturar selección de "Producto"
                                                document.getElementById('producto-btn').addEventListener('click', function () {
                                                let tipo = 'producto';
                                                let tabla = '<?php echo $_GET['tabla']; ?>'; // Obtén el valor de tabla
                                                window.location.href = 'adicionar.php?tabla=' + tabla + '&tipo=' + tipo // Aquí puedes hacer algo más con esta variable
                                                });
                                        
                                                // Capturar selección de "Impresión"
                                                document.getElementById('impresion-btn').addEventListener('click', function () {
                                                    let tipo = 'impresion';
                                                    let tabla = '<?php echo $_GET['tabla']; ?>'; // Obtén el valor de tabla
                                                    window.location.href = 'adicionar.php?tabla=' + tabla + '&tipo=' + tipo; // Redirige a la URL
                                                });
                                            });
                                        </script>
                                    <!--Fin modal seleccion-->
    
                                    <?php
                                }
                                    echo '<a href="crear_excel.php?tabla=' . $_GET['tabla'] . '" type="button" class="btn btn-sm btn-outline-secondary">Exportar</a>';
                                    echo '<a href="crear_pdf.php?tabla=' . $_GET['tabla'] . '" type="button" class="btn btn-sm btn-outline-secondary" target="_blank">Imprimir</a>';
                                }
                            ?>
                        </div>
                         
                        <style>.table-responsive{overflow-x: visible !important;}</style>
                        <table class="table table-striped table-sm" id="table_id">
                            <thead>
                                <tr>

                                    <!--Mostrar los encabezados de la tabla seleccionada-->
                                    <?php  
                                        if (isset($_GET['tabla'])) {
                                            $tabla_seleccionada = $_GET['tabla'];
                                            
                                            // Definir encabezados específicos para cada tabla
                                            $encabezados_pedidos = array("ID", "Cliente", "Estado", "Producto", "Cantidad", "F. Pédido", "F. Entrega", "Observación", "Editar");
                                            $encabezados_productos = array("ID", "Nombre", "Descripción", "Categoría", "Cantidad", "P.Venta", "Costo", "Imagen", "Estado", "Editar");
                                            
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
                            <tbody id="content">
                    
                            <?php
                                include __DIR__ . '/../conexion.php';

                                if (isset($_GET['tabla'])) {
                                    if ($_GET['tabla'] == 'pedidos') {
                                        $peticion = "SELECT pedidos.*, pedido_estado.Es_Nombre AS Pe_Estado, productos.Pro_Nombre AS Pe_Producto 
                                                    FROM pedidos 
                                                    INNER JOIN pedido_estado ON pedidos.Pe_Estado = pedido_estado.Es_Codigo
                                                    INNER JOIN productos ON pedidos.Pe_Producto = productos.Identificador
                                                    WHERE Pe_Estado NOT IN (4,5,6,7)";
           
                                        
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
                                                <td>' . $row['Pe_Observacion'] . '</td>
                                                <td><a href="editar.php?tabla=' . $_GET['tabla'] . '&id=' . $row['Identificador'] . '"><i class="fas fa-edit"></i></a></td>
                                                </tr>';
                                        }
                                    } elseif ($_GET['tabla'] == 'productos') {
                                        $peticion2 = "SELECT productos.*, categoria.Cgo_Nombre AS Pro_Categoria 
                                        FROM productos
                                        INNER JOIN categoria ON productos.Pro_Categoria = categoria.Cgo_Codigo
                                        WHERE productos.Identificador != 1";
                                        $result = mysqli_query($link, $peticion2);
                                        foreach ($result as $row) {
                                            echo '<tr>
                                                <th scope="row">' . $row['Identificador'] . '</th>
                                                <td>' . $row['Pro_Nombre'] . '</td>
                                                <td>' . htmlspecialchars(substr($row['Pro_Descripcion'], 0, 40)) . "... (Editar para ver mas)" .'</td>
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
                        </div>
                    </div>
                </footer>   
            </div>
    |   </div>
    </body>
    <script type="text/javascript" src="Librerias/DataTables/js/jquery.dataTables.min.js"></script>
    <script src="Librerias/DataTables/js/dataTables.bootstrap4.min.js"></script>
    <script src="Librerias/DataTables/js/user.js"></script>
</html>
