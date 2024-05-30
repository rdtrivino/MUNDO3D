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
    <link rel="stylesheet" href="./css/normalize.css">
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
            <style>
                .font-small {
                    font-size: 12px;
                    /* Tamaño pequeño */
                }

                .font-medium {
                    font-size: 16px;
                    /* Tamaño mediano */
                }

                .font-large {
                    font-size: 20px;
                    /* Tamaño grande */
                }

                .font-small,
                .font-medium,
                .font-large {
                    background-color: transparent;
                    /* Quitar el fondo */
                    color: white;
                    /* Color de texto blanco */
                    font-weight: bold;
                    /* Negrita */
                }
            </style>
            <script>
                function ajustarTamano(size) {
                    const body = document.body;
                    body.classList.remove('font-small', 'font-medium', 'font-large');

                    switch (size) {
                        case 'small':
                            body.classList.add('font-small');
                            break;
                        case 'medium':
                            body.classList.add('font-medium');
                            break;
                        case 'large':
                            body.classList.add('font-large');
                            break;
                    }
                }

                function disminuirTamano() {
                    ajustarTamano('small'); // Ajusta el tamaño a pequeño
                }

                function aumentarTamano() {
                    const body = document.body;
                    body.classList.remove('font-small', 'font-medium');
                    body.classList.add('font-large'); // Ajusta el tamaño a grande
                }


                function cambiarCursor(event) {
                    event.target.style.cursor = 'pointer';
                }

                function restaurarCursor(event) {
                    event.target.style.cursor = 'default';
                }

            </script>
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
                        <a href="Catalogo.php" class="nav-item nav-link">CATALOGO</a>
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
            <div class="col-md-6 offset-md-6 text-center text-md-right">
                <form class="form-inline">
                    <input class="form-control mr-sm-2 ml-auto" type="search" placeholder="Buscar" aria-label="Buscar"
                        oninput="searchProducts(this.value)">
                    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="background-color: #D3D3D3; margin-top: -50px;">
        <div class="container">
            <h1 class="display-4 text-center mb-5">Explora nuestro Catalogo</h1>
            <div class="row row-cols-lg-4 row-cols-md-3 justify-content-center">
                <?php
                $sql = "SELECT * FROM productos WHERE Pro_Categoria = 1";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col mb-4">
                            <div class="card h-100 position-relative">
                                <?php
                                $imageData = base64_encode($row['imagen_principal']);
                                $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                                ?>
                                <img src="<?php echo $imageSrc; ?>" class="card-img-top"
                                    style="height: 200px; object-fit: cover;" alt="<?php echo $row['Pro_Nombre']; ?>">
                                <div
                                    class="overlay position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
                                    <?php if ($row['Pro_Cantidad'] > 0) { ?>
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
                                        <?php echo $row['Pro_Nombre']; ?></h5>
                                    <?php if ($row['Pro_Cantidad'] == 0) { ?>
                                        <div class="price-box text-center"
                                            style="position: absolute; bottom: 0; left: 0; right: 0;">
                                            <!-- Centra el cuadro del precio -->
                                            <div style="display: inline-block;padding: 5px; border-radius: 5px;">
                                                <!-- Cuadro rojo -->
                                                <span style="color: red; font-weight: bold; font-size: 20px;">Agotado</span>
                                                <!-- Establece el color del texto "Agotado" en rojo y aumenta el tamaño de la fuente -->
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="price-box text-center"
                                            style="position: absolute; bottom: 0; left: 0; right: 0;">
                                            <!-- Centra el cuadro del precio -->
                                            <div style="display: inline-block; padding: 5px; border-radius: 5px;">
                                                <!-- Cuadro rojo -->
                                                <p class="price mb-0" style="color: black;">
                                                    USD-<?php echo $row['Pro_PrecioVenta']; ?></p>
                                                <!-- Establece el color del precio en negro -->
                                            </div>
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
                            <img src="" id="productoImagen" class="img-fluid img-thumbnail mb-3" alt="Producto">
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
                <p>¡Adéntrate en un mundo tridimensional como nunca antes! ¡Bienvenid@ nuestra página 3D, donde tus
                    sueños cobran vida!</p>
                <div class="d-flex justify-content-start mt-4">
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fas fa-times"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
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
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>INICIO</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>CATALOGO</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>REPUESTOS</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>ARCHIVOS 3D</a>
                    <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>SERVICIO DE IMPRESION</a>
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
</body>

</html>