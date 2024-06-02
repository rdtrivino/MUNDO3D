//aumentar accesibilidad//
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

function checkPasswordMatch() {
    const password = document.getElementById('edit-contrasena').value;
    const confirmPassword = document.getElementById('edit-confirm-contrasena').value;
    const passwordError = document.getElementById('password-error');

    if (password !== confirmPassword) {
        passwordError.style.display = 'block';
    } else {
        passwordError.style.display = 'none';
    }
}

document.querySelector("#disabled-icon .fa-wheelchair").style.color = "#fff";
// modal de ingreso contraseña//
function togglePasswordVisibility() {
    var passwordInput = document.getElementById('password');
    var showIcon = document.querySelector('.show-password-icon');
    var hideIcon = document.querySelector('.hide-password-icon');

    passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';

    showIcon.style.display = (passwordInput.type === 'password') ? 'block' : 'none';
    hideIcon.style.display = (passwordInput.type === 'password') ? 'none' : 'block';
}
document.addEventListener('DOMContentLoaded', function () {
    var btnModal = document.getElementById('btnModal');
    var modal = document.getElementById('myModal');

    var closeBtn = modal.querySelector('.close');

    btnModal.addEventListener('click', function () {
        modal.style.display = 'block';
    });

    closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// alerta de archivos y impresiones 3d//
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
});

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

//buscar producto//
function searchProducts(searchTerm) {
    var products = document.querySelectorAll('.product');

    searchTerm = searchTerm.toUpperCase();

    products.forEach(function (product) {
        var productName = product.querySelector('.card-title').textContent.toUpperCase();
        var productDescription = product.querySelector('.card-text').textContent.toUpperCase();

        if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}
// detalles del producto//
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