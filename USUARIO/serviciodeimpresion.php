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

$link = mysqli_connect($host, $user, $password, $dbname);

if (!$link) {
    die("Error al conectarse al servidor: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre de usuario de la sesión
    $cliente = $_SESSION["user_id"];

    // Obtener los demás datos del formulario
    $nombrePedido = $_POST["nombrePedido"];
    $tipoImpresion = $_POST["tipoImpresion"];
    $color = $_POST["color"];
    $observaciones = $_POST["comentarios"];
    $cantidad = $_POST["cantidad"];

    // Procesar la imagen subida
    $nombreArchivo = $_FILES['archivoImpresion']['name'];
    $nombreTemporal = $_FILES['archivoImpresion']['tmp_name'];
    $tamanioArchivo = $_FILES['archivoImpresion']['size'];

    // Leer el contenido del archivo en bytes
    $imagenBinaria = file_get_contents($nombreTemporal);

    // Escapar caracteres especiales en la imagen binaria
    $imagenBinaria = mysqli_real_escape_string($link, $imagenBinaria);

    // Obtener la fecha actual
    date_default_timezone_set('America/Bogota');
    $fechaPedido = date("Y-m-d");

    // Calcular la fecha de entrega según el tipo de impresión
    if ($tipoImpresion == 'filamento') {
        $fechaEntrega = date("Y-m-d", strtotime($fechaPedido . "+7 days"));
    } elseif ($tipoImpresion == 'resina') {
        $fechaEntrega = date("Y-m-d", strtotime($fechaPedido . "+17 days"));
    }

    // Verificar si el estado 1 existe en la tabla de estados de pedido
    $sql_estado = "SELECT Es_Codigo FROM pedido_estado WHERE Es_Codigo = 1";
    $resultado_estado = mysqli_query($link, $sql_estado);

    // Si el estado 1 no existe, insertarlo
    if (mysqli_num_rows($resultado_estado) == 0) {
        $sql_insert_estado = "INSERT INTO pedido_estado (Es_Codigo, Es_Descripcion) VALUES (1, 'Estado 1')";
        mysqli_query($link, $sql_insert_estado);
    }

    // Preparar la consulta SQL para insertar los datos en la tabla de pedidos
    $sql = "INSERT INTO pedidos (Pe_Cliente, pe_nombre_pedido, pe_tipo_impresion, pe_imagen_pedido, pe_color, Pe_Observacion, Pe_Cantidad, Pe_Estado, Pe_FechaPedido, Pe_FechaEntrega) VALUES ('$cliente', '$nombrePedido', '$tipoImpresion', '$imagenBinaria', '$color', '$observaciones', '$cantidad', 1, '$fechaPedido', '$fechaEntrega')";

    // Ejecutar la consulta
    if (mysqli_query($link, $sql)) {
        // Después de ejecutar la consulta con éxito
        $_SESSION['pedido_enviado'] = true;
    } else {
        echo "Error al insertar datos: " . mysqli_error($link);
    }
}

mysqli_close($link);
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
                    <!-- Texto de bienvenida y nombre de usuario -->
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
                    padding: 10px 20px;
                    /* Aumenta el padding para hacer el recuadro más grande */
                    border: 1px solid #ffffff;
                    border-radius: 10px;
                    /* Aumenta el radio de borde para hacer el recuadro más redondeado */
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
                    padding: 20px;
                    /* Aumenta el padding para hacer el recuadro más grande */
                    border-radius: 10px;
                    /* Aumenta el radio de borde para hacer el recuadro más redondeado */
                    z-index: 1000;
                    /* Ajusta el z-index para que esté por encima */
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
                    color: #ffffff;
                    /* Cambia el color del texto al pasar el mouse */
                    text-decoration: none !important;
                    /* Quita el subrayado al pasar el ratón */
                }

                /* Estilo para el botón de cerrar sesión al pasar el ratón */
                #logout-button:hover {
                    cursor: pointer;
                }

                /* Estilo para alinear a la derecha */
                .align-right {
                    margin-left: auto;
                }

                /* ETILOS DE ACCESIBILIDAD*/
                .font-small {
                    font-size: 14px;
                }

                .font-medium {
                    font-size: 16px;
                }

                .font-large {
                    font-size: 20px;
                }

                #disabled-icon {
                    display: inline-block;
                    /* Para alinear verticalmente con los enlaces */
                }

                a {
                    text-decoration: none;
                    /* Eliminar subrayado de los enlaces */
                }
            </style>
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
    <style>
        #logout-button:hover {
            cursor: pointer;
        }
    </style>
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
    <!-- Navbar End -->
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
                                            <th>Tiempo de impresion</th>
                                            <th>Fechas de entrega </th>
                                            <th>Precio estimado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>filamento</td>
                                            <td>10 kg</td>
                                            <td> 05 Horas</td>
                                            <td>De 5 a 7 dias</td>
                                            <td>$600.000</td>
                                        </tr>
                                        <tr>
                                            <td>Resina</td>
                                            <td>8 kg</td>
                                            <td> 15 Horas</td>
                                            <td>De 1 a 2 semanas</td>
                                            <td>$960.000</td>
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
                                    <label for="archivoImpresion">Archivo a Imprimir:</label>
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
                                <div class="form-group text-right">
                                    <label for="imagenPrevia">Imagen a Imprimir:</label>
                                    <img src="#" alt="Imagen Previa" id="imagenPrevia"
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
                    ¡Tu pedido ha sido enviado con éxito!
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
         $(document).  ready(function () {
          // Funci  ón para mostrar la imagen previa
          function mos  trarImagenPrevia(input) {
              if (inpu  t.files && input.files[0]) {
                  var   reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imagenPrevia').attr('src', e.target.result);
                        // Almacenar la URL de la imagen en el almacenamiento local
                        localStorage.setItem('imagenPrevia', e.target.result);
                }
                    reader.readAsDataURL(input.files[0]);
                }
            }
    
            // Mostrar la imagen previa al cargar la página, si existe en el almacenamiento local
        var imagenPreviaGuardada = localStorage.getItem('imagenPrevia');
            if (imagenPreviaGuardada) {
                $('#imagenPrevia').attr('src', imagenPreviaGuardada);
        }
    
                // Manejar el cambio en el campo de entrada de archivo
            $('#archivoImpresion').change(function () {
            mostrarImagenPrevia(this);
            });
        });
    </script>
    
  <!-- Footer   Start -->
    
                    
                <div class="container-fluid bg-primary text-white px-sm-3 px-md-5" style="margin-top: auto; margin-bottom: 0;">
                   
    <div cla    ss="row pt-5">
         <div cla   ss="col-lg-4 col-md-6 mb-5">
             <a h   ref=""><h1 class="text-secondary mb-3"><span class="text-white">MUNDO</span>3D</h1></a>
             <p>¡Adén   trate en un mundo tridimensional como nunca antes! ¡Bienvenid@ nuestra página 3D, donde tus sueños cobran vida!</p>
             <div class="   parent2">
                  <!--rede  s sociales html-->
                  <div class="  child child-2" data-title="Instagram">

                                                         <a href="htt  ps://www.instagram.com/" target="_blank"
                           rel="noopene r noreferrer"><!--ruta de la pagina de instagram-->
                           <button  id="button1" class="button btn-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="#ff00ff">
                                    <path
                                        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                    </path>
                                </svg>
                        </a>
                    </bu    tton>
                </div>
    
                                                       <div class="child child-4" data-title="Facebook">
                     <a href="https:/   /www.facebook.com/" target="_blank" rel="noopener noreferrer">
                          <button   id="button1" class="button btn-4">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="#4267B2">
                                    <path
                                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                                    </path>
                                </svg>
                    </a>
                        </button>
                    </div>
                </div>
    
        </di    v>
            <div class="col-lg-4 col-md-6 mb-5">
                <h4 class="text-white mb-4">Ponerse en contacto</h4>
                <p>Contactanos para tener el gusto de atenderlos.</p>
                <p><i class="fa fa-map-marker-alt mr-2"></i>Calle 15 #31-42 Bogotá, Colombia</p>
                <p><i class="fab fa-whatsapp mr-2"></i>3124672836</p>
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
    <sty    le>
            .parent2 {
            width: 30%;
            height: 50%;
        display: flex;
        justify-content: center;
            align-items: center;
     }
    
    
        .chi   ld {
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
        
    .chi    ld:hover {
            background-color: black;
            background-position: -100px 100px, -100px 100px;
        transform: rotate3d(0.5, 1, 0, 30deg);
            transform: perspective(180px) rotateX(60deg) translateY(2px);
            box-shadow: 0px 10px 10px rgb(1, 49, 182);
     }
    
        #but   ton1 {
            border: none;
            background-color: white;
            width: 50px;
        height: 50px;
            font-size: 20px;
            border-radius: 50%;
       }
    
        #but ton1:hover {
            width: inherit;
            height: inherit;
            display: flex;
            justify-content: center;
            align-items: center;
        transform: translate3d(0px, 0px, 15px) perspective(180px) rotateX(-35deg) translateY(2px);
            border-radius: 100%;
            background-color: white;
    }
        
    /* E    stilos para el texto */
     .chi   ld::before {
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
    </st    yle>

               <!--redes sociales html-->
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