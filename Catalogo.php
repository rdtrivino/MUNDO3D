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
    <link href="USUARIO/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="USUARIO/css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="./images/Logo Mundo 3d.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="./css/estilosvisi.css">
</head>

<body>
    <?php include './Programas/starsesion.php'; ?>
    <div class="container-fluid bg-primary py-3">
        <div class="row">
            <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
                <div id="buttons-container" style="display: flex; justify-content: flex-start; align-items: center;">
                    <div id="disabled-icon">
                        <i class="fas fa-wheelchair fa-lg text-white" onclick="aumentarTamano()"
                            onmouseover="cambiarCursor(event)" onmouseout="restaurarCursor()"></i>
                    </div>
                    <button class="font-small" onclick="disminuirTamano()" style="margin-left: 10px;">A</button>
                    <button class="font-medium" onclick="ajustarTamano('medium')" style="margin-left: 10px;">A</button>
                    <button class="font-large" onclick="aumentarTamano()" style="margin-left: 10px;">A</button>
                </div>
            </div>
            <div class="col-md-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center" style="margin-top: -10%;">
                    <img src="images/bxs-user-circle.svg" alt="inicio" id="btnModal" class="hamburguer">
                    <section class="hero__container container">
                        <div id="myModal" class="modalContainer">
                            <form action="Programas/login.php" method="POST">
                                <div class="modal-content">
                                    <span class="close">×</span>
                                    <h2>BIENVENIDOS</h2>
                                    <p><span></span></p><br>
                                    <p><span></span></p><br>
                                    <form onsubmit="return validateForm()">
                                        <div class="form-group">
                                            <label for="username">Correo Electrónico:</label>
                                            <input type="text" id="username" name="username"
                                                placeholder="Ingrese su usuario" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Contraseña:</label>
                                            <div class="password-input-container">
                                                <input type="password" id="password" name="password"
                                                    placeholder="Ingrese su contraseña" required>
                                                <span class="password-toggle-icon" onclick="togglePasswordVisibility()">
                                                    <img src="../MUNDO 3D/images/bxs-show.svg" alt="Mostrar contraseña"
                                                        class="show-password-icon">
                                                    <img src="../MUNDO 3D/images/bxs-low-vision.svg"
                                                        alt="Ocultar contraseña" class="hide-password-icon"
                                                        style="display: none;">
                                                </span>
                                    </form>
                                </div>
                        </div>
                        <div class="form-group forgot-password">
                            <a href="../MUNDO 3D/recovery.html" class="forgot-password-link">¿Olvidó su contraseña?</a>
                        </div>
                        <button type="submit" class="button">Iniciar sesión</button>
                        <div class="form-group forgot-password">
                            <p><span></span></p><br>
                            <hr size="3px" color="black" />
                            <p><span></span></p><br>
                            <a class="forgot-password-link">¿Aún no tienes cuenta?</a>
                        </div>
                        <button type="button" class="registro"
                            onclick="window.location.href='registro.html'">Registrate</button>
                        <div class="form-group forgot-password"></div>
                        </form>
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
                        <a href="Index.html" class="nav-item nav-link">INICIO</a>
                        <a href="Catalogo.php" class="nav-item nav-link">IMPRESORAS</a>
                        <a href="Respuestos.php" class="nav-item nav-link">REPUESTOS</a>
                        <a href="Archivos3dlogin.php" class="nav-item nav-link" id="archivos-3d-link">ARCHIVOS 3D</a>
                        <a href="serviciodeimpresion.php" class="nav-item nav-link"
                            id="Servicio-de-impresión-link">SERVICIO DE IMPRESION</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="page-header container-fluid bg-secondary pt-0 pt-lg-1 pb-1 mb-4">
        <div class="row align-items-center py-4">
            <div class="col-md-9 text-center text-md-right">
                <div class="col-md-6 text-center text-md-left offset-md-0">
                    <div class="InputContainer">
                        <input required="" type="text" id="nombre_producto" class="input"
                            placeholder="Buscar producto..." onkeyup="buscarProducto()">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="background-color: #D3D3D3; margin-top: -70px;">
        <div class="container">
            <h1 class="display-4 text-center mb-5">Explora nuestras impresoras 3D</h1>
            <div class="row row-cols-lg-4 row-cols-md-3 justify-content-center" id="productosContainer">
                <?php
                // Consulta a la base de datos para obtener productos de la categoría 1
                $sql = "SELECT * FROM productos WHERE Pro_Categoria = 1 AND Pro_Estado = 'activo'";
                $result = mysqli_query($link, $sql);

                // Verificar si se encontraron productos en la categoría 1
                if (mysqli_num_rows($result) > 0) {
                    // Iterar sobre los resultados y mostrar cada producto
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col mb-4">
                            <div class="card">
                                <img src="<?php echo substr($row['nombre_imagen'], 3) ?>" class="card-img-top"
                                    style="height: 200px; object-fit: contain;" alt="<?php echo $row['Pro_Nombre']; ?>">

                                <div
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
                    echo "No se encontraron productos en la categoría 1.";
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
    <!-- Footer Start -->
    <div class="container-fluid bg-primary text-white px-sm-3 px-md-5" style="margin-top: auto; margin-bottom: 0;">
        <div class="row pt-5">
            <div class="col-lg-4 col-md-6 mb-5">
                <a href="">
                    <h1 class="text-secondary mb-3"><span class="text-white">MUNDO</span>3D</h1>
                </a>
                <p>¡Adéntrate en un mundo tridimensional como nunca antes! ¡Bienvenid@ nuestra página 3D, donde tus
                    sueños cobran vida!</p>
                <!--redes sociales html-->
                <div class="parent2">
                    <div class="child child-2" data-title="Instagram">
                        <a href="//www.instagram.com/mundo3d.rysj/" target="_blank"
                            rel="noopener noreferrer"><!--ruta de la pagina de instagram-->
                            <button id="button1" class="button btn-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 448 512"
                                    fill="#ff00ff">
                                    <path
                                        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                    </path>
                                </svg>
                        </a>
                        </button>
                    </div>
                    <div class="child child-4" data-title="Facebook">
                        <a href="//www.facebook.com/profile.php?id=61559444922903" target="_blank"
                            rel="noopener noreferrer">
                            <button id="button1" class="button btn-4">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 320 512"
                                    fill="#4267B2">
                                    <path
                                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                                    </path>
                                </svg>
                        </a>
                        </button>
                    </div>
                    <div class="child child-4" data-title="WhatsApp">
                        <a href="https://web.whatsapp.com/" target="_blank" rel="noopener noreferrer">
                            <button id="button1" class="button btn-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 50 548 480" height="1em" fill="#25D366">
                                    <path d="M380.9 97.1c-40.9-40.9-95.8-63.1-154.1-63.1-120.4 0-218.6 98.2-218.6 218.6 0 38.4 9.9 76.4 29 109.7L0 512l151.4-40.2c33.7 18.5 71.3 28.3 110.3 28.3 120.4 0 218.6-98.2 218.6-218.6 0-58.3-23.1-113.1-65.1-155.2zm-154.1 344.3c-33.5 0-66.2-8.8-95.1-25.3l-6.8-4-70.6 18.7 18.8-68.9-4.3-7.1c-18.6-30.3-28.4-65.7-28.4-102.2 0-106.1 86.2-192.3 192.3-192.3 51.4 0 99.8 20 136.1 56.3s56.3 84.7 56.3 136.1c0 106.1-86.2 192.3-192.3 192.3zm101.7-138.7c-5.5-2.7-32.6-16.1-37.7-17.9-5.1-1.8-8.8-2.7-12.5 2.7-3.7 5.5-14.3 17.9-17.6 21.6-3.2 3.7-6.5 4.1-12 1.4-5.5-2.7-23.2-8.5-44.2-27.1-16.4-14.6-27.4-32.7-30.6-38.2-3.2-5.5-.3-8.5 2.4-11.2 2.5-2.6 5.5-6.8 8.2-10.3 2.7-3.7 3.7-6.3 5.5-10.8 1.8-4.5.9-8.2-.5-11.1-1.4-2.7-12.5-30.1-17.1-41.1-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.8-.2-10.3-.2s-9.3 1.3-14.1 6.8c-4.8 5.5-18.6 18.2-18.6 44.5s19.1 51.6 21.8 55.1c2.7 3.7 37.4 57.2 90.7 80.1 12.7 5.5 22.6 8.8 30.3 11.3 12.7 4 24.4 3.4 33.7 2 10.3-1.5 31.6-12.9 36-25.4 4.5-12.5 4.5-23.2 3.2-25.4-1.3-2.3-5-3.7-10.5-6.5z"/>
                                </svg>
                        </a>
                        </button>
                    </div> 
                </div>
                <!--redes sociales html-->
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h4 class="text-white mb-4">Ponerse en contacto</h4>
                <p>Contactanos para tener el gusto de atenderlos.</p>
                <p><i class="fa fa-map-marker-alt mr-2"></i>Calle 15 #31-42 Bogotá, Colombia</p>
                <p><i class="fa fa-envelope mr-2"></i>rdtrivino6@misena.edu.co</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h4 class="text-white mb-4">Enlaces Rápidos</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>INICIO</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>IMPRESORAS</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>REPUESTOS</a>
                    <a class="text-white mb-2" href="#" class="nav-item nav-link"
                    onclick="return confirmarRegistro();"><i class="fa fa-angle-right mr-2"></i>ARCHIVOS 3D</a>
                    <a class="text-white mb-2" href="#" class="nav-item nav-link"
                    onclick="return confirmarRegistro();"><i class="fa fa-angle-right mr-2"></i>SERVICIO DE IMPRESION</a>
                    <script>
                        function confirmarRegistro() {
                            var respuesta = confirm('Para acceder a esta sesión, debes registrarte o iniciar sesión. ¿Deseas hacerlo ahora?');
                            if (respuesta) {
                                // Si el usuario hace clic en "Aceptar", redirige a la página de registro.
                                window.location.href = 'registro.html';
                            }
                            // Si el usuario hace clic en "Cancelar", no pasa nada y se queda en la misma página.
                            return false;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white py-4 px-sm-3 px-md-5">
        <p class="m-0 text-center text-white">
            &copy; <a class="text-white font-weight-medium" href="#">MUNDO 3D</a>. Todos los derechos reservados
            <?php echo date('Y'); ?>
        </p>
    </div>
    <!-- Footer End -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <script src="js/main.js"></script>
    <script src="../MUNDO 3D/js/productosvisi.js"></script>
</body>

</html>