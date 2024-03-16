<?php
session_start();
require '../conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit(); 
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id']; 

$sql = "SELECT  Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Rol, Usu_Pedidos, Usu_Estado FROM usuario";
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


// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se recibieron todos los datos del formulario
    if (isset($_POST['Identificacion'], $_POST['nombre'], $_POST['telefono'], $_POST['email'], $_POST['ciudad'], $_POST['direccion'], $_POST['contraseña'], $_POST['rol'], $_POST['pedidos'], $_POST['estado'])) {
        // Incluir las clases de PHPMailer
        require '../programas/phpmailer/Exception.php';
        require '../programas/phpmailer/PHPMailer.php';
        require '../programas/phpmailer/SMTP.php';

        // Establecer conexión a la base de datos (reemplaza esto con tus credenciales)
        $servername = "localhost";
        $username = "usuario";
        $password = "";
        $dbname = "nombre_base_de_datos";
        $link = mysqli_connect($servername, $username, $password, $dbname);
        if (!$link) {
            die("Error al conectar a la base de datos: " . mysqli_connect_error());
        }

        // Obtener los datos del formulario
        $identificacion = $_POST['Identificacion'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $ciudad = $_POST['ciudad'];
        $direccion = $_POST['direccion'];
        $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Encriptar la contraseña
        $rol = $_POST['rol'];
        $pedidos = $_POST['pedidos'];
        $estado = $_POST['estado'];

        // Insertar los datos del nuevo colaborador en la base de datos
        $sql = "INSERT INTO usuario (Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Contraseña, Usu_Rol, Usu_Pedidos, Usu_Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssssss", $identificacion, $nombre, $telefono, $email, $ciudad, $direccion, $contraseña, $rol, $pedidos, $estado);

        if (mysqli_stmt_execute($stmt)) {
            // Registro exitoso, enviar correo electrónico con los datos de inicio de sesión
            $subject = "Datos de inicio de sesión";
            $message = "Hola $nombre,\n\nBienvenido al sistema.\n\nTu información de inicio de sesión es la siguiente:\n\nCorreo electrónico: $email\nRol: ";
            switch ($rol) {
                case "1":
                    $message .= "Administrador";
                    break;
                case "2":
                    $message .= "Colaborador";
                    break;
                case "3":
                    $message .= "Cliente";
                    break;
                default:
                    $message .= "Rol no válido";
            }
            $message .= "\n\nPor favor, inicia sesión en el sistema.\n\nGracias,\nEquipo del Sistema";

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'Mundo3D.RYSJ@outlook.com';
            $mail->Password = 'Mundo3D123';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('Mundo3D.RYSJ@outlook.com', 'MUNDO 3D');
            $mail->addAddress($email, $nombre);
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Enviar correo electrónico
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
?>