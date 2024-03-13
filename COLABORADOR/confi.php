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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-9p0s5vZJMaCC6Tj41/l5pD5Khv2n/bqm5iWVX7fI7YdZCtazjfw7szNTL8l+ZYMlUE/GlbVfLqFsIcunPsfaUg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Estilo para el fondo 3D con figuras geométricas y fondo de imagen */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Coloca el fondo detrás de otros elementos */
            background: linear-gradient(to bottom right, red, blue, red, blue);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 80%);
        }

        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: url('path/to/your-image.png') repeat; /* Puedes reemplazar esto con una imagen de fondo */
            clip-path: polygon(0 0, 100% 0, 100% 80%, 0% 100%);
        }

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
            float: right; /* Coloca el botón Cancelar en la esquina derecha */
        }

        /* Agrega formas geométricas en 3D */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(to bottom right, red, blue, red, blue);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 80%);
        }

        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: url('path/to/your-image.png') repeat;
            clip-path: polygon(0 0, 100% 0, 100% 80%, 0% 100%);
        }

        /* Estilo para la clase de campo bloqueado */
        .blocked-field input {
            background-color: #ccc;
            color: #555;
        }

        /* Estilo para el ícono de editar */
        .edit-icon {
            color: #28a745; /* Color verde para el ícono de editar */
            margin-left: 5px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Editar Usuario</h2>

    <!-- Formulario para editar datos del usuario -->
    <form id="editForm" method="POST" action="confi.php">
        <!-- Agrega tus campos de formulario aquí -->
        <div class="mb-3 blocked-field">
            <label for="edit-identificacion" class="form-label">Identificación:</label>
            <input type="text" class="form-control" name="Usu_Identificacion" id="edit-identificacion" value="<?php echo $identificacion; ?>" readonly>
            <i class="fas fa-edit edit-icon"></i>
        </div>
        <div class="mb-3 blocked-field">
            <label for="edit-nombre" class="form-label">Nombre Completo:</label>
            <input type="text" class="form-control" name="Usu_Nombre_completo" id="edit-nombre" value="<?php echo $nombre; ?>" readonly>
            <i class="fas fa-edit edit-icon"></i>
        </div>
        <div class="mb-3">
            <label for="edit-telefono" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" name="Usu_Telefono" id="edit-telefono" value="<?php echo $telefono; ?>">
            <i class="fas fa-edit edit-icon"></i>
        </div>
        <div class="mb-3">
            <label for="edit-email" class="form-label">Email:</label>
            <input type="text" class="form-control" name="Usu_Email" id="edit-email" value="<?php echo $email; ?>">
            <i class="fas fa-edit edit-icon"></i>
        </div>
        <div class="mb-3">
            <label for="edit-ciudad" class="form-label">Ciudad:</label>
            <input type="text" class="form-control" name="Usu_Ciudad" id="edit-ciudad" value="<?php echo $ciudad; ?>">
            <i class="fas fa-edit edit-icon"></i>
        </div>
        <div class="mb-3">
            <label for="edit-direccion" class="form-label">Dirección:</label>
            <input type="text" class="form-control" name="Usu_Direccion" id="edit-direccion" value="<?php echo $direccion; ?>">
            <i class="fas fa-edit edit-icon"></i>
        </div>
        <div class="mb-3">
            <label for="edit-nueva-contrasena" class="form-label">Nueva Contraseña:</label>
            <input type="password" class="form-control" name="Nueva_Contrasena" id="edit-nueva-contrasena">
            <i class="fas fa-edit edit-icon"></i>
        </div>


        <button type="button" class="btn btn-danger cancel-btn" onclick="window.location.href='index.php'">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar Cambios</button>
    </form>
</div>

<!-- Bootstrap JS (opcional, pero necesario para algunas funcionalidades de Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- FontAwesome JS (opcional, pero necesario para los íconos) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-ZvXQm6N5NnTEUKtT+5K/l5qZsHH1Tl0Qy0PvjBq0MBa6dHAsz5Ri9sn4yBYpq7i6miEjzCLODjKue6Gv1OMJLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function guardarCambios() {
        // Aquí puedes agregar el código para enviar los datos del formulario al servidor mediante AJAX
        // Puedes usar la librería jQuery para simplificar la solicitud AJAX
        // Ejemplo básico con jQuery:
            $.post($("#editForm").attr("action"), $("#editForm").serialize(), function(response) {
                console.log(response);
                window.location.href = 'index.php';
            });

    }
</script>

</body>
</html>


</body>
</html>


