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
        <link href="css/modal.css" rel="stylesheet" />
        <!--<script src="js/bootstrap.bundle.min.js"></script>-->
        
        </head>

        <body class="">
    <!-- Barra de navegación superior -->
    <nav class="sb-topnav navbar navbar-expand" style="background-color: #3386ff;">
        <!-- Botón de menú para colapsar/expandir la barra lateral izquierda -->
        <button class="btn btn-link btn-sm order-0 order-lg-0" id="sidebarToggle" href="#!" style="color: #e42e24;">
            <i class="fas fa-bars"></i> <!-- Ícono del botón de menú -->
        </button>

        <!-- Título del sistema o sección, "COLABORADOR" -->
        <a class="navbar-brand ps-3" href="index.php" style="color: white;">COLABORADOR</a>

        <!-- Lista de elementos de navegación situados a la derecha -->
        <ul class="navbar-nav ms-auto">
            <!-- Menú desplegable de bienvenida -->
            <li class="nav-item dropdown">
                <a 
                    class="nav-link dropdown-toggle" 
                    href="#" 
                    id="navbarDropdown" 
                    role="button" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false" 
                    style="color: white;"
                >
                    <!-- Contenedor del texto de bienvenida y el nombre del usuario -->
                    <span id="usuarioTexto">
                        Bienvenid@ <span style="color: white;"><?php echo $nombreCompleto; ?></span>
                    </span>
                </a>
                <!-- Opciones del menú desplegable -->
                <ul class="menu-vertical dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <!-- Opción de configuración de cuenta -->
                    <li><a class="dropdown-item" href="confi.php">Configuración de cuenta</a></li>
                    <!-- Opción para cerrar sesión -->
                    <li><a class="dropdown-item" href="../Programas/logout.php" id="cerrar-sesion-button">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <script>
        // Función que obtiene las iniciales de un nombre completo
        function obtenerIniciales(nombreCompleto) {
            return nombreCompleto
                .split(' ') // Divide el nombre en palabras separadas por espacio
                .map(palabra => palabra.charAt(0).toUpperCase()) // Toma la primera letra de cada palabra y la convierte a mayúscula
                .join(''); // Une las iniciales en un solo string
        }

        // Función para ajustar el texto del nombre del usuario según el tamaño de la pantalla
        function ajustarNombreUsuario() {
            // Obtiene el elemento HTML donde se mostrará el nombre
            const usuarioTexto = document.getElementById('usuarioTexto');
            // Obtiene el nombre completo pasado desde PHP
            const nombreCompleto = '<?php echo $nombreCompleto; ?>';

            // Si la pantalla es más pequeña que 768px de ancho
            if (window.innerWidth < 768) {
                // Muestra las iniciales del nombre en lugar del nombre completo
                usuarioTexto.innerHTML = `Bienvenid@ <span style="color: white;">${obtenerIniciales(nombreCompleto)}</span>`;
            } else {
                // Muestra el nombre completo en pantallas más grandes
                usuarioTexto.innerHTML = `Bienvenid@ <span style="color: white;">${nombreCompleto}</span>`;
            }
        }
        // Ejecuta la función al cargar la página
        window.addEventListener('load', ajustarNombreUsuario);
        // Vuelve a ejecutar la función cada vez que se cambia el tamaño de la ventana
        window.addEventListener('resize', ajustarNombreUsuario);
    </script>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <!-- Barra lateral de navegación -->
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- Encabezado de la sección en la barra lateral -->
                        <div class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">PROCESOS</div>
                        <!--Listar las tablas de productos y pedidos-->
                        <?php
                            // Verifica si el entorno es "web"
                            if($entorno == "web"){
                                // Consulta para obtener las tablas específicas en el entorno web
                                $peticion = "SHOW TABLES WHERE Tables_in_u255704174_mundo3d IN ('productos', 'pedidos');";
                                $result = mysqli_query($link, $peticion);// Ejecuta la consulta
                                // Itera sobre los resultados de la consulta
                                while ($fila = $result->fetch_assoc()) {
                                    $nombre_tabla = ucfirst($fila['Tables_in_u255704174_mundo3d']); // Capitalizar la primera letra en Mayscula
                                    // Genera el elemento HTML para cada tabla
                                    echo '
                                    <li class="nav-item">
                                    <a class="nav-link" href="?tabla='.$fila['Tables_in_u255704174_mundo3d'].'">
                                        <span data-feather="file"></span>
                                        '.$nombre_tabla.'
                                    </a>
                                    </li>
                                    ';
                            }// Verifica si el entorno es "local"
                            }elseif($entorno == "local"){
                                // Consulta para obtener las tablas específicas en el entorno local
                                $peticion = "SHOW TABLES WHERE Tables_in_mundo3d IN ('productos', 'pedidos');";
                                $result = mysqli_query($link, $peticion);// Ejecuta la consulta

                                while ($fila = $result->fetch_assoc()) {
                                    $nombre_tabla = ucfirst($fila['Tables_in_mundo3d']); // Capitalizar la primera letra mayuscula
                                    // Genera el elemento HTML para cada tabla
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
                                // Si el entorno no es reconocido, muestra un mensaje de error y detiene la ejecución
                                die('Entorno no reconocido.');
                            }
                        ?>

                    </div>
                </div>
                
                <!--Codigo para establecer logo-->
                <?php
                    $logo = ""; 
                    // Verifica si el parámetro 'tabla' está configurado en la URL y no está vacío
                    if (isset($_GET['tabla']) && $_GET['tabla'] !== "") { 
                        // Si 'tabla' es igual a "productos"
                        if ($_GET['tabla'] == "productos") {
                            // Muestra el título "PRODUCTOS" y una imagen relacionada
                            echo '
                            <h4 style="text-align: center;">PRODUCTOS</h4>
                            <div style="max-width: 70%; margin: 0 auto;">
                                <div class="caja-giratoria" style="display: inline-block;">
                                    <img src="..\images\productos.png" alt="Productos" class="img-fluid gira" style="width: 100%; height: auto;">
                                </div>
                            </div>';
                        } 
                        // Si 'tabla' es igual a "pedidos"
                        else if ($_GET['tabla'] == "pedidos") {
                            // Muestra el título "PEDIDOS" y una imagen relacionada
                            echo '
                            <h4 style="text-align: center;">PEDIDOS</h4>
                            <div style="max-width: 70%; margin: 0 auto;">
                                <div class="caja-giratoria" style="display: inline-block;">
                                    <img src="..\images\pedidos.png" alt="Pedidos" class="img-fluid gira" style="width: 100%; height: auto;">
                                </div>
                            </div>';
                        }
                    } 
                    // Si no se especifica 'tabla' o está vacía
                    else {
                        // Muestra una imagen predeterminada de "Planeación"
                        echo '
                        <div style="max-width: 70%; margin: 0 auto;">
                            <div class="caja-giratoria" style="display: inline-block;">
                                <img src="..\images\planeacion.png" alt="Planeación" class="img-fluid gira" style="width: 100%; height: auto;">
                            </div>
                        </div>';
                    }
                ?>
                <!--Fin codigo para establecer logo-->

                <div class="mb-3 text-center" style="margin-top: 70px;"> 
                    <!-- Contenedor centrado para la imagen con un margen superior -->
                    <div style="max-width: 50%; margin: 0 auto;"> 
                        <!-- Contenedor para aplicar efectos de giro a la imagen -->
                        <div class="caja-giratoria" style="display: inline-block;">
                            <!-- Imagen del logo de Mundo 3D con estilo fluido y efecto de giro -->
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
                            $titulo = "Gestión de Pédidos";
                        } 
                        // Si 'tabla' es 'productos', asignar el título correspondiente
                        else if ($_GET['tabla'] == 'productos') {
                            $titulo = "Gestión de Productos";
                        }
                        }
                    ?>

                    <!-- Seccion para validar la variable titulo y agregar el buscador-->
                    <?php if (!empty($titulo)): ?>
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h1 class="mt-4"><?php echo $titulo; ?></h1>
                        </div>
                    <?php endif; ?>

                    <!--Seccion donde se encuentran los botones adicionar, exportar e imprimir-->
                <div class="btn-group">
                    <?php
                        if (isset($_GET['tabla'])) { 
                            // Botón adicionar dependiendo de tabla
                            if ($_GET['tabla'] == 'productos') {
                                echo '<a href="adicionar.php?tabla=' . $_GET['tabla'] . '" class="btn btn-sm btn-outline-secondary">Adicionar registro</a>';
                            } else if ($_GET['tabla'] == 'pedidos') {
                                echo '<a href="#" class="btn btn-sm btn-outline-secondary" id="openModalBtn">Adicionar registro</a>';
                    ?>
                                <!--Inicio modal seleccion-->
                                <div id="pedidosModal" class="modal">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="centered-title">Selecciona el tipo de pedido que vas a adicionar</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="producto-btn" class="rounded-button">Impresora o repuesto</button>
                                            <button id="impresion-btn" class="rounded-button">Servicio de impresión</button>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="close rounded-button">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                                    
                                    <!--Inicio modal seleccion-->
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            const modal = document.getElementById("pedidosModal");
                                            const openModalBtn = document.getElementById("openModalBtn");
                                            const closeButtons = document.querySelectorAll(".close");

                                            // Función para abrir el modal
                                            openModalBtn.onclick = function () {
                                                modal.style.display = "block";
                                            }

                                            // Función para cerrar el modal
                                            closeButtons.forEach(button => {
                                                button.onclick = function () {
                                                    modal.style.display = "none";
                                                }
                                            });

                                            // Capturar selección de "Producto"
                                            document.getElementById('producto-btn').addEventListener('click', function () {
                                                let tipo = 'producto';
                                                let tabla = '<?php echo $_GET['tabla']; ?>'; 
                                                window.location.href = 'adicionar.php?tabla=' + tabla + '&tipo=' + tipo;
                                            });

                                            // Capturar selección de "Impresión"
                                            document.getElementById('impresion-btn').addEventListener('click', function () {
                                                let tipo = 'impresion';
                                                let tabla = '<?php echo $_GET['tabla']; ?>'; 
                                                window.location.href = 'adicionar.php?tabla=' + tabla + '&tipo=' + tipo;
                                            });

                                            // Cerrar el modal si se hace clic fuera de él
                                            window.onclick = function (event) {
                                                if (event.target === modal) {
                                                    modal.style.display = "none";
                                                }
                                            }
                                        });
                                    </script>
                                    <!--Fin modal seleccion-->

                                    <?php
                                }
                                    echo '<a href="crear_excel.php?tabla=' . $_GET['tabla'] . '" type="button" class="btn btn-sm btn-outline-secondary">Exportar</a>';
                                    echo '<a href="generar_reporte.php?tabla=' . $_GET['tabla'] . '" type="button" class="btn btn-sm btn-outline-secondary" target="_blank">Imprimir</a>'; }
                                    ?>
                    </div>
                    <br>
                        <div class="card mt-4">
                            <div class="card-header">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm" id="table_id">
                                        <thead>
                                            <tr>
                                                <!-- Mostrar los encabezados de la tabla seleccionada -->
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
                                        <!-- Mostrar contenido de la tabla -->
                                        <tbody id="content">
                                                <?php
                                                    // Incluye el archivo de conexión a la base de datos
                                                    include __DIR__ . '/../conexion.php';

                                                    // Verifica si se ha seleccionado una tabla a través del parámetro 'tabla'
                                                    if (isset($_GET['tabla'])) {
                                                        // Si la tabla seleccionada es 'pedidos'
                                                        if ($_GET['tabla'] == 'pedidos') {
                                                            // Consulta para obtener los pedidos con sus estados y productos relacionados
                                                            $peticion = "SELECT pedidos.*, pedido_estado.Es_Nombre AS Pe_Estado, productos.Pro_Nombre AS Pe_Producto 
                                                                    FROM pedidos 
                                                                    INNER JOIN pedido_estado ON pedidos.Pe_Estado = pedido_estado.Es_Codigo
                                                                    INNER JOIN productos ON pedidos.Pe_Producto = productos.Identificador
                                                                    WHERE Pe_Estado NOT IN (4,5,6,7) AND Pe_Usuario = $usuario_id";
                                                            
                                                            // Ejecuta la consulta
                                                            $result = mysqli_query($link, $peticion);

                                                            // Itera sobre cada fila del resultado
                                                            foreach ($result as $row) {
                                                                // Genera las filas de la tabla para los pedidos
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
                                                        } 
                                                        // Si la tabla seleccionada es 'productos'
                                                        elseif ($_GET['tabla'] == 'productos') {
                                                            // Consulta para obtener los productos con sus categorías relacionadas
                                                            $peticion2 = "SELECT productos.*, categoria.Cgo_Nombre AS Pro_Categoria 
                                                                FROM productos
                                                                INNER JOIN categoria ON productos.Pro_Categoria = categoria.Cgo_Codigo
                                                                WHERE productos.Identificador != 1";

                                                            // Ejecuta la consulta
                                                            $result = mysqli_query($link, $peticion2);

                                                            // Itera sobre cada fila del resultado
                                                            foreach ($result as $row) {
                                                                // Genera las filas de la tabla para los productos
                                                                echo '<tr>
                                                                    <th scope="row">' . $row['Identificador'] . '</th>
                                                                    <td>' . $row['Pro_Nombre'] . '</td>
                                                                    <td>' . htmlspecialchars(substr($row['Pro_Descripcion'], 0, 40)) . "... (Editar para ver mas)" . '</td>
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
                                                    } 
                                                    // Si no se selecciona ninguna tabla
                                                    else {
                                                        // Muestra un mensaje indicando que no hay acciones seleccionadas
                                                        echo '<tr><td colspan="35" style="text-align:center; font-weight: bold;">¿Qué quieres hacer hoy?</td></tr>';
                                                    }
                                                ?>
                                        </tbody>
                                    </table> 
                                </div> <!-- final del responsive de la tabla-->
                            </div>
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
        </div>
   </div>
   <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
        </div>
    </div>
</footer>  
</body> 
<script type="text/javascript" src="Librerias/DataTables/js/jquery.dataTables.min.js"></script>
<script src="Librerias/DataTables/js/dataTables.bootstrap4.min.js"></script>
<script src="Librerias/DataTables/js/user.js"></script>
</html>