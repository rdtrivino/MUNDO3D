<?php

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include __DIR__ . '/../conexion.php';  // Asegúrate de que el archivo conexión contiene $link
// Incluir la biblioteca PHPMailer y sus excepciones para enviar correos electrónicos
include __DIR__ . '/../Librerias/phpmailer/Exception.php';
include __DIR__ . '/../Librerias/phpmailer/PHPMailer.php';
include __DIR__ . '/../Librerias/phpmailer/SMTP.php';

// Usar el espacio de nombres PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Establecer el tipo de contenido de la respuesta como JSON
header('Content-Type: application/json');

// Inicializar el arreglo de respuesta
$response = array();

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el email enviado en la solicitud POST
    $email = $_POST['email'];

    // Validar el formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['success'] = false;
        $response['message'] = "El correo electrónico ingresado no es válido. Por favor, inténtelo de nuevo.";
    } else {
        // Escapar caracteres especiales en el correo para evitar inyecciones SQL
        $email = mysqli_real_escape_string($link, $email);

        // Generar una nueva contraseña
        $nueva_contrasena = generarNuevaContrasena();

        // Intentar enviar el correo de recuperación
        if (enviarCorreoRecuperacion($email, $nueva_contrasena)) {
            // Encriptar la nueva contraseña
            $hash_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

            // Preparar la consulta para actualizar la contraseña en la base de datos
            $stmt = $link->prepare("UPDATE usuario SET Usu_contraseña = ? WHERE Usu_Email = ?");
            $stmt->bind_param("ss", $hash_contrasena, $email);

            // Ejecutar la consulta y verificar si fue exitosa
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "¡Hemos recibido tu solicitud para restablecer la contraseña! Por favor, verifica tu correo electrónico. Te hemos enviado una nueva contraseña. Si no encuentras nuestro correo electrónico en tu bandeja de entrada, revisa la carpeta de correo no deseado. Gracias por elegirnos.";
            } else {
                $response['success'] = false;
                $response['message'] = "Hubo un error al restablecer la contraseña. Por favor, inténtelo de nuevo.";
            }
            // Cerrar la declaración preparada
            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = "Hubo un error al enviar el correo de recuperación. Por favor, inténtelo de nuevo.";
        }
    }

    // Enviar la respuesta en formato JSON
    echo json_encode($response);
}

// Función para generar una nueva contraseña aleatoria
function generarNuevaContrasena(): string
{
    $length = 10; // Longitud de la contraseña
    $upperChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Caracteres en mayúsculas
    $lowerChars = 'abcdefghijklmnopqrstuvwxyz'; // Caracteres en minúsculas
    $numbers = '0123456789'; // Números
    $specialChars = '!@#\$%\^\&*\()\+=._-'; // Caracteres especiales

    // Garantizar que la contraseña contiene al menos un carácter de cada tipo
    $password = '';
    $password .= $upperChars[random_int(0, strlen($upperChars) - 1)];
    $password .= $lowerChars[random_int(0, strlen($lowerChars) - 1)];
    $password .= $numbers[random_int(0, strlen($numbers) - 1)];
    $password .= $specialChars[random_int(0, strlen($specialChars) - 1)];

    // Completar la longitud de la contraseña con caracteres aleatorios de todos los tipos
    $allChars = $upperChars . $lowerChars . $numbers . $specialChars;
    for ($i = 4; $i < $length; $i++) {
        $password .= $allChars[random_int(0, strlen($allChars) - 1)];
    }

    // Mezclar los caracteres para asegurar un orden aleatorio
    $password = str_shuffle($password);

    // Verificar que la contraseña cumple con los requisitos de mayúsculas y caracteres especiales
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[' . preg_quote($specialChars) . ']/', $password)) {
        return generarNuevaContrasena(); // Volver a generar si no cumple con los requisitos
    }

    return $password;
}

// Función para enviar el correo electrónico de recuperación de contraseña
function enviarCorreoRecuperacion($email, $nueva_contrasena)
{
    $mail = new PHPMailer(true); // Crear una instancia de PHPMailer

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@mundo3d.orionweb.site';
        $mail->Password = 'Mundo3D*';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Seguridad SMTP
        $mail->Port = 465;

        // Configuración del remitente y destinatario
        $mail->setFrom('admin@mundo3d.orionweb.site', 'MUNDO 3D');
        $mail->addAddress($email);

        // Asunto del correo
        $mail->Subject = 'Recuperacion de Contrasena';

        // Cuerpo del mensaje en formato HTML
        $mail->Body = "
                <div style='text-align: center;'>
                    <p>Has solicitado restablecer tu contraseña. Tu nueva contraseña es:<br><br>
                        <strong>$nueva_contrasena</strong>
                    </p>
                    <p>Te recomendamos cambiar tu contraseña después de iniciar sesión por razones de seguridad. 
                        Si no has solicitado este cambio, por favor contáctanos de inmediato.
                    </p>
            
                    <p>Gracias,</p>
                    <p>MUNDO 3D Transformando ideas en realidad tridimensional</p>
                </div>
            ";
        $mail->isHTML(true); // Indicar que el correo es en HTML

        // Enviar el correo
        $mail->send();

        return true; // Retornar verdadero si el correo fue enviado exitosamente
    } catch (Exception $e) {
        // Registrar el error si el correo no pudo ser enviado
        error_log("Error al enviar el correo: {$mail->ErrorInfo}");
        return false; // Retornar falso en caso de error
    }
}
?>
