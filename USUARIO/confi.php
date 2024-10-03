<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

<?php include 'conexion.php'; ?>


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
    header("Location: Catalogologin.php");
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

        .font-small,
        .font-medium,
        .font-large {
            background-color: transparent;
            /* Quitar el fondo */
            color: black;
            /* Color de texto blanco */
            font-weight: bold;
            border: none;
            cursor: pointer;
            /* Negrita */
        }

        /* Boton Home */
        .Btn-1 {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: rgb(0, 0, 0);
            margin-top: 10px;
            margin-left: 10px;
        }

        /* plus sign */
        .sign {
            width: 100%;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sign svg {
            width: 17px;
        }

        .sign svg path {
            fill: white;
        }

        /* text */
        .text {
            position: absolute;
            right: -10px;
            /* Ajusta la posición a la derecha, con un margen de 10px */
            opacity: 0;
            /* Cambia la opacidad para hacer visible el texto */
            color: white;
            font-size: 1.2em;
            font-weight: 600;
            transition-duration: .3s;
        }



        /* hover effect on button width */
        .Btn-1:hover {
            width: 125px;
            border-radius: 40px;
            transition-duration: .3s;
        }

        .Btn-1:hover .sign {
            width: 30%;
            transition-duration: .3s;
            padding-left: 20px;
        }

        /* hover effect button's text */
        .Btn-1:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 10px;
        }

        /* button click effect*/
        .Btn-1:active {
            transform: translate(2px, 2px);
        }

        .title-container h2 {
            margin: 0;
            pointer-events: auto;
        }

        .title-container {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
    </style>
</head>

<body style="background: linear-gradient(to bottom right, #dddddd, #dddddd);">
    <a class="Btn-1" href="../Programas/redireccionarpaginas.php?page=impresoras">
        <div class="sign">
            <img src="../images/iconizer-bx-home-alt-2.2.svg" alt="Inicio">
        </div>
        <div class="text">INICIO</div>
    </a>

    <div id="buttons-container"
        style="display: flex; justify-content: flex-end; align-items: center; margin-right: 10px;">
        <div class="button-box">
            <button class="font-small text-black" onclick="disminuirTamano()">A</button>
        </div>
        <div class="button-box">
            <button class="font-medium text-black" onclick="ajustarTamano('medium')">A</button>
        </div>
        <div class="button-box">
            <button class="font-large text-black" onclick="aumentarTamano()">A</button>
        </div>
        <div class="button-box" style="margin-right: 10px;">
            <i class="fas fa-wheelchair fa-lg text-black"></i>
        </div>
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
                    onclick="window.location.href='Catalogologin.php'">Cancelar</button>
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
        var tamanoOriginal = ''; // Variable global para almacenar el tamaño original

        function disminuirTamano() {
            var currentFontSize = parseFloat(document.body.style.fontSize) || 1;
            var newFontSize = currentFontSize - 1 + 'rem';
            document.body.style.fontSize = newFontSize;
        }

        function ajustarTamano(size) {
            switch (size) {
                case 'small':
                    document.body.style.fontSize = 'small';
                    break;
                case 'medium':
                    document.body.style.fontSize = 'medium';
                    break;
                case 'large':
                    document.body.style.fontSize = 'large';
                    break;
                default:
                    break;
            }
        }

        function aumentarTamano() {
            // Aumentar el tamaño de fuente
            var currentFontSize = parseFloat(document.body.style.fontSize) || 1;
            var newFontSize = currentFontSize + 1 + 'rem';
            document.body.style.fontSize = newFontSize;
        }

        function restaurarTamano() {
            // Restaurar el tamaño de fuente al original guardado
            if (tamanoOriginal !== '') {
                document.body.style.fontSize = tamanoOriginal;
            }
        }

        function cambiarCursor(event) {
            event.target.style.cursor = 'pointer';
        }

        function restaurarCursor() {
            document.body.style.cursor = 'default';
        }

        // Guardar el tamaño original al cargar la página
        document.addEventListener('DOMContentLoaded', function () {
            tamanoOriginal = window.getComputedStyle(document.body).fontSize;
        });


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
                window.location.href = 'Catalogologin.php';
            });

        }
    </script>

</body>

</html>
