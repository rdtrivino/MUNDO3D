<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>MUNDO3D-USUARIO</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css\misestilos.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="programas/im-pr.css">
</head>

<body>
    <?php include 'programas/funciones-in-re.php'; ?>
    <!-- Topbar Start -->
    <div class="container-fluid bg-primary py-3">
        <div class="row">
            <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
                <!-- Icono de usuario -->
                <div class="d-inline-flex align-items-center">
                    <i class="fas fa-user fa-lg text-white mr-2"></i>
                    <div class="text-white" id="user-name">
                        Bienvenido:
                    </div>
                </div>
            </div>

            </head>

            <body>
                <div class="col-md-6 text-center text-lg-right">
                    <div class="align-items-center">
                        <!-- Botón de hamburguesa para desplegar opciones -->
                        <div class="col-md-6 text-center text-lg-right align-right">
                            <div class="d-inline-flex align-items-center">
                                <!-- Icono de discapacitado -->
                                <div id="buttons-container"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <a href="#" class="font-small text-white font-weight-bold mr-3"
                                        onclick="adjustFontSize('small')">A</a>
                                    <a href="#" class="font-medium text-white font-weight-bold mr-3"
                                        onclick="adjustFontSize('medium')">A</a>
                                    <a href="#" class="font-large text-white font-weight-bold mr-3"
                                        onclick="adjustFontSize('large')">A</a>

                                    <div id="disabled-icon">
                                        <i class="fas fa-wheelchair fa-lg text-white" onclick="aumentarTamano()"
                                            onmouseover="cambiarCursor(event)" onmouseout="restaurarCursor()"></i>
                                    </div>
                                </div>
                                <!-- Menú desplegable -->
                                <div class="dropdown" style="position: relative; white-space: nowrap;">
                                    <div id="dropdown-menu" class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="menu-toggle" style="background-color: black;"> <a
                                            href="confi.php" class="dropdown-menu-item">
                                            <i class="fas fa-cogs"></i> <!-- Icono de configuración -->
                                            Configurar mi cuenta
                                        </a>
                                        <a href="pedidos.php" class="dropdown-menu-item bm-2">
                                            <i class="fas fa-list"></i> <!-- Icono de lista -->
                                            Mis pedidos
                                        </a>
                                        <a href="#" class="dropdown-menu-item" onclick="confirmLogout()">
                                            <i class="fas fa-sign-out-alt fa-lg text-white"></i>
                                            <!-- Icono de cerrar sesión -->
                                            Cerrar Sesión
                                        </a>
                                    </div>
                                    <!-- Icono de barras -->
                                    <button class="btn btn-link" type="button" id="menu-toggle">
                                        <i class="fas fa-bars fa-lg text-white"></i>
                                        <span>Mi menú</span> <!-- Cambia el texto del botón de hamburguesa -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="" class="navbar-brand">
                    <h1 class="m-0 text-secondary"><span class="text-primary">MUNDO</span>3D</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="Catalogologin.php" class="nav-item nav-link">IMPRESORAS</a>
                        <a href="Repuestoslogin.php" class="nav-item nav-link">REPUESTOS</a>
                        <a href="Archivos3dlogin.php" class="nav-item nav-link">ARCHIVOS 3D</a>
                        <a href="serviciodeimpresion.php" class="nav-item nav-link">SERVICIO DE IMPRESION</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
    <div class="page-header container-fluid bg-secondary pt-0 pt-lg-1 pb-1 mb-4">
        <div class="row align-items-center py-4">
            <div class="col-md-6 text-center text-md-left offset-md-0">
                <div class="InputContainer">
                    <input required="" type="text" id="nombre_producto" class="input" placeholder="Buscar producto...">
                </div>
                <div id="resultado_busqueda" class="col-md-6 mt-3"></div>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <a id="carritoBtn" class="btn btn-danger text-white font-weight-bold ml-3 position-relative" href="#"
                    data-toggle="modal" data-target="#carritoModal">
                    <span>Carrito</span>
                    <i class="fas fa-shopping-cart ml-2"></i>
                    <span id="contadorProductos" class="badge badge-light contador-rojo position-absolute">
                        <?php
                        if (isset($_SESSION["user_id"])) {
                            // Obtener el ID del usuario de la sesión
                            $cliente = $_SESSION["user_id"];

                            // Consultar el número de productos en el carrito para el cliente actual
                            $sql = "SELECT COUNT(*) AS total_productos FROM carrito WHERE Pe_Cliente = '$cliente' AND estado_pago = 'pendiente'";
                            $result = mysqli_query($link, $sql);

                            // Verificar si se ejecutó la consulta correctamente
                            if ($result) {
                                // Obtener el resultado de la consulta
                                $row = mysqli_fetch_assoc($result);
                                $totalProductos = $row['total_productos'];

                                // Mostrar el total de productos en el carrito
                                echo $totalProductos;
                            } else {
                                // Mostrar un mensaje de error si la consulta falla
                                echo "Error";
                            }
                        } else {
                            // Si el usuario no está logueado, mostrar 0 productos
                            echo "0";
                        }
                        ?>
                    </span>
                </a>
            </div>
            </span>
            </a>

            <!-- Modal del carrito -->
            <div class="modal fade" id="carritoModal" tabindex="-1" role="dialog" aria-labelledby="carritoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="carritoModalLabel">Contenido del Carrito</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Contenedor para mostrar los productos agregados al carrito -->
                            <div id="carritoContenido">
                                <?php
                                $totalPrecioProductos = 0; // Declarar la variable fuera del bloque condicional y asignarle un valor predeterminado
                                
                                if (isset($_SESSION["user_id"])) {
                                    // Obtener el ID del usuario de la sesión
                                    $cliente = $_SESSION["user_id"];

                                    // Consulta para seleccionar los productos del cliente logueado en estado "pendiente"
                                    $sql = "SELECT carrito.*, 
                                        productos1.Pro_Nombre AS nombre, 
                                        productos1.Pro_PrecioVenta AS precio_venta, 
                                        productos1.nombre_imagen AS nombre_imagen
                                        FROM carrito 
                                        INNER JOIN productos AS productos1 ON carrito.id_producto = productos1.Identificador
                                        WHERE carrito.Pe_Cliente = '$cliente' AND carrito.estado_pago = 'pendiente'";
                                    $result = mysqli_query($link, $sql);

                                    // Contador de productos
                                    $contadorProductos = mysqli_num_rows($result);

                                    // Inicializar el total acumulado del precio de los productos en el carrito
                                    $totalPrecioProductos = 0;

                                    // Verificar si se encontraron productos pendientes
                                    if ($contadorProductos > 0) {
                                        echo '<table class="table table-bordered">';
                                        echo '<thead style="background-color: #f2f2f2;">'; // Cambia el color de fondo de la fila de encabezado
                                        echo '<tr>';
                                        echo '<th style="text-align: center; color: #333;">Nombre del Producto</th>'; // Cambia el color del texto y alinea al centro en la primera columna
                                        echo '<th style="text-align: center; color: #333;">Precio</th>'; // Cambia el color del texto y alinea al centro en la segunda columna
                                        echo '<th style="text-align: center; color: #333;">Imagen</th>'; // Agrega una columna para la imagen
                                        echo '<th style="text-align: center; color: #333;">Cantidad</th>'; // Agrega una columna para la cantidad
                                        echo '<th style="text-align: center; color: #333;">Acciones</th>'; // Agrega una columna para las acciones
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                        // Iterar sobre los resultados y mostrar cada producto en el modal del carrito
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<tr>';
                                            echo '<td style="text-align: left;">' . $row['nombre'] . '</td>';
                                            echo '<td style="text-align: left;">' . $row['precio_venta'] . '</td>';
                                            echo '<td><img height="70px" src=' . $row['nombre_imagen'] . '></td>';
                                            echo '<td style="text-align: center; width: 150px;">
                                            <div class="input-group">
                                                    <button class="btn btn-outline-primary" type="button" data-id="' . $row['id'] . '" data-action="decrement"><i class="fas fa-minus"></i></button>
                                                    <input type="text" class="form-control text-center" value="' . $row['cantidad'] . '" aria-label="Example text with button addon" aria-describedby="button-addon1" disabled>  
                                                    <button class="btn btn-outline-primary" type="button" data-id="' . $row['id'] . '" data-action="increment"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </td>';
                                            // Muestra la cantidad en la tercera columna
                                            echo '<td style="text-align: center;">
                                                <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                            </td>'; // Agrega botones para eliminar productos
                                            echo '</tr>';
                                            // Sumar el precio del producto al total acumulado
                                            $totalPrecioProductos += $row['precio_venta'];
                                        }
                                        echo '</tbody>';
                                        echo '</table>';
                                    } else {
                                        echo "No";
                                    }
                                } else {
                                    echo "El usuario no está logueado.";
                                }
                                ?>
                            </div>
                            <!-- Mostrar el total acumulado del precio de todos los productos -->
                            <div id="totalProductos" style="text-align: right; font-weight: bold; color: blue;">
                                <?php echo "Total a pagar: $" . $totalPrecioProductos; ?>
                            </div>
                            <!-- Cambia el color del texto, lo alinea a la derecha y lo hace negrita -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"
                                style="background-color: red; border-color: red;" onclick="vaciarCarrito()">Vaciar
                                Carrito</button>
                            <button type="button" class="btn btn-primary" id="irAPagarBtn" disabled>Ir a pagar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <div class="container-fluid" style="background-color: #D3D3D3; margin-top: -70px;">
        <div class="container">
            <h1 class="display-4 text-center mb-5">Explora nuestros repuestos 3D</h1>
            <div class="row row-cols-lg-4 row-cols-md-3 justify-content-center">
                <?php
                // Consulta a la base de datos para obtener productos de la categoría 5
                $sql = "SELECT * FROM productos WHERE Pro_Categoria = 1";
                $result = mysqli_query($link, $sql);

                // Verificar si se encontraron productos en la categoría 1b
                if (mysqli_num_rows($result) > 0) {
                    // Iterar sobre los resultados y mostrar cada producto
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col mb-4">
                            <div class="card">
                                <img src="<?php echo $row['nombre_imagen']; ?>" class="card-img-top"
                                    style="height: 200px; object-fit: contain;" alt="<?php echo $row['Pro_Nombre']; ?>">
                                <div class="overlay position-absolute w-100 h-100 d-flex justify-content-center align-items-center"
                                    class="overlay position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
                                    <?php if ($row['Pro_Cantidad'] > 0) { ?>
                                        <a href="#" class="btn btn-primary btn-lg agregarAlCarritoBtn"
                                            data-id="<?php echo $row['Identificador']; ?>"
                                            data-name="<?php echo $row['Pro_Nombre']; ?>"
                                            data-price="<?php echo $row['Pro_PrecioVenta']; ?>"><i class="fas fa-cart-plus"></i></a>
                                    <?php } else { ?>
                                        <button class="btn btn-primary btn-lg agregarAlCarritoBtn" disabled><i
                                                class="fas fa-cart-plus"></i></button>
                                    <?php } ?>
                                    <a href="#" class="btn btn-secondary btn-lg mx-2 detallesBtn" data-toggle="modal"
                                        data-target="#detalleProductoModal" data-id="<?php echo $row['Identificador']; ?>"
                                        data-name="<?php echo $row['Pro_Nombre']; ?>"
                                        data-description="<?php echo $row['Pro_Descripcion']; ?>"
                                        data-price="<?php echo $row['Pro_PrecioVenta']; ?>"
                                        style="background-color: #E42E24;"><i class="fas fa-search"></i></a>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title mb-2"
                                        style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                        <?php echo $row['Pro_Nombre']; ?>
                                    </h5>
                                    <?php if ($row['Pro_Cantidad'] == 0) { ?>
                                        <div class="text-center">
                                            <span style="color: red; font-weight: bold; font-size: 20px;">Agotado</span>
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-center">
                                            <!-- Precio -->
                                            <p class="price mb-0">USD-<?php echo $row['Pro_PrecioVenta']; ?></p>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "No se encontraron productos en la categoría 1b.";
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Modal de detalles del producto -->
    <div class="modal fade" id="detalleProductoModal" tabindex="-1" role="dialog"
        aria-labelledby="detalleProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleProductoModalLabel">Detalles del Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center">
                            <!-- Imagen del producto -->
                            <img id="productoImagen" src="" height="150px"
                                style="border: 1px solid #dddddd; padding: 8px;">
                        </div>
                        <div class="col-md-6">
                            <!-- Descripción y precio del producto -->
                            <h4 id="productoNombre"></h4>
                            <p><strong>Descripción:</strong> <span id="productoDescripcion"></span></p>
                            <p><strong>Precio:</strong> <span id="productoPrecio" class="text-danger"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        style="background-color: #E42E24;">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-primary text-white px-sm-3 px-md-5" style="margin-top: auto; margin-bottom: 0;">
        <div class="row pt-5">
            <div class="col-lg-4 col-md-6 mb-5">
                <a href="">
                    <h1 class="text-secondary mb-3"><span class="text-white">MUNDO</span>3D</h1>
                </a>
                <p>¡Adéntrate en un mundo tridimensional como nunca antes! ¡Bienvenid@ a nuestra página 3D, donde tus
                    sueños cobran vida!</p>
                <!--redes sociales html-->
                <div class="parent2">
                    <div class="child child-2" data-title="Instagram">
                        <a href="https://www.instagram.com/" target="_blank"
                            rel="noopener noreferrer"><!--ruta de la pagina de instagram-->
                            <button id="button1" class="button btn-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                    fill="#ff00ff">
                                    <path
                                        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                    </path>
                                </svg>
                        </a>
                        </button>
                    </div>
                    <div class="child child-4" data-title="Facebook">
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
                            <button id="button1" class="button btn-4">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"
                                    fill="#4267B2">
                                    <path
                                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                                    </path>
                                </svg>
                        </a>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h4 class="text-white mb-4">Ponerse en contacto</h4>
                <p>Contactanos para tener el gusto de atenderlos.</p>
                <p><i class="fa fa-map-marker-alt mr-2"></i>Calle 15 #31-42 Bogotá, Colombia</p>
                <p><i class="fab fa-whatsapp mr-2"></i>3124672836</p>
                <p><i class="fa fa-envelope mr-2"></i>rdtrivino6@misena.edu.co</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h4 class="text-white mb-4">Enlaces Rápidos</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white mb-2" href="Catalogologin.php"><i
                            class="fa fa-angle-right mr-2"></i>CATALOGO</a>
                    <a class="text-white mb-2" href="Repuestoslogin.php"><i
                            class="fa fa-angle-right mr-2"></i>REPUESTOS</a>
                    <a class="text-white mb-2" href="Archivos3dlogin.php"><i class="fa fa-angle-right mr-2"></i>ARCHIVOS
                        3D</a>
                    <a class="text-white" href="serviciodeimpresion.php"><i class="fa fa-angle-right mr-2"></i>SERVICIO
                        DE IMPRESION</a>
                </div>
            </div>
        </div>
    </div>
    <!--redes sociales html-->
    <div class="container-fluid bg-dark text-white py-4 px-sm-3 px-md-5">
        <p class="m-0 text-center text-white">
            &copy; <a class="text-white font-weight-medium" href="#">MUNDO 3D</a>. Todos los derechos reservados
            <?php echo date('Y'); ?>
        </p>
    </div>
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <script src="js/main.js"></script>
    <script src="programas/im-re.js"></script>
</body>

</html>