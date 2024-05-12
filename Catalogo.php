<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$link = mysqli_connect($host, $user, $password);

if (!$link) {
    die("Error al conectarse al servidor: " . mysqli_connect_error());
}

if (!mysqli_select_db($link, $dbname)) {
    die("Error al conectarse a la Base de Datos: " . mysqli_error($link));
}


// Consulta a la base de datos para obtener productos de la categoría 5
$sql = "SELECT * FROM productos WHERE Pro_Categoria = 1";
$result = mysqli_query($link, $sql);

?>
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
</head>

<body>
<!-- Topbar Start -->
<div class="container-fluid bg-primary py-3">
    <div class="row">
        <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
            </div>
        </div>
        <div class="col-md-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
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
                        <a href="serviciodeimpresion.php" class="nav-item nav-link" id="Servicio-de-impresión-link">SERVICIO DE IMPRESION</a>
                <script>
                function mostrarAviso() {
                    var confirmacion = confirm("Para acceder a esta sesión, debes registrarte o iniciar sesión. ¿Deseas hacerlo ahora?");
                
                    if (confirmacion) {
                        window.location.href = "registro.html";
                    }
                }
                
                var archivos3dLink = document.getElementById("archivos-3d-link");
                archivos3dLink.addEventListener("click", function (event) {
                    event.preventDefault();
                    mostrarAviso();
                });</script>
                
                <script>
                function mostrarAviso() {
                    var confirmacion = confirm("Para acceder a esta sesión, debes registrarte o iniciar sesión. ¿Deseas hacerlo ahora?");
                    
                    if (confirmacion) {
                        window.location.href = "registro.html";
                    }
                }

                var servicioImpresionLink = document.getElementById("Servicio-de-impresión-link");
                servicioImpresionLink.addEventListener("click", function (event) {
                    event.preventDefault();
                    mostrarAviso();
                });
                </script>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <div class="page-header container-fluid bg-secondary pt-2 pt-lg-5 pb-2 mb-5">
    <div class="container py-5">
        <div class="row align-items-center py-4">
            <div class="col-md-6 text-center text-md-left">
                <h1 class="mb-4 mb-md-0 text-white">CATÁLOGO</h1>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <div class="d-inline-flex align-items-center">
                    <form class="form-inline mr-3">
                        <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" oninput="searchProducts(this.value)">
                        <!-- Cambiar el evento a "input" para que se ejecute cada vez que se ingresa una letra -->
                        <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function searchProducts(searchTerm) {
                // Obtener todos los elementos de productos
                var products = document.querySelectorAll('.product');
                
                // Convertir el término de búsqueda a mayúsculas para hacer una comparación insensible a mayúsculas y minúsculas
                searchTerm = searchTerm.toUpperCase();
                
                // Iterar sobre todos los productos
                products.forEach(function(product) {
                    // Obtener el nombre del producto
                    var productName = product.querySelector('.card-title').textContent.toUpperCase();
                    
                    // Obtener la descripción del producto
                    var productDescription = product.querySelector('.card-text').textContent.toUpperCase();
                    
                    // Comprobar si el término de búsqueda está presente en el nombre o la descripción del producto
                    if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                        // Mostrar el producto si coincide con el término de búsqueda
                        product.style.display = 'block';
                    } else {
                        // Ocultar el producto si no coincide con el término de búsqueda
                        product.style.display = 'none';
                    }
                });
            }
        </script>
<!-- Catalog Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <h1 class="display-4 text-center mb-5">Explora nuestro catálogo</h1>
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
                    <div class="card h-100 position-relative">
                        <?php
                        // Convertir la imagen binaria a una URL de imagen
                        $imageData = base64_encode($row['imagen_principal']);
                        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                        ?>
                        <img src="<?php echo $imageSrc; ?>" class="card-img-top" alt="<?php echo $row['Pro_Nombre']; ?>">
                        <div class="overlay position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
                            <?php if ($row['Pro_Cantidad'] > 0) { ?>
                            <?php } ?>
                            <a href="#" class="btn btn-secondary btn-lg mx-2 detallesBtn" data-toggle="modal" data-target="#detalleProductoModal" data-id="<?php echo $row['Identificador']; ?>" data-name="<?php echo $row['Pro_Nombre']; ?>" data-description="<?php echo $row['Pro_Descripcion']; ?>" data-price="<?php echo $row['Pro_PrecioVenta']; ?>"><i class="fas fa-search"></i></a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['Pro_Nombre']; ?></h5>
                            <p class="card-text"><?php echo $row['Pro_Descripcion']; ?></p>
                            <?php if ($row['Pro_Cantidad'] == 0) { ?>
                                <p class="text-danger lead">Agotado</p>
                            <?php } else { ?>
                                <div class="price-box">
                                    <p class="price"><?php echo $row['Pro_PrecioVenta']; ?></p>
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
<div class="modal fade" id="detalleProductoModal" tabindex="-1" role="dialog" aria-labelledby="detalleProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleProductoModalLabel">Detalles del Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detalleProductoBody">
                <!-- Aquí se cargarán los detalles del producto -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var detallesBtns = document.querySelectorAll('.detallesBtn');

        detallesBtns.forEach(function(btn) {
            btn.addEventListener('click', function(event) {
                event.preventDefault();
                var productId = this.getAttribute('data-id');
                var productName = this.getAttribute('data-name');
                var productDescription = this.getAttribute('data-description');
                var productPrice = this.getAttribute('data-price');
                var productImage = this.closest('.card').querySelector('.card-img-top').getAttribute('src');

                cargarDetallesProducto(productName, productDescription, productPrice, productImage);
            });
        });
    });

    function cargarDetallesProducto(productName, productDescription, productPrice, productImage) {
        var modalBody = document.getElementById('detalleProductoBody');
        modalBody.innerHTML = `
            <img src="${productImage}" class="img-fluid mb-3" alt="${productName}">
            <h4>${productName}</h4>
            <p><strong>Descripción:</strong> ${productDescription}</p>
            <p><strong>Precio:</strong> $${productPrice}</p>`;
        $('#detalleProductoModal').modal('show');
    }
</script>
            <style>
                /* Estilo para la superposición */
            .overlay {
                background-color: rgba(0, 0, 0, 0.5);
                opacity: 0;
                transition: opacity 0.3s;
            }

            /* Estilo para mostrar la superposición al pasar el mouse */
            .card:hover .overlay {
                opacity: 1;
            }
            .price-box {
                background-color: #f8d7da; /* Color de fondo */
                padding: 5px 10px; /* Espaciado interno */
                border-radius: 5px; /* Bordes redondeados */
                display: inline-block; /* Mostrar en línea */
            }

            .price {
                margin: 0; /* Eliminar el margen interior */
                color: #721c24; /* Color del texto */
                font-weight: bold; /* Texto en negrita */
            }


            </style>
            </div>
            </div>

<!-- Footer Start -->
<div class="container-fluid bg-primary text-white mt-5 pt-5 px-sm-3 px-md-5">
    <div class="row pt-5">
        <div class="col-lg-4 col-md-6 mb-5">
            <a href=""><h1 class="text-secondary mb-3"><span class="text-white">MUNDO</span>3D</h1></a>
            <p>¡Adéntrate en un mundo tridimensional como nunca antes! ¡Bienvenid@ nuestra página 3D, donde tus sueños cobran vida!</p>
            <div class="d-flex justify-content-start mt-4">
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fas fa-times"></i></a>
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
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
        &copy; <a class="text-white font-weight-medium" href="#">MUNDO 3D</a>. Todos los derechos reservados <?php echo date('Y'); ?>
    </p>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>


</html>