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
// Consulta a la base de datos para obtener productos de la categoría 5
$sql = "SELECT * FROM productos WHERE Pro_Categoria = 2";
$repuestos = mysqli_query($link, $sql);
// Manejar la solicitud AJAX en el mismo archivo PHP
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el producto
    if (isset($_POST['producto'])) {
        // Obtener el ID del usuario de la sesión
        if (isset($_SESSION['user_id'])) {
            $usuario_id = $_SESSION['user_id'];

            // Convertir los datos del producto JSON en un array asociativo
            $producto = json_decode($_POST['producto'], true);

            // Definir la cantidad predeterminada (en este caso, 1)
            $cantidad = 1;

            // Aquí puedes realizar el procesamiento adicional, como guardar el producto en la base de datos
            $Identificador = $producto['Identificador'];

            // Insertar el producto en la base de datos con el ID del usuario
         // Insertar el producto en la base de datos con el ID del usuario
            $sql = "INSERT INTO carrito (Pe_Cliente, cantidad, id_producto) 
            SELECT '$usuario_id', $cantidad, p.Identificador
            FROM productos p
            WHERE p.Identificador = '$Identificador'";

            // Ejecutar la consulta
            mysqli_query($link, $sql);

            // Simular una respuesta exitosa
            echo "Producto agregado al carrito correctamente.";
        } else {
            // Si no hay un usuario logueado, mostrar un mensaje de error
            echo "No hay un usuario logueado.";
        }
    } else {
        // Si no se recibió el producto, mostrar un mensaje de error
        echo "No se recibieron datos del producto.";
    }

    // Finalizar la ejecución del script para evitar la renderización adicional de HTML
    exit();
}
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
                    <input placeholder="Buscar un producto" id="input" class="input" name="text" type="text">

                </div>
            </div>
            <style>
                .InputContainer {
                    width: 210px;
                    height: 50px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: linear-gradient(to bottom, rgb(227, 213, 255), rgb(255, 231, 231));
                    border-radius: 30px;
                    overflow: hidden;
                    cursor: pointer;
                    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.075);
                }

                .input {
                    width: 200px;
                    height: 40px;
                    border: none;
                    outline: none;
                    caret-color: rgb(255, 81, 0);
                    background-color: rgb(255, 255, 255);
                    border-radius: 30px;
                    padding-left: 15px;
                    letter-spacing: 0.8px;
                    color: rgb(19, 19, 19);
                    font-size: 13.4px;
                }
            </style>
            <div class="col-md-6 text-center text-md-right">
                <a id="carritoBtn" class="btn btn-danger text-white font-weight-bold ml-3" href="#" data-toggle="modal"
                    data-target="#carritoModal">
                    <span>Carrito</span>
                    <i class="fas fa-shopping-cart ml-2"></i>
                    <span id="contadorProductos" class="badge badge-light contador-rojo">
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
        </div>
    </div>

    <style>
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .contador-rojo {
            color: red;
        }
    </style>
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
            <button type="button" class="btn btn-primary" style="background-color: red; border-color: red;" onclick="vaciarCarrito()">Vaciar Carrito</button>            <button type="button" class="btn btn-primary" id="irAPagarBtn">Ir a pagar</button>
            </div>
        </div>
    </div>
</div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Obtener referencia al botón "Ir a pagar"
            var irAPagarBtn = document.getElementById('irAPagarBtn');

            // Agregar un evento clic al botón
            irAPagarBtn.addEventListener('click', function (event) {
                // Aquí puedes agregar la lógica para redirigir al usuario a la página de pago
                // Utiliza una ruta absoluta y barras inclinadas hacia adelante
                window.location.href = 'redireccionar.php';
            });
        });
    </script>
    <script>

        // Variable para almacenar los productos en el carrito
        var carritoProductos = [];

        // Función para agregar un producto al carrito
        function agregarAlCarrito(producto) {
            // Agregar el producto al arreglo de productos en el carrito
            carritoProductos.push(producto);

            // Mostrar el carrito actualizado
            mostrarCarrito();

            // Actualizar el contador de productos
            actualizarContadorProductos();

            // Enviar datos del producto al servidor mediante AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); // El mismo archivo PHP
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText); // Puedes mostrar un mensaje de éxito en la consola
                        // Recargar la página después de agregar un producto
                        location.reload();
                    } else {
                        console.error('Error al guardar el producto en el carrito.');
                    }
                }
            };

            // Convertir el objeto producto a una cadena JSON para enviarlo al servidor
            var data = JSON.stringify(producto);
            xhr.send("producto=" + encodeURIComponent(data));
        }

        // Función para actualizar el contador de productos en el botón del carrito
        function actualizarContadorProductos() {
            // Filtrar los productos en el carrito que tengan estado de pago "pendiente"
            var productosPendientes = carritoProductos.filter(function (producto) {
                return producto.estado_pago === 'pendiente';
            });

            // Actualizar el contador de productos con la longitud del arreglo filtrado
            var contadorProductos = document.getElementById('contadorProductos');
            contadorProductos.textContent = productosPendientes.length;

            // Si no hay productos pendientes, mostrar 0 en el contador
            if (productosPendientes.length === 0) {
                contadorProductos.textContent = '0';
            }
        }


        // Esperar a que el DOM esté completamente cargado
        document.addEventListener("DOMContentLoaded", function () {
            // Obtener todos los botones "Agregar al carrito"
            var agregarAlCarritoBtns = document.querySelectorAll('.agregarAlCarritoBtn');

            agregarAlCarritoBtns.forEach(function (btn) {
                btn.addEventListener('click', function (event) {
                    event.preventDefault();
                    var productId = this.getAttribute('data-id');
                    var productName = this.getAttribute('data-name');
                    var productPrice = parseFloat(this.getAttribute('data-price'));

                    // Agregar el producto al carrito
                    agregarAlCarrito({ Identificador: productId, nombre: productName, precio: productPrice });
                });
            });
        });

        // Función para mostrar el carrito
        function mostrarCarrito() {
            var carritoContenido = document.getElementById('carritoContenido');
            var totalProductos = document.getElementById('totalProductos');
            var total = 0;

            // Limpiar contenido previo
            carritoContenido.innerHTML = '';

            // Mostrar cada producto en el carrito
            carritoProductos.forEach(function (producto) {
                carritoContenido.innerHTML += '<p>' + producto.nombre + ' - Precio: $' + producto.precio + '</p>';
                total += producto.precio;
            });

            // Mostrar el total de todos los productos
            totalProductos.innerHTML = '<p>Total: $' + total + '</p>';
        }
    </script>
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
    <div class="container-fluid" style="background-color: #D3D3D3; margin-top: -70px;">
        <div class="container">
            <h1 class="display-4 text-center mb-5">Explora nuestros repuestos</h1>
            <div class="row row-cols-lg-4 row-cols-md-3 justify-content-center">
                <?php
                // Consulta a la base de datos para obtener productos de la categoría 5
                $sql = "SELECT * FROM productos WHERE Pro_Categoria = 2";
                $result = mysqli_query($link, $sql);

                // Verificar si se encontraron productos en la categoría 1b
                if (mysqli_num_rows($result) > 0) {
                    // Iterar sobre los resultados y mostrar cada producto
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                    <div class="col mb-4">
                        <div class="card h-100 position-relative">
                            <img src="<?php echo $row['nombre_imagen']; ?>" class="card-img-top"
                                style="height: 200px; object-fit: contain;" alt="<?php echo $row['Pro_Nombre']; ?>">
                            <div class="overlay position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
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
                                        <?php echo $row['Pro_Nombre']; ?></h5>
                                    <?php if ($row['Pro_Cantidad'] == 0) { ?>
                                        <div class="price-box text-center"
                                            style="position: absolute; bottom: 0; left: 0; right: 0;">
                                            <!-- Centra el cuadro del precio -->
                                            <div style="display: inline-block; padding: 5px; border-radius: 5px;">
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
                        <img id="productoImagen" src="" height="150px" style="border: 1px solid #dddddd; padding: 8px;">
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var detallesBtns = document.querySelectorAll('.detallesBtn');

        detallesBtns.forEach(function (btn) {
            btn.addEventListener('click', function (event) {
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
        modalPrecio.textContent = "USD-" + productPrice;

        $('#detalleProductoModal').modal('show');
    }
</script>
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
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="#ff00ff">
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
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="#4267B2">
                                <path
                                    d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                                </path>
                            </svg>
                    </a>
                    </button>
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
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <script src="js/main.js"></script>
</body>
</html>