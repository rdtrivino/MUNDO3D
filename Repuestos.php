<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>MUNDO3D-USUARIO</title> <!-- Título de la página -->
    <meta content="width=device-width, initial-scale=1.0" name="viewport"> <!-- Configuración del viewport para dispositivos móviles -->
    <meta content="Free HTML Templates" name="keywords"> <!-- Palabras clave para SEO -->
    <meta content="Free HTML Templates" name="description"> <!-- Descripción de la página para SEO -->
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon"> <!-- Icono de la página -->
    <link rel="preconnect" href="https://fonts.gstatic.com"> <!-- Preconexión para mejorar la carga de fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;800&display=swap" rel="stylesheet"> <!-- Fuentes de Google -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet"> <!-- Estilos de Font Awesome para íconos -->
    <link href="USUARIO/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet"> <!-- Estilo para el carrusel de imágenes -->
    <link href="USUARIO/css/style.css" rel="stylesheet"> <!-- Estilos personalizados de la aplicación -->
    <link rel="shortcut icon" href="./images/Logo Mundo 3d.png" type="image/x-icon"> <!-- Icono de la página -->
    <link rel="stylesheet" href="../css/normalize.css"> <!-- Normalización de estilos CSS -->
    <link rel="stylesheet" type="text/css" href="./css/estilosvisi.css"> <!-- Estilos adicionales para la visualización -->
    <!-- Alerta de "SweetAlert2" CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" /> <!-- CSS para alertas -->

    <!-- Alerta de "SweetAlert2" JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- JS para alertas -->
    <link rel="stylesheet" href="./Programas/css/index.css"> <!-- Estilos para la sección de programas -->
</head>

<body>
    <?php include 'conexion.php'; ?> <!-- Incluye el archivo de conexión a la base de datos -->

    <!-- Funcionalidad del Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light"> <!-- Barra de navegación -->
        <a class="navbar-brand" href="#">
            <h1 class="m-0">
                <span class="text-dark font-weight-bold">MUNDO</span><span class="text-danger font-weight-bold">3D</span>
            </h1>
        </a>
        <!-- Botón para colapsar el menú en pantallas pequeñas -->
        <button
            class="navbar-toggler" 
            type="button"
            data-toggle="collapse"
            data-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> <!-- Icono del botón de menú -->
        </button>
        <div class="collapse navbar-collapse" id="navbarNav"> <!-- Contenido colapsable del navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">INICIO</a> <!-- Enlace a la página de inicio -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Catalogo.php">IMPRESORAS</a> <!-- Enlace al catálogo de impresoras -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Repuestos.php">REPUESTOS</a> <!-- Enlace a la sección de repuestos -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="checkLogin('Archivos3dlogin.php')">ARCHIVOS 3D</a> <!-- Enlace a archivos 3D -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="checkLogin('serviciodeimpresion.php')">SERVICIO DE IMPRESION</a> <!-- Enlace al servicio de impresión -->
                </li>
            </ul>
            <ul class="navbar-nav"> <!-- Botones de inicio de sesión y registro -->
                <li class="nav-item">
                    <div class="cta-buttons">
                        <a href="login.html" class="btn btn-primary">Iniciar sesión</a> <!-- Botón de inicio de sesión -->
                        <a href="registro.html" class="btn btn-primary">Regístrate</a> <!-- Botón de registro -->
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Funcionalidad del buscador de productos de repuestos -->
    <div class="page-header container-fluid bg-secondary pt-0 pt-lg-1 pb-1 mb-4">
        <div class="row align-items-center py-4">
            <div class="col-md-9 text-center text-md-right">
                <div class="col-md-6 text-center text-md-left offset-md-0" style="margin-top: 40px;">
                    <div class="InputContainer">
                        <input required="" type="text" id="nombre_producto" class="input"
                            placeholder="Buscar producto..." onkeyup="buscarProducto()"> <!-- Campo de búsqueda de productos -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de productos -->
    <div class="container-fluid" style="background-color: #D3D3D3; margin-top: -30px;">
        <div class="container">
            <h1 class="display-4 text-center mb-5">Explora nuestros Repuestos</h1> <!-- Título de la sección -->
            <div class="row row-cols-lg-4 row-cols-md-3 justify-content-center">
                <?php
                // Consulta a la base de datos para obtener productos de la categoría 2
                $sql = "SELECT * FROM productos WHERE Pro_Categoria = 2 AND Pro_Estado = 'activo'";
                $result = mysqli_query($link, $sql);

                // Verificar si se encontraron productos
                if (mysqli_num_rows($result) > 0) {
                    // Iterar sobre los resultados y mostrar cada producto
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="col mb-4">
                            <div class="card">
                                <img src="<?php echo substr($row['nombre_imagen'], 3) ?>" class="card-img-top"
                                    style="height: 200px; object-fit: contain;" alt="<?php echo $row['Pro_Nombre']; ?>"> <!-- Imagen del producto -->

                                <div
                                    class="overlay position-absolute w-100 h-100 d-flex justify-content-center align-items-center"> <!-- Capa superpuesta para botones -->
                                    <?php if ($row['Pro_Cantidad'] > 0) { ?>
                                        <a href="#" class="btn btn-primary btn-lg agregarAlCarritoBtn"
                                            data-id="<?php echo $row['Identificador']; ?>"
                                            data-name="<?php echo $row['Pro_Nombre']; ?>"
                                            data-price="<?php echo $row['Pro_PrecioVenta']; ?>"><i class="fas fa-cart-plus"></i></a> <!-- Botón para agregar al carrito -->
                                    <?php } else { ?>
                                        <button class="btn btn-primary btn-lg agregarAlCarritoBtn" disabled><i
                                                class="fas fa-cart-plus"></i></button> <!-- Botón deshabilitado si el producto está agotado -->
                                    <?php } ?>
                                    <a href="#" class="btn btn-secondary btn-lg mx-2 detallesBtn" data-toggle="modal"
                                        data-target="#detalleProductoModal" data-id="<?php echo $row['Identificador']; ?>"
                                        data-name="<?php echo $row['Pro_Nombre']; ?>"
                                        data-description="<?php echo $row['Pro_Descripcion']; ?>"
                                        data-price="<?php echo $row['Pro_PrecioVenta']; ?>"
                                        style="background-color: #E42E24;"><i class="fas fa-search"></i></a> <!-- Botón para ver detalles del producto -->
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title mb-2"
                                        style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                        <?php echo $row['Pro_Nombre']; ?> <!-- Nombre del producto -->
                                    </h5>
                                    <?php if ($row['Pro_Cantidad'] == 0) { ?>
                                        <div class="text-center">
                                            <span style="color: red; font-weight: bold; font-size: 20px;">Agotado</span> <!-- Mensaje si el producto está agotado -->
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-center">
                                            <!-- Precio -->
                                            <p class="price mb-0">COP <?php echo number_format($row['Pro_PrecioVenta'], 2, ',', '.'); ?></p> <!-- Precio del producto -->
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "No se encontraron productos en la categoría 1."; // Mensaje si no hay productos
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal de detalles de cada producto -->
    <div class="modal fade" id="detalleProductoModal" tabindex="-1" role="dialog"
        aria-labelledby="detalleProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleProductoModalLabel">Detalles del Producto</h5> <!-- Título del modal -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span> <!-- Botón para cerrar el modal -->
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center">
                            <!-- Imagen del producto -->
                            <img id="productoImagen" src="" height="150px"
                                style="border: 1px solid #dddddd; padding: 8px;"> <!-- Imagen que se muestra en el modal -->
                        </div>
                        <div class="col-md-6">
                            <!-- Descripción y precio del producto -->
                            <h4 id="productoNombre"></h4> <!-- Nombre del producto -->
                            <p><strong>Descripción:</strong> <span id="productoDescripcion"></span></p> <!-- Descripción del producto -->
                            <p><strong>Precio:</strong> <span id="productoPrecio"></span></p> <!-- Precio del producto -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white py-3">
        <div class="container text-center">
            <p class="m-0">
                &copy;
                <a class="text-white font-weight-bold" href="#">Mundo 3D</a>. Todos los derechos reservados. <!-- Mensaje de derechos de autor -->
            </p>
        </div>
    </div>
    <!-- Footer End -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> <!-- Biblioteca jQuery -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script> <!-- Biblioteca Bootstrap -->
    <script src="USUARIO/lib/easing/easing.min.js"></script> <!-- Biblioteca para animaciones -->
    <script src="USUARIO/lib/owlcarousel/owl.carousel.min.js"></script> <!-- Biblioteca para carruseles -->
    <script src="USUARIO/mail/jqBootstrapValidation.min.js"></script> <!-- Validación de formularios -->
    <script src="USUARIO/mail/contact.js"></script> <!-- Script para contacto -->
    <script src="USUARIO/js/main.js"></script> <!-- Script principal -->

    <script>
        // Evento listener para mostrar los detalles del producto en el modal
        document.querySelectorAll('.detallesBtn').forEach(button => {
            button.addEventListener('click', function() {
                const name = this.dataset.name; // Obtiene el nombre del producto
                const description = this.dataset.description; // Obtiene la descripción del producto
                const price = this.dataset.price; // Obtiene el precio del producto
                const imageSrc = this.closest('.card').querySelector('img').src; // Obtiene la imagen del producto

                // Actualiza el contenido del modal
                document.getElementById('productoNombre').textContent = name; // Actualiza el nombre
                document.getElementById('productoDescripcion').textContent = description; // Actualiza la descripción
                document.getElementById('productoPrecio').textContent = new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(price); // Formatea el precio
                document.getElementById('productoImagen').src = imageSrc; // Actualiza la imagen
            });
        });

        // Función para buscar productos en la lista
        function buscarProducto() {
            var input = document.getElementById('nombre_producto').value.toLowerCase(); // Obtiene el valor de búsqueda
            var cards = document.querySelectorAll('.card'); // Selecciona todas las tarjetas de producto

            cards.forEach(card => {
                var productName = card.querySelector('.card-title').textContent.toLowerCase(); // Obtiene el nombre del producto en la tarjeta

                // Muestra u oculta la tarjeta según la búsqueda
                if (productName.includes(input)) {
                    card.style.display = ''; // Muestra el producto si se encuentra
                } else {
                    card.style.display = 'none'; // Oculta el producto si no se encuentra
                }
            });
        }

        // Función de alerta de inicio de sesión
        function checkLogin(targetUrl) {
            var isLoggedIn = false; // Cambia esto según el estado de sesión real

            // Muestra un mensaje de alerta si el usuario no ha iniciado sesión
            if (!isLoggedIn) {
                Swal.fire({
                    title: "No has iniciado sesión", // Título de la alerta
                    text: "Debes iniciar sesión para acceder a esta opción.", // Mensaje de alerta
                    icon: "warning", // Icono de advertencia
                    confirmButtonText: "Aceptar" // Texto del botón de confirmación
                });
            } else {
                window.location.href = targetUrl; // Redirige a la URL destino si está conectado
            }
        }

        // Añadir event listeners a los botones de agregar al carrito
        document.querySelectorAll('.agregarAlCarritoBtn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Evita la acción predeterminada
                var targetUrl = ''; // Puedes definir la URL de destino o dejarlo vacío si no se redirige
                checkLogin(targetUrl); // Llama a la función de alerta
            });
        });
    </script>

</body>

</html>