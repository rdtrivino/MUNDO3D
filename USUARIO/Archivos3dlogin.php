<?php
session_start();
include __DIR__ . '/../conexion.php';

// Confirmación de que el usuario ha realizado el proceso de autenticación
if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Realizamos la consulta para obtener el rol del usuario
$peticion = "SELECT Usu_rol FROM usuario WHERE Usu_Identificacion = '" . $_SESSION['user_id'] . "'";
$result = mysqli_query($link, $peticion);

// Verificamos si la consulta tuvo éxito
if (!$result) {
    // Manejo de errores de consulta
    // Redirigir a la página de autenticación o mostrar un mensaje de error
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Verificamos si la consulta devolvió exactamente un resultado
if (mysqli_num_rows($result) != 1) {
    // Si la consulta no devuelve un solo resultado, puede ser un problema de base de datos
    // Redirigir a la página de autenticación o mostrar un mensaje de error
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Obtenemos el rol del usuario
$fila = mysqli_fetch_assoc($result);
$rolUsuario = $fila['Usu_rol'];

// Verificar si el rol del usuario es diferente de 3
if ($rolUsuario != 3) {
    // Si el rol no es 3, redirigir a la página de autenticación
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Si llegamos aquí, el usuario está autenticado y tiene el rol 3
// Continuar con el resto del código
$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];
?>
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
$sql = "SELECT * FROM productos WHERE Pro_Categoria = 5";
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
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css\misestilos.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="programas/im-pr.css">
</head>

<body>
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

                    <script>
                        // Función para hacer una solicitud AJAX al servidor y obtener el nombre de usuario
                        function getUsername() {
                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', '../Programas/get_username.php', true);
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    // Parsea la respuesta JSON para obtener el objeto de usuario
                                    var userData = JSON.parse(xhr.responseText);
                                    // Obtiene el nombre completo del objeto de usuario
                                    var nombreCompleto = userData.nombreCompleto;
                                    // Actualiza el contenido del elemento user-name con el nombre completo de usuario
                                    document.getElementById('user-name').textContent = 'Bienvenid@ ' + nombreCompleto;
                                }
                            };
                            xhr.send();
                        }

                        // Llama a la función getUsername al cargar la página para obtener el nombre de usuario
                        window.onload = function () {
                            getUsername();
                        };
                    </script>
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
                                <script>
                                    function adjustFontSize(size) {
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

                                    function aumentarTamano() {
                                        // Funcionalidad específica para el icono de silla de ruedas
                                    }

                                    function cambiarCursor(event) {
                                        event.target.style.cursor = 'pointer';
                                    }

                                    function restaurarCursor(event) {
                                        event.target.style.cursor = 'default';
                                    }
                                </script>

                                <!-- Menú desplegable -->
                                <div class="dropdown" style="position: relative; white-space: nowrap;">
                                    <div id="dropdown-menu" class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="menu-toggle" style="background-color: black;"> <a
                                            href="../Programas/redireccionarpaginas.php?page=configuracion"
                                            class="dropdown-menu-item">
                                            <i class="fas fa-cogs"></i> <!-- Icono de configuración -->
                                            Configurar mi cuenta
                                        </a>
                                        <a href="../Programas/redireccionarpaginas.php?page=pedidos"
                                            class="dropdown-menu-item bm-2">
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
                                <script>
                                    document.getElementById("menu-toggle").addEventListener("click", function (event) {
                                        var menu = document.getElementById("dropdown-menu");
                                        menu.style.display = (menu.style.display === "block") ? "none" : "block";
                                        event.stopPropagation(); // Evita que el clic en el botón se propague al documento
                                    });

                                    // Event listener para cerrar el menú desplegable cuando se hace clic fuera de él
                                    document.addEventListener("click", function (event) {
                                        var menu = document.getElementById("dropdown-menu");
                                        var menuToggle = document.getElementById("menu-toggle");
                                        if (!menu.contains(event.target) && event.target !== menuToggle) {
                                            menu.style.display = "none";
                                        }
                                    });

                                    function confirmLogout() {
                                        var confirmLogout = confirm("¿Estás seguro de que deseas cerrar sesión?");
                                        if (confirmLogout) {
                                            window.location.href = "../Programas/logout.php"; // Redirige al script de cierre de sesión
                                        }
                                    }
                                </script>
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
                    <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                        <div class="navbar-nav ml-auto py-0">
                            <a href="../Programas/redireccionarpaginas.php?page=impresoras"
                                class="nav-item nav-link">IMPRESORAS</a>
                            <a href="../Programas/redireccionarpaginas.php?page=repuestos"
                                class="nav-item nav-link">REPUESTOS</a>
                            <a href="../Programas/redireccionarpaginas.php?page=archivos3d"
                                class="nav-item nav-link">ARCHIVOS 3D</a>
                            <a href="../Programas/redireccionarpaginas.php?page=servicioimpresion"
                                class="nav-item nav-link">SERVICIO DE IMPRESION</a>
                        </div>
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
            <style>
                .InputContainer {
                    display: flex;
                    flex-direction: column;
                    gap: 7px;
                    position: relative;
                    color: white;
                    margin-top: 0%;

                }

                @media (max-width: 1500px) {
                    .InputContainer {
                        display: none;
                        /* Ocultar el contenedor en pantallas más pequeñas que 768px */
                    }
                }

                .InputContainer .label {
                    font-size: 15px;
                    padding-left: 10px;
                    position: absolute;
                    top: 13px;
                    transition: 0.3s;
                    pointer-events: none;
                    color: black;
                }

                .input {
                    width: 300px;
                    height: 45px;
                    border: none;
                    outline: none;
                    padding: 0px 7px;
                    border-radius: 6px;
                    color: #fff;
                    font-size: 15px;
                    background-color: transparent;
                    box-shadow: 3px 3px 10px rgba(0, 0, 0, 1),
                        -1px -1px 6px rgba(255, 255, 255, 0.4);
                }

                .input:focus {
                    border: 2px solid transparent;
                    color: black;
                    box-shadow: 3px 3px 10px rgba(0, 0, 0, 1),
                        -1px -1px 6px rgba(255, 255, 255, 0.4),
                        inset 3px 3px 10px rgba(0, 0, 0, 1),
                        inset -1px -1px 6px rgba(255, 255, 255, 0.4);
                }

                .InputContainer .input:valid~.label,
                .InputContainer .input:focus~.label {
                    transition: 0.3s;
                    padding-left: 2px;
                    transform: translateY(-35px);
                }

                .InputContainer .input:valid,
                .InputContainer .input:focus {
                    box-shadow: 3px 3px 10px rgba(0, 0, 0, 1),
                        -1px -1px 6px rgba(255, 255, 255, 0.4),
                        inset 3px 3px 10px rgba(0, 0, 0, 1),
                        inset -1px -1px 6px rgba(255, 255, 255, 0.4);
                }
            </style>
        </div>
    </div>
    <script>
        function searchProducts(searchTerm) {
            // Obtener todos los elementos de productos
            var products = document.querySelectorAll('.product');

            // Convertir el término de búsqueda a mayúsculas para hacer una comparación insensible a mayúsculas y minúsculas
            searchTerm = searchTerm.toUpperCase();

            // Iterar sobre todos los productos
            products.forEach(function (product) {
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
    <div class="container-fluid" style="background-color: #D3D3D3; margin-top: -50px;">
        <div class="container">
            <h1 class="display-4 text-center mb-5">Explora nuestros archivos 3D</h1>
            <div class="row row-cols-lg-4 row-cols-md-3 justify-content-center">
                <?php
                // Consulta a la base de datos para obtener productos de la categoría 5
                $sql = "SELECT * FROM productos WHERE Pro_Categoria = 5";
                $result = mysqli_query($link, $sql);

                // Verificar si se encontraron productos en la categoría 1b
                if (mysqli_num_rows($result) > 0) {
                    // Iterar sobre los resultados y mostrar cada producto
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col mb-4">
                            <div class="card h-100">
                                <img src="<?php echo $row['nombre_imagen']; ?>" class="card-img-top"
                                    style="height: 200px; object-fit: contain;" alt="<?php echo $row['Pro_Nombre']; ?>">
                                <div
                                    class="overlay position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
                                    <?php if ($row['Pro_Cantidad'] > 0) { ?>
                                        <button class="btn btn-primary btn-lg descargar"
                                            onclick="downloadImage('<?php echo base64_encode($row['nombre_imagen']); ?>', '<?php echo htmlspecialchars($row['Pro_Nombre']); ?>.jpg')"
                                            style="background-color: #000080;">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn btn-primary btn-lg descargar" disabled>
                                            <i class="fas fa-download"></i>
                                        </button>
                                    <?php } ?>
                                    <a href="#" class="btn btn-secondary btn-lg mx-2 detallesBtn" data-toggle="modal"
                                        data-target="#detalleProductoModal" data-id="<?php echo $row['Identificador']; ?>"
                                        data-name="<?php echo $row['Pro_Nombre']; ?>"
                                        data-description="<?php echo $row['Pro_Descripcion']; ?>"
                                        style="background-color: #800000;"><i class="fas fa-search"></i></a>
                                </div>

                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <h5 class="card-title mb-2 text-center"
                                        style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                        <?php echo $row['Pro_Nombre']; ?>
                                    </h5>
                                </div>
                            </div>
                            <style>
                                /* Estilos para centrar verticalmente el nombre del producto en la tarjeta */
                                .card-body {
                                    height: 100%;
                                    /* Asegura que la tarjeta ocupe toda la altura disponible */
                                }

                                .card-title {
                                    margin-top: auto;
                                    /* Centra verticalmente el título */
                                    margin-bottom: auto;
                                }
                            </style>

                            <!-- Modal -->
                            <div class="modal fade" id="detalleProductoModal" tabindex="-1" role="dialog"
                                aria-labelledby="detalleProductoModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-solid-bg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detalleProductoModalLabel">Detalles del Producto</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6 text-center">
                                                        <!-- Imagen del producto -->
                                                        <img src="<?php echo $row['nombre_imagen']; ?>" class="img-fluid"
                                                            style="height: 300px; object-fit: contain;"
                                                            alt="<?php echo $row["Pro_Nombre"]; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <!-- Descripción del producto -->
                                                        <h4 id="productoNombre"><?php echo $row["Pro_Nombre"]; ?></h4>
                                                        <p><strong>Descripción:</strong></p>
                                                        <p id="productoDescripcion"><?php echo $row["Pro_Descripcion"]; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                    style="background-color: #E42E24;">
                                                    Cerrar
                                                </button>
                                                <button class="btn btn-primary btn-lg descargar"
                                                    onclick="downloadImage('<?php echo base64_encode($row['nombre_imagen']); ?>', '<?php echo htmlspecialchars($row['Pro_Nombre']); ?>.jpg')"
                                                    style="background-color: #000080;">
                                                    <i class="fas fa-download"></i> Descargar
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "No se encontraron productos en esta categoría.";
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        // Función para descargar la imagen
        function downloadImage(imageData, imageName) {
            // Crear un enlace temporal
            var link = document.createElement('a');
            link.href = 'data:image/jpeg;base64,' + imageData;
            link.download = imageName;
            // Simular un clic en el enlace para iniciar la descarga
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>

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
                            class="fa fa-angle-right mr-2"></i>IMPRESORAS</a>
                    <a class="text-white mb-2" href="Respuestoslogin.php"><i
                            class="fa fa-angle-right mr-2"></i>REPUESTOS</a>
                    <a class="text-white mb-2" href="Archivos3dlogin.php"><i class="fa fa-angle-right mr-2"></i>ARCHIVOS
                        3D</a>
                    <a class="text-white" href="serviciodeimpresion.php"><i class="fa fa-angle-right mr-2"></i>SERVICIO
                        DE IMPRESION</a>
                </div>
            </div>
        </div>
    </div>
    <style>
        .parent2 {
            width: 30%;
            height: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .child {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            transform-style: preserve-3d;
            transition: all 1.6s ease-in-out;
            border-radius: 100%;
            margin: 0 5px;
            position: relative;
            /* Agregado para posicionar correctamente el texto */
        }

        .child:hover {
            background-color: black;
            background-position: -100px 100px, -100px 100px;
            transform: rotate3d(0.5, 1, 0, 30deg);
            transform: perspective(180px) rotateX(60deg) translateY(2px);
            box-shadow: 0px 10px 10px rgb(1, 49, 182);
        }

        #button1 {
            border: none;
            background-color: white;
            width: 50px;
            height: 50px;
            font-size: 20px;
            border-radius: 50%;
        }

        #button1:hover {
            width: inherit;
            height: inherit;
            display: flex;
            justify-content: center;
            align-items: center;
            transform: translate3d(0px, 0px, 15px) perspective(180px) rotateX(-35deg) translateY(2px);
            border-radius: 100%;
            background-color: white;
        }

        /* Estilos para el texto */
        .child::before {
            content: attr(data-title);
            /* Obtener el texto del atributo data-title */
            position: absolute;
            top: -30px;
            /* Posición del texto arriba del botón */
            color: white;
            /* Color del texto */
            padding: 5px;
            border-radius: 5px;
            font-size: 13px;
            white-space: nowrap;
            /* Evita que el texto se divida en múltiples líneas */
            left: 50%;
            /* Centra horizontalmente */
            transform: translateX(-50%);
            opacity: 0;
            /* Oculta inicialmente el texto */
            transition: opacity 0.9s ease;
            /* Transición de la opacidad */
        }

        .child:hover::before {
            opacity: 1;
            /* Muestra el texto al pasar el mouse sobre el botón */
        }
    </style>
    <!--redes sociales html-->
    <div class="container-fluid bg-dark text-white py-4 px-sm-3 px-md-5">
        <p class="m-0 text-center text-white">
            &copy; <a class="text-white font-weight-medium" href="#">MUNDO 3D</a>. Todos los derechos reservados
            <?php echo date('Y'); ?>
        </p>
    </div>


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