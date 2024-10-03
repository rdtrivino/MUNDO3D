<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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

        // Verificar si el rol del usuario es diferente de 2
        if ($rolUsuario != 2) {
            // Si el rol no es 2, redirigir a la página de autenticación
            header("Location: ../Programas/autenticacion.php");
            exit(); // Terminamos la ejecución del script después de redirigir
        }
        // Si llegamos aquí, el usuario está autenticado y tiene el rol 2

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
    header("Location: index.php");
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
    <link href="css/estilo.css" rel="stylesheet">
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


        .blocked-field input[readonly] {
            cursor: not-allowed;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        .link-container {
            margin: 0.5cm;
            display: inline-block;
        }
    </style>
</head>

<body style="background: linear-gradient(135deg, #2980b9, #2c3e50); color: white;">
        <a class="Btn-1" href="index.php">
            <div class="sign">
                <img src="../images/iconizer-bx-home-alt-2.2.svg" alt="Inicio">
            </div>
            <div class="text">INICIO</div>
        </a>
    <div class="container mt-5">
        <h2 class="mb-4">Editar Usuario</h2>

        <form id="editForm" method="POST" action="confi.php" class="row">
            <div class="col-md-6 col-sm-12">
                <div class="mb-3 blocked-field">
                    <label for="edit-identificacion" class="form-label">Identificación:</label>
                    <input type="text" class="form-control" name="Usu_Identificacion" id="edit-identificacion"
                        value="<?php echo $identificacion; ?>" readonly title="Este campo no se puede editar">
                    <i class="fas fa-edit edit-icon"></i>
                </div>
                <div class="mb-3 blocked-field">
                    <label for="edit-nombre" class="form-label">Nombre Completo:</label>
                    <input type="text" class="form-control" name="Usu_Nombre_completo" id="edit-nombre"
                        value="<?php echo $nombre; ?>" readonly title="Este campo no se puede editar">
                    <i class="fas fa-edit edit-icon"></i>
                </div>
                <div class="mb-3">
                    <label for="edit-telefono" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" name="Usu_Telefono" id="edit-telefono"
                        value="<?php echo $telefono; ?>">
                    <i class="fas fa-edit edit-icon"></i>
                </div>
                <div class="mb-3">
                    <label for="edit-email" class="form-label">Email:</label>
                    <input type="text" class="form-control" name="Usu_Email" id="edit-email"
                        value="<?php echo $email; ?>">
                    <i class="fas fa-edit edit-icon"></i>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label for="edit-ciudad" class="form-label">Ciudad:</label>
                    <input type="text" class="form-control" name="Usu_Ciudad" id="edit-ciudad"
                        value="<?php echo $ciudad; ?>">
                    <i class="fas fa-edit edit-icon"></i>
                </div>
                <div class="mb-3">
                    <label for="edit-direccion" class="form-label">Dirección:</label>
                    <input type="text" class="form-control" name="Usu_Direccion" id="edit-direccion"
                        value="<?php echo $direccion; ?>">
                    <i class="fas fa-edit edit-icon"></i>
                </div>
                <div class="mb-3">
                    <label for="edit-contrasena" class="form-label">Nueva Contraseña:</label>
                    <input type="password" class="form-control" name="Nueva_Contrasena" id="edit-contrasena">
                    <i class="fas fa-edit edit-icon"></i>
                </div>
                <div class="mb-3">
                    <label for="edit-confirm-contrasena" class="form-label">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" name="Nueva_Contrasena" id="edit-confirm-contrasena"
                        onkeyup="checkPasswordMatch();">
                    <i class="fas fa-edit edit-icon"></i>
                    <div class="invalid-feedback" id="password-error" style="display: none;">Las contraseñas no
                        coinciden.</div>
                </div>
            </div>

            <div class="col-12">
                <button type="button" class="btn btn-danger cancel-btn"
                    onclick="window.location.href='index.php'">Cancelar</button>
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
    </script>


    <!-- Bootstrap JS (opcional, pero necesario para algunas funcionalidades de Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome JS (opcional, pero necesario para los íconos) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
        integrity="sha512-ZvXQm6N5NnTEUKtT+5K/l5qZsHH1Tl0Qy0PvjBq0MBa6dHAsz5Ri9sn4yBYpq7i6miEjzCLODjKue6Gv1OMJLQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function guardarCambios() {
            // Aquí puedes agregar el código para enviar los datos del formulario al servidor mediante AJAX
            // Puedes usar la librería jQuery para simplificar la solicitud AJAX
            // Ejemplo básico con jQuery:
            $.post($("#editForm").attr("action"), $("#editForm").serialize(), function (response) {
                console.log(response);
                window.location.href = 'index.php';
            });

        }
    </script>

</body>

</html>