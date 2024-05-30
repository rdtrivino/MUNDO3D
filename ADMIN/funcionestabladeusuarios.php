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

// Verificar si el rol del usuario es diferente de 1
if ($rolUsuario != 1) {
    // Si el rol no es 1, redirigir a la página de autenticación
    header("Location: ../Programas/autenticacion.php");
    exit(); // Terminamos la ejecución del script después de redirigir
}

// Si llegamos aquí, el usuario está autenticado y tiene el rol 1
// Continuar con el resto del código
$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

require '../conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

$sql = "SELECT  Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Rol, Usu_Estado FROM usuario";
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
        // Incluir las clases de PHPMailer
        require '../programas/phpmailer/Exception.php';
        require '../programas/phpmailer/PHPMailer.php';
        require '../programas/phpmailer/SMTP.php';

        // Obtener los datos del formulario
        $identificacion = $_POST['Identificacion'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $ciudad = $_POST['ciudad'];
        $direccion = $_POST['direccion'];
        // Generar la contraseña
        $contraseña = generarContraseña(8); // Longitud de la contraseña: 12 caracteres
        $rol = $_POST['rol'];
        $estado = $_POST['estado'];

        // Cifrar la contraseña para almacenarla en la base de datos
        $contraseña_cifrada = password_hash($contraseña, PASSWORD_DEFAULT);

        // Insertar los datos del nuevo colaborador en la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mundo3d";
        $link = mysqli_connect($servername, $username, $password, $dbname);
        if (!$link) {
            $response['success'] = false;
            $response['message'] = "Error al conectar a la base de datos: " . mysqli_connect_error();
            echo json_encode($response);
            exit;
        }

        $sql = "INSERT INTO usuario (Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Contraseña, Usu_Rol, Usu_Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssss", $identificacion, $nombre, $telefono, $email, $ciudad, $direccion, $contraseña_cifrada, $rol, $estado);

        if (mysqli_stmt_execute($stmt)) {
            // Registro exitoso, enviar correo electrónico con los datos de inicio de sesión
            if (!empty($email)) {
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.office365.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'Mundo3D.RYSJ@outlook.com';
                $mail->Password = 'Mundo3D123';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
                $mail->setFrom('Mundo3D.RYSJ@outlook.com', 'MUNDO 3D');
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
        mysqli_stmt_close($stmt);
        mysqli_close($link); // Cerrar conexión a la base de datos
    } else {
        // No se recibieron todos los datos del formulario
        $response['success'] = false;
        $response['message'] = 'No se recibieron todos los datos del formulario para agregar un nuevo colaborador.';
    }
} else {
    // No se recibió una solicitud POST
    $response['success'] = false;
    $response['message'] = 'Se esperaba una solicitud POST.';
}

// Devolver respuesta como JSON
echo json_encode($response);

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