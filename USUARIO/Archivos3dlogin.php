<?php
        session_start();
        include __DIR__ . '/../conexion.php';

        // Confirmación de que el usuario ha realizado el proceso de autenticación
        if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
            header("Location: ../Programas/autenticacion.php");
            exit(); // Terminamos la ejecución del script después de redirigir
        }

        // Realizamos la consulta para obtener el rol del usuario
        $peticion = "SELECT Usu_rol FROM usuario WHERE Usu_Identificacion = '".$_SESSION['user_id']."'";
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
        <style>
        /* Estilo para el contenedor que envuelve al botón de cerrar sesión */
        .align-items-center {
            display: flex;
            align-items: center;
        }

        /* Estilo para el recuadro del ícono de cerrar sesión */
        #logout {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px; /* Aumenta el padding para hacer el recuadro más grande */
            border: 1px solid #ffffff;
            border-radius: 10px; /* Aumenta el radio de borde para hacer el recuadro más redondeado */
            cursor: pointer;
            color: white;
        }

        /* Estilo para el icono de discapacitado */
        #disabled-icon {
            margin-right: 10px;
        }

        /* Estilo para el texto "Cerrar sesión" */
        #logout-text {
            white-space: nowrap;
            margin-right: 10px;
        }

        /* Estilo para el texto dentro del botón de hamburguesa */
        #menu-toggle span {
            color: white;
            text-decoration: none;
        }

        /* Estilo para los elementos del menú desplegable */
        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #333;
            padding: 20px; /* Aumenta el padding para hacer el recuadro más grande */
            border-radius: 10px; /* Aumenta el radio de borde para hacer el recuadro más redondeado */
            z-index: 1000; /* Ajusta el z-index para que esté por encima */
        }

        /* Estilo para cada opción del menú desplegable */
        .dropdown-menu-item {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ffffff;
            border-radius: 5px;
        }

        .dropdown-menu-item:hover {
            color: #ffffff; /* Cambia el color del texto al pasar el mouse */
            text-decoration: none !important; /* Quita el subrayado al pasar el ratón */
        }

        /* Estilo para el botón de cerrar sesión al pasar el ratón */
        #logout-button:hover {
            cursor: pointer;
        }

        /* Estilo para alinear a la derecha */
        .align-right {
            margin-left: auto;
        }
    </style>
</head>
<body>
<div class="col-md-6 text-center text-lg-right">
    <div class="align-items-center">
        <!-- Botón de hamburguesa para desplegar opciones -->
        <div class="col-md-6 text-center text-lg-right align-right">
            <div class="d-inline-flex align-items-center">
<!-- Contenedor principal -->
<div id="buttons-container" style="display: flex; justify-content: space-between; align-items: center;">
       <button onclick="disminuirTamano()">-</button>
        <button onclick="aumentarTamano()">+</button>

    <!-- Icono de silla de ruedas -->
    <div id="disabled-icon">
        <i class="fas fa-wheelchair fa-lg text-white" onclick="aumentarTamano()" onmouseover="cambiarCursor(event)" onmouseout="restaurarCursor()"></i>
    </div>
</div>


<script>
function aumentarTamano() {
    // Aumentar el tamaño de fuente de todo el documento
    var elementos = document.getElementsByTagName("*");
    for (var i = 0; i < elementos.length; i++) {
        var elemento = elementos[i];
        var estilo = window.getComputedStyle(elemento);
        var fontSize = parseInt(estilo.fontSize);
        elemento.style.fontSize = (fontSize + 2) + "px"; // Incrementa el tamaño de la fuente en 2px
    }
}

function disminuirTamano() {
    // Disminuir el tamaño de fuente de todo el documento
    var elementos = document.getElementsByTagName("*");
    for (var i = 0; i < elementos.length; i++) {
        var elemento = elementos[i];
        var estilo = window.getComputedStyle(elemento);
        var fontSize = parseInt(estilo.fontSize);
        elemento.style.fontSize = (fontSize - 2) + "px"; // Disminuye el tamaño de la fuente en 2px
    }
}

function cambiarCursor(event) {
    event.target.style.cursor = "pointer"; // Cambiar el cursor a una mano cuando pasa sobre el icono de la silla de ruedas
}

function restaurarCursor() {
    document.getElementById("disabled-icon").style.cursor = "auto"; // Restaurar el cursor al valor predeterminado cuando se aleja del icono de la silla de ruedas
}

// Cambiar el color del icono de la silla de ruedas a blanco
document.querySelector("#disabled-icon .fa-wheelchair").style.color = "#fff";
// Obtener los botones y establecer el color de fondo como transparente y el color del texto como blanco
document.querySelectorAll("#buttons-container button").forEach(function(button) {
    button.style.backgroundColor = "transparent";
    button.style.color = "#fff"; // Color blanco
});

</script>
                <!-- Menú desplegable -->
                <div id="dropdown-menu" class="dropdown-menu">
                    <a href="confi.php" class="dropdown-menu-item">
                        <i class="fas fa-cogs"></i> <!-- Icono de configuración -->
                        Configurar mi cuenta
                    </a>
                    <a href="pedidos.php" class="dropdown-menu-item bm-2">
                        <i class="fas fa-list"></i> <!-- Icono de lista -->
                        Mis pedidos
                    </a>
                </div>

                <!-- Icono de barras -->
                <button class="btn btn-link" type="button" id="menu-toggle">
                    <i class="fas fa-bars fa-lg text-white"></i>
                    <span>Mi menú</span> <!-- Cambia el texto del botón de hamburguesa -->
                </button>
            </div>

            <script>
                document.getElementById("menu-toggle").addEventListener("click", function() {
                    var menu = document.getElementById("dropdown-menu");
                    if (menu.style.display === "block") {
                        menu.style.display = "none";
                    } else {
                        menu.style.display = "block";
                    }
                });
            </script>

            <!-- Icono de salir con recuadro y texto -->
            <div id="logout" class="ml-2" onclick="confirmLogout()">
                <span id="logout-text">Cerrar Sesión</span>
                <i id="logout-button" class="fas fa-sign-out-alt fa-lg text-white"></i>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmLogout() {
        var confirmLogout = confirm("¿Estás seguro de que deseas cerrar sesión?");
        if (confirmLogout) {
            window.location.href = "../Programas/logout.php"; // Redirige al script de cierre de sesión
        }
    }
</script>
                <style>
                    #logout-button:hover {
                        cursor: pointer;
                    }
                </style>
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
                        <a href="Catalogologin.php" class="nav-item nav-link">CATALOGO</a>
                        <a href="Respuestoslogin.php" class="nav-item nav-link">REPUESTOS</a>
                        <a href="Archivos3dlogin.php" class="nav-item nav-link">ARCHIVOS 3D</a>
                        <a href="serviciodeimpresion.php" class="nav-item nav-link">SERVICIO DE IMPRESION</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="page-header container-fluid bg-secondary pt-2 pt-lg-5 pb-2 mb-5">
        <div class="container py-5">
            <div class="row align-items-center py-4">
                <div class="col-md-6 text-center text-md-left">
                    <h1 class="mb-4 mb-md-0 text-white">Archivos 3D</h1>
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
    <div class="container-fluid pt-5">
    <div class="container">
        <h1 class="display-4 text-center mb-5">Explore nuestros Archivos 3D</h1>
        <div class="row">
            <?php
            // Mostrar productos si hay resultados
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-lg-3 col-md-6 product">
                        <div class="card mb-5" style="height: 250px;"> <!-- Reduciendo la altura a 300px -->
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen_principal']); ?>" class="card-img-top" style="height: 150px; object-fit: cover;" alt="<?php echo $row["Pro_Nombre"]; ?>"> <!-- También ajusta la altura de la imagen -->
                            <div class="card-body">
                                <h5 class="card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $row["Pro_Nombre"]; ?></h5>
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modal_<?php echo $row["Identificador"]; ?>">Detalles</a>
                                    <a href="#" class="btn btn-danger" onclick="downloadImage('<?php echo base64_encode($row['imagen_principal']); ?>', '<?php echo $row["Pro_Nombre"]; ?>.jpg')">Descargar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal_<?php echo $row["Identificador"]; ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitle_<?php echo $row["Identificador"]; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitle_<?php echo $row["Identificador"]; ?>"><?php echo $row["Pro_Nombre"]; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen_principal']); ?>" class="img-fluid" alt="<?php echo $row["Pro_Nombre"]; ?>">
                                    <p><?php echo $row["Pro_Descripcion"]; ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <a href="#" class="btn btn-success" onclick="downloadImage('<?php echo base64_encode($row['imagen_principal']); ?>', '<?php echo $row["Pro_Nombre"]; ?>.jpg')">Descargar</a>
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
                <a class="text-white mb-2" href="Catalogologin.php"><i class="fa fa-angle-right mr-2"></i>CATALOGO</a>
                <a class="text-white mb-2" href="Respuestoslogin.php"><i class="fa fa-angle-right mr-2"></i>REPUESTOS</a>
                <a class="text-white mb-2" href="Archivos3dlogin.php"><i class="fa fa-angle-right mr-2"></i>ARCHIVOS 3D</a>
                <a class="text-white" href="serviciodeimpresion.php"><i class="fa fa-angle-right mr-2"></i>SERVICIO DE IMPRESION</a>
            </div>
        </div>
    </div>
</div>

    <div class="container-fluid bg-dark text-white py-4 px-sm-3 px-md-5">
    <p class="m-0 text-center text-white">
        &copy; <a class="text-white font-weight-medium" href="#">MUNDO 3D</a>. Todos los derechos reservados <?php echo date('Y'); ?>
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