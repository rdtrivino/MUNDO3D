<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = mysqli_connect($host, $user, $password);

if (!$link) {
    die("Error al conectarse al servidor: " . mysqli_connect_error());
}

if (!mysqli_select_db($link, $dbname)) {
    die("Error al conectarse a la Base de Datos: " . mysqli_error($link));
}

// Verificar que la sesión esté iniciada y que las variables de sesión estén configuradas
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // Redirigir o manejar la falta de sesión según sea necesario
    die("Error: Sesión no iniciada");
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar e inicializar las variables
    $telefono = mysqli_real_escape_string($link, $_POST['Usu_Telefono']);
    $email = mysqli_real_escape_string($link, $_POST['Usu_Email']);
    $ciudad = mysqli_real_escape_string($link, $_POST['Usu_Ciudad']);
    $direccion = mysqli_real_escape_string($link, $_POST['Usu_Direccion']);

    // Verificar si se proporcionó una nueva contraseña
// Verificar si se proporcionó una nueva contraseña
    if (!empty($_POST['Nueva_Contrasena'])) {
        // Cifrar la nueva contraseña
        $nuevaContrasena = password_hash($_POST['Nueva_Contrasena'], PASSWORD_DEFAULT);

        // Actualizar los datos en la base de datos con la nueva contraseña cifrada
        $updateSql = "UPDATE usuario SET Usu_Telefono=?, Usu_Email=?, Usu_Ciudad=?, Usu_Direccion=?, Usu_Contraseña=? WHERE Usu_Identificacion=?";
        $stmt = mysqli_prepare($link, $updateSql);
        mysqli_stmt_bind_param($stmt, "ssssss", $telefono, $email, $ciudad, $direccion, $nuevaContrasena, $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        // No se proporcionó una nueva contraseña, actualizar otros datos sin modificar la contraseña
        $updateSql = "UPDATE usuario SET Usu_Telefono=?, Usu_Email=?, Usu_Ciudad=?, Usu_Direccion=? WHERE Usu_Identificacion=?";
        $stmt = mysqli_prepare($link, $updateSql);
        mysqli_stmt_bind_param($stmt, "sssss", $telefono, $email, $ciudad, $direccion, $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Puedes redirigir al usuario a otra página después de guardar cambios si es necesario
    header("Location: ../index.php");
    exit();
}

// Consultar datos del usuario
$usuario_id = mysqli_real_escape_string($link, $_SESSION['user_id']);
$sql = "SELECT Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Contraseña FROM usuario WHERE Usu_Identificacion = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $usuario_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $identificacion, $nombre, $telefono, $email, $ciudad, $direccion, $contrasena);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-9p0s5vZJMaCC6Tj41/l5pD5Khv2n/bqm5iWVX7fI7YdZCtazjfw7szNTL8l+ZYMlUE/GlbVfLqFsIcunPsfaUg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="../css/estilo.css" rel="stylesheet">
    <style>
        .container {
            position: relative;
            z-index: 1;
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
            text-align: left;
            color: #000;
        }

        h2 {
            font-size: 36px;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            background: linear-gradient(to right, #36D1DC, #5B86E5);
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 20px;
        }

        .cancel-btn {
            background-color: #ff4d4d;
            color: #fff;
            float: right;
            /* Coloca el botón Cancelar en la esquina derecha */
        }

        /* Estilo para la clase de campo bloqueado */
        .blocked-field input {
            background-color: #ccc;
            color: #555;
        }

        /* Estilo para el ícono de editar */
        .edit-icon {
            color: #28a745;
            /* Color verde para el ícono de editar */
            margin-left: 5px;
        }

        .home-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            cursor: pointer;
            z-index: 999;
        }

        .home-icon img {
            width: 50px;
            height: 50px;
            background-color: white;
            padding: 5px;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .blocked-field input[readonly] {
            cursor: not-allowed;
        }

        .text-white {
            color: white;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .mr-3 {
            margin-right: 1rem;
        }

        .font-small {
            font-size: 14px;
        }

        .font-medium {
            font-size: 16px;
        }

        .font-large {
            font-size: 20px;
        }

        #buttons-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body style="background: linear-gradient(135deg, #2980b9, #2c3e50); color: white;">

    <div class="">
        <a class="Btn-1" href="../index.php">
            <div class="sign">
                <img src="../../images/iconizer-bx-home-alt-2.2.svg" alt="Inicio">
            </div>
            <div class="text">INICIO</div>
        </a>
    </div>

    <div id="buttons-container" style="display: flex; justify-content: flex-end; align-items: center;">
        <a href="#" class="font-small text-white font-weight-bold mr-3" onclick="adjustFontSize('small')">A</a>
        <a href="#" class="font-medium text-white font-weight-bold mr-3" onclick="adjustFontSize('medium')">A</a>
        <a href="#" class="font-large text-white font-weight-bold mr-3" onclick="adjustFontSize('large')">A</a>

    </div>
    <div class="container mt-5">
        <h2 class="mb-4">Editar Usuario</h2>

        <form id="editForm" method="POST" action="confi.php" class="row">
            <div class="col-md-6 col-sm-12">
                <div class="mb-3 blocked-field">
                    <label for="edit-identificacion" class="form-label">Identificación:</label>
                    <input type="text" class="form-control" name="Usu_Identificacion" id="edit-identificacion"
                        value="<?php echo $identificacion; ?>" readonly title="Este campo no se puede editar">
                </div>
                <div class="mb-3 blocked-field">
                    <label for="edit-nombre" class="form-label">Nombre Completo:</label>
                    <input type="text" class="form-control" name="Usu_Nombre_completo" id="edit-nombre"
                        value="<?php echo $nombre; ?>" readonly title="Este campo no se puede editar">
                </div>
                <div class="mb-3">
                    <label for="edit-telefono" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" name="Usu_Telefono" id="edit-telefono"
                        value="<?php echo $telefono; ?>">
                </div>
                <div class="mb-3">
                    <label for="edit-email" class="form-label">Email:</label>
                    <input type="text" class="form-control" name="Usu_Email" id="edit-email"
                        value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label for="edit-ciudad" class="form-label">Ciudad:</label>
                    <input type="text" class="form-control" name="Usu_Ciudad" id="edit-ciudad"
                        value="<?php echo $ciudad; ?>">
                </div>
                <div class="mb-3">
                    <label for="edit-direccion" class="form-label">Dirección:</label>
                    <input type="text" class="form-control" name="Usu_Direccion" id="edit-direccion"
                        value="<?php echo $direccion; ?>">
                </div>
                <div class="mb-3">
                    <label for="edit-contrasena" class="form-label">Nueva Contraseña:</label>
                    <input type="password" class="form-control" name="Nueva_Contrasena" id="edit-contrasena">
                </div>
                <div class="mb-3">
                    <label for="edit-confirm-contrasena" class="form-label">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" name="Nueva_Contrasena" id="edit-confirm-contrasena"
                        onkeyup="checkPasswordMatch();">
                    <div class="invalid-feedback" id="password-error" style="display: none;">Las contraseñas no
                        coinciden.</div>
                </div>
            </div>

            <div class="col-12">
                <button type="button" class="btn btn-danger cancel-btn"
                    onclick="window.location.href='../index.php'">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar Cambios</button>
            </div>
        </form>
    </div>


    <script>
        function checkPasswordMatch() {
            var password = document.getElementById("edit-contrasena").value;
            var confirmPassword = document.getElementById("edit-confirm-contrasena").value;
            var error = document.getElementById("password-error");

            if (password !== confirmPassword) {
                error.style.display = "block";
            } else {
                error.style.display = "none";
            }
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
        integrity="sha512-ZvXQm6N5NnTEUKtT+5K/l5qZsHH1Tl0Qy0PvjBq0MBa6dHAsz5Ri9sn4yBYpq7i6miEjzCLODjKue6Gv1OMJLQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function guardarCambios() {
            $.post($("#editForm").attr("action"), $("#editForm").serialize(), function (response) {
                console.log(response);
                window.location.href = '../index.php';
            });

        }
    </script>

</body>

</html>