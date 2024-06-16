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
//accesibilidad --------------------------------------------------------------------------------------------------
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
//----------------------------------------------------------------------------------------------------
// menu desplegable
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
//vaciar carrito ________________________________________________________________________________________________________
function vaciarCarrito() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "programas/funciones-in-re.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText); // Muestra el mensaje del servidor
            // Actualizar la vista del carrito en la página
            document.getElementById('carritoContenido').innerHTML = '<p>El carrito está vacío.</p>';
            document.getElementById('totalProductos').innerHTML = 'Total a pagar: $0';
        }
    };
    xhr.send("action=vaciar_carrito");
}

// Función para actualizar la cantidad de productos en el carrito
function actualizarCantidad(id, action) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "programas/funciones-in-re.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Recargar la página o actualizar la vista del carrito dinámicamente
            location.reload();
        }
    };
    xhr.send("action=actualizar_cantidad&id=" + id + "&action_type=" + action);
}

// Función para eliminar un producto del carrito
function eliminarProducto(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "programas/funciones-in-re.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText); // Muestra el mensaje del servidor
            location.reload();
        }
    };
    xhr.send("action=eliminar_producto&id=" + id);
}

// Event listeners para los botones del carrito
document.addEventListener("DOMContentLoaded", function() {
    // Incrementar/decrementar cantidad
    document.querySelectorAll("[data-action='increment']").forEach(button => {
        button.addEventListener("click", function() {
            var id = this.getAttribute("data-id");
            actualizarCantidad(id, 'increment');
        });
    });

    document.querySelectorAll("[data-action='decrement']").forEach(button => {
        button.addEventListener("click", function() {
            var id = this.getAttribute("data-id");
            actualizarCantidad(id, 'decrement');
        });
    });

    // Eliminar producto
    document.querySelectorAll("[data-action='remove']").forEach(button => {
        button.addEventListener("click", function() {
            var id = this.getAttribute("data-id");
            eliminarProducto(id);
        });
    });
});

//ir a pagar_______________________________________________________________________________________________________
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
// agregar al carrito__________________________________________________________________________________________________

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
// detalles de producto______________________________________________________________________________
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
