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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="programas/im-pr.css">
    <link rel="stylesheet" type="text/css" href="css/icon.css">
    <link rel="stylesheet" type="text/css" href="css/menu.css">

     <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<?php include './programas/funciones-in-re.php'; //Conexión a la base de datos ?>

    <!-- Topbar Start -->
    <div class="container-fluid py-3" style="background-color: #3386ff;">
        <div class="row">
            <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
                <!-- Icono de usuario -->
                <div class="d-inline-flex align-items-center">
                    <i class="fas fa-user fa-lg text-white mr-2"></i>
                    <!-- Texto de bienvenida y nombre de usuario -->
                    <div class="text-white" id="user-name">
                        Bienvenid@: <?php echo $nombreCompleto; ?>
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
                                <!-- Icono para aumentar la letra -->
                                <div id="buttons-container" style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="#" class="font-small text-white font-weight-bold mr-3" onclick="adjustFontSize('small')">A</a>
                                <a href="#" class="font-medium text-white font-weight-bold mr-3" onclick="adjustFontSize('medium')">A</a>
                                <a href="#" class="font-large text-white font-weight-bold mr-3" onclick="adjustFontSize('large')">A</a>

                                <div id="disabled-icon" style="position: relative;">
                                    <!-- Ícono de lupa con mensaje personalizado al pasar el mouse -->
                                    <i class="fas fa-wheelchair fa-lg text-white"
                                    data-tooltip="Ampliar vista"
                                    onclick="aumentarTamano()"
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
                                        Swal.fire({
                                            title: '¿Estás seguro?',
                                            text: "¿Realmente quieres cerrar sesión?",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#616970',
                                            confirmButtonText: 'Sí, cerrar sesión',
                                            cancelButtonText: 'Cancelar'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // Redirige al script de cierre de sesión
                                                window.location.href = "../Programas/logout.php";
                                            }
                                        });
                                    }
                                </script>
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <style>
        #logout-button:hover {
            cursor: pointer;
        }
    </style>
    <!-- Navbar Start -->
    <div class="" style="background-color: #3386ff;">
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
            </nav>
        </div>
    </div>
    <!--Fin del  Navbar -->
    <div class="page-header container-fluid bg-secondary pt-0 pt-lg-1 pb-1 mb-4">
        <div class="row align-items-center py-4">
            <div class="col-md-6 offset-md-6 text-center text-md-right">
            </div>
        </div>
    </div>
    </div>
    <!-- Formulario para Pedido -->
    <div class="container-fluid" style="background-color: #D3D3D3; margin-top: -30px;">
        <div class="container">
            <h1 class="display-4 text-center mb-5">Explore e imprima el que más le guste</h1>
            <div class="row">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-primary btn-custom" data-toggle="modal"
                        data-target="#preciosModal">
                        Conoce nuestros precios
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade custom-modal-size" id="preciosModal" tabindex="-1" role="dialog"
                    aria-labelledby="preciosModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="preciosModalLabel">Nuestros Precios</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Aquí puedes colocar la tabla con los precios -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Volumen de pieza</th>
                                            <th>Fechas de entrega </th>
                                            <th>Precio estimado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>filamento</td>
                                            <td>1-cm3</td>
                                            <td>5 min a 15 min</td>
                                            <td>$15.000</td>
                                        </tr>
                                        <tr>
                                            <td>Resina</td>
                                            <td>1-cm3</td>
                                            <td>3 min a 10 min</td>
                                            <td>$20.000</td>
                                        </tr>
                                        <!-- Agrega más filas según sea necesario -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .custom-modal-size .modal-dialog {
                        max-width: 80%;
                        /* Cambia el porcentaje según desees */
                        margin: 1.75rem auto;
                        /* Puedes ajustar el margen según sea necesario */
                    }

                    .btn-custom {
                        background-color: #FF5733;
                        /* Cambia el color de fondo */
                        border-color: #FF5733;
                        /* Cambia el color del borde */
                        color: white;
                        /* Cambia el color del texto */
                        font-weight: bold;
                        /* Añade negrita al texto */
                        /* Agrega otros estilos según sea necesario */
                    }
                </style>
                <div class="col-lg-12">
                    <form action="#" method="POST" enctype="multipart/form-data" id="solicitudForm">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nombrePedido">Nombre del Pedido:</label>
                                    <input type="text" class="form-control" id="nombrePedido" name="nombrePedido"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="tipoImpresion">Tipo de Impresión:</label>
                                    <select class="form-control" id="tipoImpresion" name="tipoImpresion" required>
                                        <option value="filamento">Filamento</option>
                                        <option value="resina">Resina</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="archivoImpresion">Archivo a Imprimir (máx. 500 KB):</label>
                                    <input type="file" class="form-control-file" id="archivoImpresion"
                                        name="archivoImpresion" required>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color" id="unicoColor"
                                            value="unicoColor" checked>
                                        <label class="form-check-label" for="unicoColor">
                                            Único Color
                                            <i class="fas fa-question-circle text-black ml-2" data-toggle="tooltip"
                                                data-placement="top" title="Este color será únicamente negro"></i>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color" id="colorOriginal"
                                            value="colorOriginal">
                                        <label class="form-check-label" for="colorOriginal">
                                            Color Original
                                            <i class="fas fa-question-circle text-black ml-2" data-toggle="tooltip"
                                                data-placement="top" title="Color Original de la imagen"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cantidad">Cantidad:</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" id="cantidad" name="cantidad"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comentarios">Comentarios:</label>
                                    <textarea class="form-control" id="comentarios" name="comentarios"
                                        rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group text-center">
                                    <label for="imagenPrevia"style="margin: 4%">Imagen a Imprimir:</label>
                                    <img src="../ADMIN/images/Logo Mundo 3d.png" alt="Imagen Previa" id="imagenPrevia"
                                        style="max-width: 80%; height: auto;">
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3 mb-5">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        label,
        input,
        select,
        textarea {
            color: black !important;
        }

        .btn-primary {
            color: white !important;
        }
    </style>

    <!-- Agrega el modal de confirmación -->
    <div class="modal fade" id="confirmacionModal" tabindex="-1" aria-labelledby="confirmacionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmacionModalLabel">Pedido Enviado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¡Tu solicitud se ha registrado con éxito!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Verifica si la variable de sesión 'pedido_enviado' está definida
        <?php if (isset($_SESSION['pedido_enviado']) && $_SESSION['pedido_enviado']): ?>
            // Si está definida y es true, muestra el modal de confirmación
            $(document).ready(function () {
                $('#confirmacionModal').modal('show');
            });
            // Redirecciona al usuario a la página de confirmación después de mostrar el modal
            setTimeout(function () {
                window.location.href = 'serviciodeimpresion.php';
            }, 5000); // Redirecciona después de 3 segundos (3000 milisegundos)
            <?php
            // Limpia la variable de sesión después de usarla
            unset($_SESSION['pedido_enviado']);
        endif;
        ?>
    </script>
    
    <script>
    $(document).ready(function () {
        // Función para mostrar la imagen previa
        function mostrarImagenPrevia(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagenPrevia').attr('src', e.target.result);
                    // Almacenar la URL de la imagen en el almacenamiento local
                    localStorage.setItem('imagenPrevia', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Mostrar la imagen previa al cargar la página, si existe en el almacenamiento local
        //   var imagenPreviaGuardada = localStorage.getItem('imagenPrevia');
        //     if (imagenPreviaGuardada) {
        //     $('#imagenPrevia').attr('src', imagenPreviaGuardada);
        // }

        // Manejar el cambio en el campo de entrada de archivo
        $('#archivoImpresion').change(function () {
            mostrarImagenPrevia(this);
        });
    });
</script>
    
    <!--Inicio de el Footer-->
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
                        <a href="//www.instagram.com/mundo3d.rysj/" target="_blank"
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
                        <a href="//www.facebook.com/profile.php?id=61559444922903" target="_blank"
                            rel="noopener noreferrer">
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
                    <div class="child child-4" data-title="WhatsApp">
                        <a href="https://web.whatsapp.com/" target="_blank" rel="noopener noreferrer">
                            <button id="button1" class="button btn-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 30 508 512" height="1em" fill="#25D366">
                                    <path d="M380.9 97.1c-40.9-40.9-95.8-63.1-154.1-63.1-120.4 0-218.6 98.2-218.6 218.6 0 38.4 9.9 76.4 29 109.7L0 512l151.4-40.2c33.7 18.5 71.3 28.3 110.3 28.3 120.4 0 218.6-98.2 218.6-218.6 0-58.3-23.1-113.1-65.1-155.2zm-154.1 344.3c-33.5 0-66.2-8.8-95.1-25.3l-6.8-4-70.6 18.7 18.8-68.9-4.3-7.1c-18.6-30.3-28.4-65.7-28.4-102.2 0-106.1 86.2-192.3 192.3-192.3 51.4 0 99.8 20 136.1 56.3s56.3 84.7 56.3 136.1c0 106.1-86.2 192.3-192.3 192.3zm101.7-138.7c-5.5-2.7-32.6-16.1-37.7-17.9-5.1-1.8-8.8-2.7-12.5 2.7-3.7 5.5-14.3 17.9-17.6 21.6-3.2 3.7-6.5 4.1-12 1.4-5.5-2.7-23.2-8.5-44.2-27.1-16.4-14.6-27.4-32.7-30.6-38.2-3.2-5.5-.3-8.5 2.4-11.2 2.5-2.6 5.5-6.8 8.2-10.3 2.7-3.7 3.7-6.3 5.5-10.8 1.8-4.5.9-8.2-.5-11.1-1.4-2.7-12.5-30.1-17.1-41.1-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.8-.2-10.3-.2s-9.3 1.3-14.1 6.8c-4.8 5.5-18.6 18.2-18.6 44.5s19.1 51.6 21.8 55.1c2.7 3.7 37.4 57.2 90.7 80.1 12.7 5.5 22.6 8.8 30.3 11.3 12.7 4 24.4 3.4 33.7 2 10.3-1.5 31.6-12.9 36-25.4 4.5-12.5 4.5-23.2 3.2-25.4-1.3-2.3-5-3.7-10.5-6.5z"/>
                                </svg>
                        </a>
                        </button>
                    </div> 
                </div>
            </div>
            <style>
        .parent2 {
            width: 47%;
            height: 40%;
        }
            </style>
            <div class="col-lg-4 col-md-6 mb-5">
                <h4 class="text-white mb-4">Ponerse en contacto</h4>
                <p>Contactanos para tener el gusto de atenderlos.</p>
                <p><i class="fa fa-map-marker-alt mr-2"></i>Calle 15 #31-42 Bogotá, Colombia</p>
                <p><i class="fa fa-envelope mr-2"></i>rdtrivino6@misena.edu.co</p>
            </div>
    
                    <div class="col-lg-4 col-md-6 mb-5">

                        <h4 class="text-white mb-4">Enlaces Rápidos</h4>

                    <div  class="d-flex flex-column justify-content-start">

                    <a class="text-white mb-2" href="Catalogologin.php"><i class="fa fa-angle-right mr-2"></i>IMPRESORAS</a>
                    <a class="text-white mb-2" href="Respuestoslogin.php"><i class="fa fa-angle-right mr-2"></i>REPUESTOS</a>
                    <a class="text-white mb-2" href="Archivos3dlogin.php"><i class="fa fa-angle-right mr-2"></i>ARCHIVOS 3D</a>
                    <a class="text-white" href="serviciodeimpresion.php"><i class="fa fa-angle-right mr-2"></i>SERVICIO DE IMPRESION</a>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="container-fluid bg-dark text-white py-4 px-sm-3 px-md-5">
    <p class="m-0 text-center text-white">
        &copy; <a class="text-white font-weight-medium" href="#">MUNDO 3D</a>. Todos los derechos reservados <?php echo date('Y'); ?>
    </p>
    </div>

    <!--fin del Footer -->

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
    <script src="js/limitacionkg.js"></script>

</body>

</html>