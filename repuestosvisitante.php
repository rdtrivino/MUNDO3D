<?php
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
    <link rel="shortcut icon" href="./images/Logo Mundo 3d.png" type="image/x-icon">
    <link rel="stylesheet" href="../MUNDO 3D/css/estilosusuarioregistrado.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../MUNDO 3D/repuestosvisitante.html"></script>
    <script src="../MUNDO 3D/js/buscarProductos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
    <title>Repuestos</title>
    <style>
        .modal-fixed-size {
            max-width: 900px;
            width: 100%;
            margin: 0;
            position: fixed;
            top: 10%;
            left: 20%;
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
<body>
    <header class="hero">
        <div class="nav__logo">
            <img src="images/Logo Mundo 3d.png" alt="Logo de la empresa" class="logo">
        </div>
        <nav class="nav container">
            <ul class="nav__link nav__link--menu">
                <li class="nav__items">
                    <a href="index.html" class="nav__links nav__button">Inicio</a>
                </li>
                <li class="nav__items">
                    <a href="Catalogovisitante.php" class="nav__links nav__button">Catálogo</a>
                </li>
                <li class="nav__items">
                    <a href="#" class="nav__links nav__button" id="archivos-3d-link">Archivos 3D</a>
                </li>
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
                <li class="nav__items">
                    <a href="#" class="nav__links nav__button" id="Servicio-de-impresión-link">Servicio de impresión</a>
                </li>
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

               
        </nav>
        <div class="d-flex justify-content-end mt-5 mr-3">
    <div class="input-group input-group-sm rounded-pill custom-search" style="width: 350px; margin-top: 5%;"> <!-- Ajusta el ancho total aquí -->
        <span class="input-group-text" id="basic-addon1">
            <i class="fas fa-search fa-lg"></i>
        </span>
        <input type="text" class="form-control rounded-end" id="searchInput" placeholder="Buscar..." oninput="searchTable()" style="width: 300px;"> <!-- Ajusta el ancho del campo de entrada aquí -->
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
    <script>
    // Función para buscar productos
    function buscarProductos() {
        var input = document.getElementById("search-input").value.toLowerCase();

        // Enviar solicitud al servidor para buscar productos
        fetch('MUNDO 3D\Programas\buscarproducto.php?query=' + input)
            .then(response => response.json())
            .then(data => {
                // Manejar los datos recibidos (en este caso, simplemente imprimirlos en la consola)
                console.log("Resultados de la búsqueda:", data);
            })
            .catch(error => console.error('Error al buscar productos:', error));
    }

    // Llamada a la función buscarProductos() cuando cambia el contenido del campo de búsqueda
    document.getElementById("search-input").addEventListener("input", buscarProductos);
</script>


        <div class="gradient-stripe" style="margin-top: 5%;"></div>
    <h4>REPUESTOS</h4>
    <div class="product-container" style="margin-top: 2%;">
<?php
// Consulta SQL para obtener los productos
$sql = "SELECT Identificador, Pro_Nombre, Pro_Descripcion, Pro_PrecioVenta, imagen_principal FROM productos WHERE Pro_Categoria = 2 AND Pro_Estado = 'activo'";
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

    </div>
    <footer class="footer">
        <section class="footer__container container">
            <nav class="nav nav--footer">
                <div class="contac-us">
                    <h2 class="contac-us">CONTACTENOS:</h2>
                    <div class="contactactanos">
                        <img src="images/bxl-whatsapp.svg" alt="">
                        <p>3124672836</p>
                    </div>
                    <div class="contactactanos">
                        <img src="images/bx email.svg" alt="">
                        <p>rdtrivino6@misena.edu.co</p>
                    </div>
                    <div class="contactactanos">
                        <img src="images/bx-location-plus.svg" alt="">
                        <p>Email: Calle 15 #31-42 Bogotá, Colombia</p>
                    </div>
                </div>
            </nav>
        </section>        
        <section class="footer__copy container">
            <div class="footer__social">
                <a href="#" class="footer__icons"><img src="./images/facebook.svg" class="footer__img"></a>
                <a href="#" class="footer__icons"><img src="./images/twitter.svg" class="footer__img"></a>
                <a href="#" class="footer__icons"><img src="./images/youtube.svg" class="footer__img"></a>
            </div>

            <h3 class="footer__copyright">Derechos reservados 2023 &copy; MUNDO 3D</h3>
        </section>
    </footer>
</body>
</html>
