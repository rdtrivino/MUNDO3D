<?php
// Datos de conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/Administrador.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="../MUNDO 3D/js/usuario.js"></script>
    <title>Catálogo de Productos</title>
    <style>
        .modal-fixed-size {
            max-width: 900px;
            width: 100%;
            margin: 0;
            position: fixed;
            top: 20%;
            left: 30%;
            transform: translate(-50%, -50%);
            overflow: auto;
        }

        @media (max-width: 768px) {
            .modal-fixed-size {
                max-width: 90%;
            }
        }
        .green-box {
        background-color: #218838; /* Color de fondo verde oscuro */
        color: #fff; /* Color de texto blanco */
        padding: 5px; /* Espacio interno */
        border-radius: 15px; /* Borde redondeado */
        max-width: 200px; /* Ancho máximo */
        text-align: center; /* Centra el contenido horizontalmente */
        margin: auto; /* Centra la caja horizontalmente */
        white-space: nowrap; /* Evita el salto de línea */
        display: flex; /* Usa flexbox */
        align-items: center; /* Centra verticalmente */
        justify-content: center; /* Centra horizontalmente */
    }
    h4 {
            margin-top: 20px; /* Espacio entre la línea y el título */
            text-align: center; /* Centrar el texto horizontalmente */
            font-size: 50px; /* Tamaño de fuente */
            font-weight: bold; /* Negrita */
            color: #333; /* Color del texto */
        }
        
</style>

</head>
<body style="background: linear-gradient(135deg, #87CEFA, #A9A9A9);">
<script>
    // Array para almacenar los productos en el carrito
    var carrito = [];
    
    // Contador inicial del carrito
    var contadorCarrito = 0;

    // Función para agregar productos al carrito
    function agregarACarrito(nombreProducto, precioProducto) {
        // Agrega el producto al carrito
        carrito.push({ nombre: nombreProducto, precio: precioProducto });
        
        // Incrementa el contador del carrito
        contadorCarrito++;

        // Actualiza el número de productos en el carrito en la interfaz
        document.getElementById('cartCount').innerText = contadorCarrito;

        // Aquí puedes agregar cualquier otra lógica relacionada con la funcionalidad del carrito,
        // como guardar los productos en el almacenamiento local del navegador o mostrar un mensaje de confirmación.
    }
</script>

<header class="hero">
    <div class="nav__logo">
        <img src="../images/Logo Mundo 3d.png" alt="Logo de la empresa" class="logo">
    </div>
    <div class="user-controls">
    <div class="user-info">
        <button id="user-button">Bienvenido: <span id="user-name">Nombre de usuario</span></button>
        <div class="user-menu" id="user-menu">
            <ul>
                <li><a href="#">Panel de control</a></li>
            </ul>
        </div>
    </div>
    <script>
    // Realiza una solicitud AJAX para obtener el nombre de usuario del script PHP
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../Programas/get_username.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.nombreCompleto) {
                // Actualiza el contenido del elemento <span> con el nombre de usuario
                document.getElementById("user-name").textContent = response.nombreCompleto;
            }
        }
    };
    xhr.send();
</script>
    <div class="logout-controls" style="margin-right: 20px; margin-top: 1%;"> <!-- Ajuste del margen superior -->
        <div class="logout-icon">
            <a href="#" id="logout-button">
                <i class="fas fa-sign-out-alt fa-3x"></i> <!-- Font Awesome logout icon -->
            </a>
        </div>
    </div>
</div>



<script>
    var userButton = document.getElementById("user-button");
    var userMenu = document.getElementById("user-menu");
    var logoutButton = document.getElementById("logout-button");

    userButton.addEventListener("click", function (e) {
        e.stopPropagation(); // Evitar que el clic llegue a la ventana principal
        userMenu.classList.toggle("show");
    });

    logoutButton.addEventListener("click", function () {
        var confirmLogout = confirm("¿Estás seguro de que deseas cerrar sesión?");
        if (confirmLogout) {
            window.location.href = "logout.php"; // Redirige al script de cierre de sesión
        }
    });

    // Cierra el menú desplegable si el usuario hace clic en cualquier otro lugar de la página
    window.addEventListener("click", function () {
        if (userMenu.classList.contains("show")) {
            userMenu.classList.remove("show");
        }
    });
</script>

        </div>
        <nav class="nav container" style="margin-top: 3%;">
    <div class="row">
        <ul class="nav__link nav__link--menu">
            <li class="nav__items">
                <a href="indexusuario.html" class="nav__links nav__button">Inicio</a>
            </li>
            <li class="nav__items">
                <a href="usuariologinrepuestos.php" class="nav__links nav__button">Repuestos</a>
            </li>
            <li class="nav__items">
                <a href="#" class="nav__links nav__button">Archivos 3D</a>
            </li>
            <li class="nav__items">
                <a href="#" class="nav__links nav__button">Servicio de impresión</a>
            </li>
        </ul>
    </div>
</nav>
<div class="col-auto" style="margin-left: auto;">
    <div class="d-flex justify-content-end">
        <div id="cartCount" class="cart-count" style="font-weight: bold; color: #8B0000; font-size: 1.2em;">0</div>
        <div class="mr-3">
            <a href="#" class="nav__links nav__button" id="cartIcon">
                <i class="fas fa-shopping-cart fa-lg"></i>
            </a>
        </div>

<!-- Modal de carrito -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="cartModalLabel">Tu Carrito de Compras</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="cartItems" class="px-4 py-2">
                    <!-- Aquí se insertarán dinámicamente los elementos del carrito -->
                </div>
                <div class="d-flex justify-content-between px-4 py-2">
                    <div class="fw-bold">Total a pagar:</div>
                    <div id="totalPagar" class="fw-bold">$0.00</div> <!-- Elemento para mostrar el total -->
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" onclick="vaciarCarrito()">Vaciar Carrito</button>
                <button type="button" class="btn btn-primary">Ir a Pagar</button>
            </div>
        </div>
    </div>
</div>

<!-- Enlace al archivo JS de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Evento de clic en el icono del carrito
    document.addEventListener("DOMContentLoaded", function() {
        const cartIcon = document.getElementById("cartIcon");
        cartIcon.addEventListener("click", function(event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
            abrirCarritoModal(); // Abre el modal del carrito al hacer clic en el icono del carrito
        });
    });

    // Función para abrir el modal del carrito
    function abrirCarritoModal() {
        // Primero, borra el contenido actual del modal y del total a pagar
        document.getElementById("cartItems").innerHTML = "";
        document.getElementById("totalPagar").innerText = "Total a pagar: $0.00";

        // Luego, recorre los productos en el carrito y agrégalos al modal
        for (var i = 0; i < carrito.length; i++) {
            var producto = carrito[i];
            var itemHTML = "<div>" + producto.nombre + " - $" + producto.precio + "</div>";
            document.getElementById("cartItems").innerHTML += itemHTML;
        }

        // Calcula el total de la compra
        var total = calcularTotal();

        // Actualiza el total en la interfaz
        document.getElementById('totalPagar').innerText = "Total a pagar: $" + total.toFixed(2);

        // Muestra el modal
        var cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
        cartModal.show();
    }

    // Función para calcular el total de la compra
    function calcularTotal() {
        var total = 0;
        // Suma los precios de todos los productos en el carrito
        for (var i = 0; i < carrito.length; i++) {
            total += carrito[i].precio;
        }
        return total;
    }
    function vaciarCarrito() {
        carrito = []; // Vacía el arreglo del carrito
        contadorCarrito = 0; // Reinicia el contador del carrito
        document.getElementById('cartCount').innerText = contadorCarrito; // Actualiza el contador en la interfaz
        // Limpiar el contenido del modal
        document.getElementById('cartItems').innerHTML = '';
        // También puedes agregar lógica adicional aquí, como eliminar los productos del almacenamiento local del navegador
    }
</script>



        <div>
            <div class="input-group input-group-sm rounded-pill custom-search" style="width: 350px;"> <!-- Ajusta el ancho total aquí -->
                <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-search fa-lg"></i>
                </span>
                <input type="text" class="form-control rounded-end" id="searchInput" placeholder="Buscar..." oninput="searchTable()" style="width: 300px;"> <!-- Ajusta el ancho del campo de entrada aquí -->
            </div>
        </div>
    </div>
</div>

<script>
    function searchTable() {
        var input = document.getElementById('searchInput').value.toUpperCase();
        var products = document.getElementsByClassName('product');

        for (var i = 0; i < products.length; i++) {
            var productName = products[i].getElementsByTagName('h2')[0].innerText.toUpperCase();
            var productDescription = products[i].getElementsByTagName('p')[0].innerText.toUpperCase();

            if (productName.indexOf(input) > -1 || productDescription.indexOf(input) > -1) {
                products[i].style.display = '';
            } else {
                products[i].style.display = 'none';
            }
        }
    }
</script>


        <div class="gradient-stripe" style="margin-top: 3%;"></div>
    <h4>Catálogo</h4>
    <div class="product-container" style="margin-top: 2%;">
<?php
// Consulta SQL para obtener los productos
$sql = "SELECT Identificador, Pro_Nombre, Pro_Descripcion, Pro_PrecioVenta, imagen_principal FROM productos WHERE Pro_Categoria = 1 AND Pro_Estado = 'activo'";
$result = mysqli_query($conn, $sql);

// Verificar si se encontraron productos
if (mysqli_num_rows($result) > 0) {
    // Iterar sobre cada producto
    while($row = mysqli_fetch_assoc($result)) {
        // Mostrar información del producto
        echo "<div class='product'>";
        $imageData = base64_encode($row['imagen_principal']);
        // Generar la etiqueta img con la imagen en base64
        echo "<img src='data:image/png;base64, $imageData' alt='Imagen del producto' style='width: 500px; height: 200px;' class='product-image' data-name='" . $row["Pro_Nombre"] . "' data-description='" . $row["Pro_Descripcion"] . "' data-price='" . $row["Pro_PrecioVenta"] . "'>";
        echo "<h2>" . $row["Pro_Nombre"] . "</h2>";
        echo "<p>" . $row["Pro_Descripcion"] . "</p>";
        // Mostrar el precio dentro del cuadro verde
        echo "<div class='green-box'>";
        echo "<p>Precio: $" . $row["Pro_PrecioVenta"] . "</p>";
        echo "</div>";
        // Botón "Agregar a Carrito"
        echo "<button class='btn btn-primary mt-2' onclick='agregarACarrito(\"" . $row["Pro_Nombre"] . "\", " . $row["Pro_PrecioVenta"] . ")'>Agregar a Carrito</button>";
        
        echo "</div>"; // Cerrar el div de la clase 'product'
    }
} else {
    echo "No se encontraron productos.";
}

// Cerrar conexión
mysqli_close($conn);
?>

    </div>
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fixed-size"> <!-- Agrega la clase modal-fixed-size -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="" alt="Imagen del Producto" id="modalProductImage" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <h4 id="modalProductName"></h4>
                        <p id="modalProductDescription"></p>
                        <p id="modalProductPrice"></p>
                        <button class="btn btn-primary" id="addToCartButton">Agregar a Carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enlace al archivo JS de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Función para mostrar el modal con los detalles del producto
    function showProductModal(imageSrc, name, description, price) {
        document.getElementById("modalProductImage").src = imageSrc;
        document.getElementById("modalProductName").innerText = name;
        document.getElementById("modalProductDescription").innerText = description;
        document.getElementById("modalProductPrice").innerText = "Precio: $" + price;
        var modal = new bootstrap.Modal(document.getElementById('productModal'));
        modal.show();
    }

    // Agregar evento de clic y otros eventos a todas las imágenes de producto
    var productImages = document.querySelectorAll('.product-image');
    productImages.forEach(function(image) {
        // Agregar evento clic
        image.addEventListener('click', function() {
            var imageSrc = this.src;
            var name = this.getAttribute('data-name');
            var description = this.getAttribute('data-description');
            var price = this.getAttribute('data-price');
            showProductModal(imageSrc, name, description, price);
        });
        // Agregar evento mouseenter
        image.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer'; // Cambiar cursor a una manita
            this.style.filter = 'brightness(85%)'; // Cambiar el brillo de la imagen
        });
        // Agregar evento mouseleave
        image.addEventListener('mouseleave', function() {
            this.style.filter = 'brightness(100%)'; // Restaurar brillo original de la imagen
        });
    });
</script>

    <footer class="footer">
        <section class="footer__container container">
            <nav class="nav nav--footer">
                <div class="contac-us">
                    <h2 class="contac-us">CONTACTENOS:</h2>
                    <div class="contactactanos">
                        <img src="../images/bxl-whatsapp.svg" alt="">
                        <p>3124672836</p>
                    </div>
                    <div class="contactactanos">
                        <img src="../images/bx email.svg" alt="">
                        <p>rdtrivino6@misena.edu.co</p>
                    </div>
                    <div class="contactactanos">
                        <img src="../images/bx-location-plus.svg" alt="">
                        <p>Email: Calle 15 #31-42 Bogotá, Colombia</p>
                    </div>
                </div>
            </nav>
        </section>        
        <section class="footer__copy container">
            <div class="footer__social">
                <a href="#" class="footer__icons"><img src="../images/facebook.svg" class="footer__img"></a>
                <a href="#" class="footer__icons"><img src="../images/twitter.svg" class="footer__img"></a>
                <a href="#" class="footer__icons"><img src="../images/youtube.svg" class="footer__img"></a>
            </div>
            <h3 class="footer__copyright">Derechos reservados 2023 &copy; MUNDO 3D</h3>
        </section>
    </footer>
</body>
</html>
