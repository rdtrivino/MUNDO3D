<?php
include ("Programas/controlsesion.php");
include __DIR__ . '/../conexion.php';
include __DIR__ . '/../Librerias/phpmailer/Exception.php';
include __DIR__ . '/../Librerias/phpmailer/PHPMailer.php';
include __DIR__ . '/../Librerias/phpmailer/SMTP.php';

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

// Obtener el número total de usuarios
$totalUsuariosResult = mysqli_query($link, "SELECT COUNT(*) as total FROM usuario");
$totalUsuariosRow = mysqli_fetch_assoc($totalUsuariosResult);
$totalUsuarios = $totalUsuariosRow['total'];

// Obtener los parámetros de paginación
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registrosPorPagina = isset($_GET['registrosPorPagina']) ? (int)$_GET['registrosPorPagina'] : 10;
$offset = ($pagina - 1) * $registrosPorPagina;
//Fin parametros de paginacion

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

// Función para generar una contraseña aleatoria
function generarContraseña($longitud = 8)
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+';
    $contraseña = '';
    $maxCaracteres = strlen($caracteres) - 1;
    for ($i = 0; $i < $longitud; $i++) {
        $contraseña .= $caracteres[rand(0, $maxCaracteres)];
    }
    return $contraseña;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Modificar la consulta SQL para incluir LIMIT y OFFSET
$sql = "SELECT Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Rol, Usu_Estado 
        FROM usuario
        LIMIT $registrosPorPagina OFFSET $offset";
        $resultado = mysqli_query($link, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($link));
}

// Verifica si se recibieron los datos del formulario de actualización
if (isset($_POST['id_usuario'])) {
    // Manejo de la actualización del usuario existente
    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    $sql_actualizar = "UPDATE usuario SET Usu_Nombre_completo=?, Usu_Telefono=?, Usu_Email=?, Usu_Ciudad=?, Usu_Direccion=?, Usu_Rol=?, Usu_Estado=? WHERE Usu_Identificacion=?";
    $stmt = mysqli_prepare($link, $sql_actualizar);
    mysqli_stmt_bind_param($stmt, "sssssssi", $nombre, $telefono, $email, $ciudad, $direccion, $rol, $estado, $id_usuario);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: tables.php");
        exit();
    } else {
        echo "Error al actualizar el usuario: " . mysqli_error($link);
    }
    mysqli_stmt_close($stmt);
}

// Inicializar la respuesta
$response = array();

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se recibieron todos los datos del formulario
    if (isset($_POST['Identificacion'], $_POST['nombre'], $_POST['telefono'], $_POST['email'], $_POST['ciudad'], $_POST['direccion'], $_POST['rol'], $_POST['estado'])) {

        // Obtener los datos del formulario
        $identificacion = $_POST['Identificacion'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $ciudad = $_POST['ciudad'];
        $direccion = $_POST['direccion'];
        // Generar la contraseña
        $contraseña = generarContraseña(8); // Longitud de la contraseña: 8 caracteres
        $rol = $_POST['rol'];
        $estado = $_POST['estado'];

        // Cifrar la contraseña para almacenarla en la base de datos
        $contraseña_cifrada = password_hash($contraseña, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Contraseña, Usu_Rol, Usu_Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssss", $identificacion, $nombre, $telefono, $email, $ciudad, $direccion, $contraseña_cifrada, $rol, $estado);

        if (mysqli_stmt_execute($stmt)) {
            // Registro exitoso, enviar correo electrónico con los datos de inicio de sesión
            if (!empty($email)) {
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.hostinger.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'admin@mundo3d.orionweb.site';
                $mail->Password = 'Mundo3D*';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
                $mail->setFrom('admin@mundo3d.orionweb.site', 'MUNDO 3D');
                $mail->addAddress($email, $nombre);
                $mail->Subject = 'Datos de inicio de sesión';
                $mail->Body = "Hola $nombre,\n\nBienvenido a MUNDO 3D.\n\nTu información de inicio de sesión es la siguiente:\n\nCorreo electrónico: $email\nContraseña: $contraseña\n\nTe recomendamos cambiar tu contraseña al ingresar al sistema.\n\nGracias por ser parte de la mejor empresa,\nEquipo de soporte MUNDO 3D";

                if ($mail->send()) {
                    // Envío de correo exitoso
                    $response['success'] = true;
                    $response['message'] = 'El colaborador se ha agregado correctamente.';
                } else {
                    // Error al enviar el correo
                    $response['success'] = false;
                    $response['message'] = 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
                }
            } else {
                // No se proporcionó una dirección de correo electrónico válida
                $response['success'] = false;
                $response['message'] = 'No se proporcionó una dirección de correo electrónico válida.';
            }
        } else {
            // Error al registrar el colaborador en la base de datos
            $response['success'] = false;
            $response['message'] = 'Error al agregar el colaborador: ' . mysqli_error($link);
        }
    } else {
        // No se recibieron todos los datos del formulario
        $response['success'] = false;
        $response['message'] = 'No se recibieron todos los datos del formulario para agregar un nuevo colaborador.';
    }
} else {
    // No se recibió una solicitud POST
    $response['success'] = false;
    //$response['message'] = 'Se esperaba una solicitud POST.';
    $response['message'] = '';
}

// Devolver respuesta como JSON
echo json_encode($response);

