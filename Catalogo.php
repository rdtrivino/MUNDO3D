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
    <!-- SweetAlert2 CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./Programas/css/index.css">
</head>

<body>
    <?php include 'conexion.php'; ?>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <h1 class="m-0">
                <span class="text-dark font-weight-bold">MUNDO</span><span class="text-danger font-weight-bold">3D</span>
            </h1>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">INICIO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Catalogo.php">IMPRESORAS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Repuestos.php">REPUESTOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="checkLogin('Archivos3dlogin.php')">ARCHIVOS 3D</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="checkLogin('serviciodeimpresion.php')">SERVICIO DE IMPRESION</a>
                </li>

                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <div class="cta-buttons">
                        <a href="login.html" class="btn btn-primary">Iniciar sesión</a>
                        <a href="registro.html" class="btn btn-primary">Regístrate</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="page-header container-fluid bg-secondary pt-0 pt-lg-1 pb-1 mb-4">
        <div class="row align-items-center py-4">
            <div class="col-md-9 text-center text-md-right">
                <div class="col-md-6 text-center text-md-left offset-md-0" style="margin-top: 40px;">
                    <div class="InputContainer">
                        <input required="" type="text" id="nombre_producto" class="input"
                            placeholder="Buscar producto..." onkeyup="buscarProducto()">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Agregar un margen superior aquí para separar la sección del nav -->
    <div class="container-fluid" style="background-color: #D3D3D3; margin-top: -30px;">
        <div class="container">
            <h1 class="display-4 text-center mb-5">Explora nuestras impresoras 3D</h1>
            <div class="row row-cols-lg-4 row-cols-md-3 justify-content-center">
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
                                            <p class="price mb-0">COP <?php echo number_format($row['Pro_PrecioVenta'], 2, ',', '.'); ?></p>
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
                            <p><strong>Precio:</strong> <span id="productoPrecio"></span></p>
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
                <a class="text-white font-weight-bold" href="#">Mundo 3D</a>. Todos los derechos reservados.
            </p>
        </div>
    </div>
    <!-- Footer End -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="USUARIO/lib/easing/easing.min.js"></script>
    <script src="USUARIO/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="USUARIO/mail/jqBootstrapValidation.min.js"></script>
    <script src="USUARIO/mail/contact.js"></script>
    <script src="USUARIO/js/main.js"></script>

    <script>
        document.querySelectorAll('.detallesBtn').forEach(button => {
            button.addEventListener('click', function() {
                const name = this.dataset.name;
                const description = this.dataset.description;
                const price = this.dataset.price;
                const imageSrc = this.closest('.card').querySelector('img').src;

                // Actualizar el contenido del modal
                document.getElementById('productoNombre').textContent = name;
                document.getElementById('productoDescripcion').textContent = description;
                document.getElementById('productoPrecio').textContent = new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(price);
                document.getElementById('productoImagen').src = imageSrc;
            });
        });

        function buscarProducto() {
            var input = document.getElementById('nombre_producto').value.toLowerCase();
            var cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                var productName = card.querySelector('.card-title').textContent.toLowerCase();

                if (productName.includes(input)) {
                    card.style.display = ''; // Mostrar el producto
                } else {
                    card.style.display = 'none'; // Ocultar el producto
                }
            });
        }
        // Función de alerta de inicio de sesión
        function checkLogin(targetUrl) {
            var isLoggedIn = false; // Cambia esto según el estado de sesión real

            if (!isLoggedIn) {
                Swal.fire({
                    title: "No has iniciado sesión",
                    text: "Debes iniciar sesión para acceder a esta opción.",
                    icon: "warning",
                    confirmButtonText: "Aceptar"
                });
            } else {
                window.location.href = targetUrl;
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