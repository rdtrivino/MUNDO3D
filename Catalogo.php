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
    <link rel="shortcut icon" href="./images/Logo Mundo 3d.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/normalize.css">

</head>

<body>
<!-- Topbar Start -->
<div class="container-fluid bg-primary py-3">
    <div class="row">
        <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
<div id="buttons-container" style="display: flex; justify-content: flex-start; align-items: center;">
<div class="container">
    <div id="disabled-icon" class="mb-3">
        <i class="fas fa-wheelchair fa-lg text-white"></i>
    </div>
    <a href="#" class="font-small text-white font-weight-bold mr-3">A</a>
    <a href="#" class="font-medium text-white font-weight-bold mr-3">A</a>
    <a href="#" class="font-large text-white font-weight-bold">A</a>
</div>
</div>
<style>.font-small {
    font-size: 14px;
}

.font-medium {
    font-size: 16px;
}

.font-large {
    font-size: 20px;
}

#disabled-icon {
    display: inline-block; /* Para alinear verticalmente con los enlaces */
}

a {
    text-decoration: none; /* Eliminar subrayado de los enlaces */
}</style>

        </div>
        <div class="col-md-6 text-center text-lg-right">
        <div class="d-inline-flex align-items-center" style="margin-top: -10%;"> <!-- Ajusta el margen superior según sea necesario -->
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
                        <input type="text" id="username" name="username" placeholder="Ingrese su usuario"required>
                      </div>
                      <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <div class="password-input-container">
                            <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                            <span class="password-toggle-icon" onclick="togglePasswordVisibility()">
                                <img src="../MUNDO 3D/images/bxs-show.svg" alt="Mostrar contraseña" class="show-password-icon">
                                <img src="../MUNDO 3D/images/bxs-low-vision.svg" alt="Ocultar contraseña" class="hide-password-icon" style="display: none;">
                            </span>
                        </div>
                    <script>
                        function togglePasswordVisibility() {
                            var passwordInput = document.getElementById('password');
                            var showIcon = document.querySelector('.show-password-icon');
                            var hideIcon = document.querySelector('.hide-password-icon');
                    
                            // Cambiar el tipo de input para mostrar/ocultar la contraseña
                            passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
                    
                            // Mostrar/ocultar los íconos en función del estado actual de la contraseña
                            showIcon.style.display = (passwordInput.type === 'password') ? 'block' : 'none';
                            hideIcon.style.display = (passwordInput.type === 'password') ? 'none' : 'block';
                        }
                        document.addEventListener('DOMContentLoaded', function() {
                        // Obtener el enlace y el modal
                        var btnModal = document.getElementById('btnModal');
                        var modal = document.getElementById('myModal');

                        // Obtener el botón de cerrar dentro del modal
                        var closeBtn = modal.querySelector('.close');

                        // Mostrar el modal cuando se hace clic en el enlace
                        btnModal.addEventListener('click', function() {
                            modal.style.display = 'block';
                        });

                        // Ocultar el modal cuando se hace clic en el botón de cerrar
                        closeBtn.addEventListener('click', function() {
                            modal.style.display = 'none';
                        });

                        // Ocultar el modal cuando se hace clic fuera de él
                        window.addEventListener('click', function(event) {
                            if (event.target === modal) {
                                modal.style.display = 'none';
                            }
                        });
                    });

                    </script>
                                                                 
                        <style>
                            .password-input-container {
                                position: relative;
                            }

                            .password-toggle-icon {
                                position: absolute;
                                top: 49%;
                                right: 20px; /* Ajusta el valor según sea necesario */
                                transform: translateY(-50%);
                                cursor: pointer;
                                width: 20px; /* Ajusta el ancho según sea necesario */
                                height: 20px; /* Ajusta la altura según sea necesario */
                                background: url('images/eye-icon.svg') center center no-repeat; /* Ajusta la ruta según sea necesario */
                            }
                            .hamburguer {
                                /* Estilos del botón hamburguesa */
                                position: absolute;
                                top: 5%;
                                right: 30px;
                                background: #2433bd;
                                width: 35px;
                                height: 35px;
                                cursor: pointer;
                                border-radius: 40px;
                                box-shadow: 0 0 6px rgb(230, 230, 236);
                            }
                            .modalContainer {
                                display: none; 
                                position: fixed; 
                                z-index: 9999; 
                                padding-top: 100px;
                                left: 0;
                                top: 0;
                                width: 100%;
                                height: 100%; 
                                overflow: auto; 
                                background-color: rgba(85, 83, 83, 0.534);
                                background-color: rgba(88, 87, 87, 0.658);
                                
                            }

                            .modalContainer .modal-content {
                                background-color: #6d6d7e;
                                margin: auto;
                                padding: 10px;
                                border: 1px solid rgb(80, 9, 211);
                                border-top: 15px solid #5869b7;
                                width: 25%;
                                border-radius: 30px;
                                text-align: center;
                            }

                            .modalContainer .close {
                                color: #0921aa;
                                position: absolute;
                                top: 10px; /* Ajusta la posición vertical según sea necesario */
                                right: 10px; /* Ajusta la posición horizontal según sea necesario */
                                font-size: 28px;
                                font-weight: bold;
                            }

                            .modalContainer .close:hover,
                            .modalContainer .close:focus {
                                color: #000;
                                text-decoration: none;
                                cursor: pointer;
                            }

                            .spread{
                                transform: translate(0);
                            }

                            .form-group {
                                margin-bottom: 20px;
                            }
                            .form-group label {
                                display: block;
                                margin-bottom: 5px;
                                font-weight: bold;
                                color: #001A49;
                            }
                            .form-group input {
                                width: 97%;
                                padding: 8px;
                                border-radius: 30px;
                                border: 1px solid #130a0a;
                            }
                            .form-group .password-toggle {
                                margin-top: 5px;
                            }
                            .form-group .password-toggle input {
                                width: auto;
                                display: inline-block;
                                margin-left: 5px;
                            }
                            .form-group .password-toggle label {
                                display: inline;
                            }
                            .form-group .forgot-password {
                                margin-top: 5px;
                                text-align: left;
                            }
                            .form-group .forgot-password a {
                                color: #0c0808;
                                text-decoration: none;
                            }
                            .forgot-password-link{
                                color: #1d1313;
                            }
                            .button{
                                border-radius: 30px;
                                padding: 15px;
                                background: #2433bd;
                                font-family: 'Roboto', sans-serif;
                                cursor: pointer;
                                font-weight: bold;
                                color: #eee7e7;
                            }
                            .password-toggle-icon {
                                position: absolute;
                                top: 50%;
                                right: 10px;
                                transform: translateY(-50%);
                                cursor: pointer;
                                color: #ffffff;
                            }
                            .registro{
                                border-radius: 30px;
                                padding: 15px;
                                background: #2433bd;
                                font-family: 'Roboto', sans-serif;
                                cursor: pointer;
                                font-weight: bold;
                                color: #ffffff !important;
                            }
                            .button, .registro {
                                width: calc(50% - 20px); /* Ancho de los botones, restando el margen */
                                margin: 0% auto; /* Margen entre los botones */
                                border-radius: 30px;
                                padding: 15px;
                                background: #2433bd;
                                font-family: 'Roboto', sans-serif;
                                cursor: pointer;
                                font-weight: bold;
                                color: #eee7e7;
                            }


                        </style>                                            
                </form>
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
                        <button type="button" class="registro" onclick="window.location.href='registro.html'">Registrate</button>
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
    <div class="page-header container-fluid pt-2 pt-lg-5 pb-2 mb-5">
            <div class="container py-5">
            <div class="row align-items-center py-4">
            </div>
        </div>
    </div>
        <style>
        .page-header {
            position: relative;
            background-color: black; /* Un tono de gris oscuro */
            color: white; /* Texto blanco */
            clip-path: polygon(0 0, 100% 0, 100% 50%, 50% 75%, 0 50%);
            border-top: 5px solid white; /* Línea blanca en la parte superior */
            z-index: -1;
        }

    </style>
        
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
                                        <img src="<?php echo $imageSrc; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo $row['Pro_Nombre']; ?>">
                                        <div class="overlay position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
                                            <a href="#" class="btn btn-secondary btn-lg mx-2 detallesBtn" data-toggle="modal" data-target="#detalleProductoModal" data-id="<?php echo $row['Identificador']; ?>" data-name="<?php echo $row['Pro_Nombre']; ?>" data-description="<?php echo $row['Pro_Descripcion']; ?>" data-price="<?php echo $row['Pro_PrecioVenta']; ?>" style="background-color: #E42E24;"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title mb-2" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo $row['Pro_Nombre']; ?></h5>
                                            <?php if ($row['Pro_Cantidad'] == 0) { ?>
                                                <div class="price-box text-center" style="position: absolute; bottom: 0; left: 0; right: 0;"> <!-- Centra el cuadro del precio -->
                                                    <div style="display: inline-block;padding: 5px; border-radius: 5px;"> <!-- Cuadro rojo -->
                                                        <span style="color: red; font-weight: bold; font-size: 20px;">Agotado</span> <!-- Establece el color del texto "Agotado" en rojo y aumenta el tamaño de la fuente -->
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="price-box text-center" style="position: absolute; bottom: 0; left: 0; right: 0;"> <!-- Centra el cuadro del precio -->
                                                    <div style="display: inline-block; padding: 5px; border-radius: 5px;"> <!-- Cuadro rojo -->
                                                        <p class="price mb-0" style="color: black;">USD-<?php echo $row['Pro_PrecioVenta']; ?></p> <!-- Establece el color del precio en negro -->
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
            <style>
                .card.h-100 {
                    height: 300px !important; /* Ajusta esta altura según tus necesidades */
                }
            </style>

 <!-- Modal de detalles del producto -->
 <div class="modal fade" id="detalleProductoModal" tabindex="-1" role="dialog" aria-labelledby="detalleProductoModalLabel" aria-hidden="true">
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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: #E42E24;">Cerrar</button>
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
                            var productName = this.getAttribute('data-name');
                            var productDescription = this.getAttribute('data-description');
                            var productPrice = this.getAttribute('data-price');
                            var productImage = this.closest('.card').querySelector('.card-img-top').getAttribute('src');

                            cargarDetallesProducto(productName, productDescription, productPrice, productImage);
                        });
                    });
                });

                function cargarDetallesProducto(productName, productDescription, productPrice, productImage) {
                    var modalImagen = document.getElementById('productoImagen');
                    var modalNombre = document.getElementById('productoNombre');
                    var modalDescripcion = document.getElementById('productoDescripcion');
                    var modalPrecio = document.getElementById('productoPrecio');

                    modalImagen.src = productImage;
                    modalNombre.textContent = productName;
                    modalDescripcion.textContent = productDescription;
                    modalPrecio.textContent = "$" + productPrice;

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