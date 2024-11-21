<?php
// Se incluye un archivo externo que gestiona la conexión a la base de datos.
require_once ('../conexion.php');

// Se utiliza la biblioteca PHPMailer para enviar correos electrónicos.
// Se incluyen los archivos necesarios de PHPMailer.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

// Define que las respuestas devueltas por este script serán en formato JSON.
header('Content-Type: application/json');

// Se inicializa un array que contendrá la respuesta a enviar al cliente.
$response = array();

// Verifica si la solicitud se realizó mediante el método POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el correo electrónico enviado desde el formulario.
    $email = $_POST['email'];

    // Validación del formato del correo electrónico utilizando un filtro predefinido.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Si el correo no es válido, se genera una respuesta con error.
        $response['success'] = false;
        $response['message'] = "El correo electrónico ingresado no es válido. Por favor, inténtelo de nuevo.";
    } else {
        // Escapa caracteres especiales para evitar ataques de inyección SQL.
        $email = mysqli_real_escape_string($link, $email);

        // Genera una nueva contraseña aleatoria.
        $nueva_contrasena = generarNuevaContrasena();

        // Intenta enviar el correo de recuperación al usuario.
        if (enviarCorreoRecuperacion($email, $nueva_contrasena)) {
            // Si el correo se envió correctamente, se cifra la nueva contraseña.
            $hash_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

            // Prepara la consulta SQL para actualizar la contraseña en la base de datos.
            $stmt = $link->prepare("UPDATE usuario SET Usu_contraseña = ? WHERE Usu_Email = ?");
            $stmt->bind_param("ss", $hash_contrasena, $email);

            // Ejecuta la consulta y verifica si fue exitosa.
            if ($stmt->execute()) {
                // Respuesta positiva indicando que la contraseña se actualizó y el correo fue enviado.
                $response['success'] = true;
                $response['message'] = "¡Hemos recibido tu solicitud para restablecer la 
                                        contraseña! Por favor, verifica tu correo electrónico. 
                                        Te hemos enviado una nueva contraseña. Si no encuentras nuestro correo electrónico
                                        en tu bandeja de entrada, revisa la carpeta de correo no deseado. Gracias por elegirnos.";
            } else {
                // Respuesta de error en caso de fallo al actualizar la contraseña.
                $response['success'] = false;
                $response['message'] = "Hubo un error al restablecer la contraseña. Por favor, inténtelo de nuevo.";
            }
        } else {
            // Respuesta de error si no se pudo enviar el correo electrónico.
            $response['success'] = false;
            $response['message'] = "Hubo un error al enviar el correo de recuperación. Por favor, inténtelo de nuevo.";
        }
    }

    // Envía la respuesta en formato JSON al cliente.
    echo json_encode($response);
}

// Función para generar una nueva contraseña aleatoria.
function generarNuevaContrasena(): string {
    // Define la longitud de la contraseña.
    $length = 10;

    // Genera una cadena aleatoria de bytes.
    $bytes = random_bytes($length);

    // Convierte los bytes a una cadena hexadecimal y recorta a la longitud deseada.
    return substr(bin2hex($bytes), 0, $length);
}

// Función para enviar un correo electrónico con la nueva contraseña al usuario.
function enviarCorreoRecuperacion($email, $nueva_contrasena) {
    // Crea una nueva instancia de PHPMailer.
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP para el envío del correo.
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com'; // Servidor de correo de Outlook.
        $mail->SMTPAuth = true;             // Habilita la autenticación SMTP.
        $mail->Username = 'Mundo3D.RYSJ@outlook.com'; // Correo electrónico del remitente.
        $mail->Password = 'Mundo3D123';     // Contraseña del remitente.
        $mail->SMTPSecure = 'tls';          // Tipo de seguridad (TLS).
        $mail->Port = 587;                  // Puerto de conexión para TLS.
        $mail->CharSet = 'UTF-8';           // Conjunto de caracteres para el correo.
        $mail->Encoding = 'base64';         // Codificación del contenido del correo.

        // Configura el remitente del correo.
        $mail->setFrom('Mundo3D.RYSJ@outlook.com', 'MUNDO 3D');
        // Añade el destinatario (correo del usuario).
        $mail->addAddress($email);

        // Asunto del correo electrónico.
        $mail->Subject = 'Recuperacion de Contrasena';

        // Contenido del correo en formato HTML.
        $mail->Body = "
                <div style='text-align: center;'>
                    <p>Has solicitado restablecer tu contraseña. Tu nueva contraseña es:<br><br>
                        <strong>$nueva_contrasena</strong>. 
                    </p>
                    <p>Te recomendamos cambiar tu contraseña después de iniciar sesión por razones de seguridad. 
                        Si no has solicitado este cambio, por favor contáctanos de inmediato.
                    </p>
            
                    <p>Gracias,</p>
                    <p>MUNDO 3D Transformando ideas en realidad tridimensional</p>
                </div>
            ";
        $mail->isHTML(true); // Indica que el correo tiene formato HTML.

        // Envía el correo.
        $mail->send();

        // Si no hay excepciones, retorna éxito.
        return true;
    } catch (Exception $e) {
        // Registra el error si ocurre una excepción al enviar el correo.
        error_log("Error al enviar el correo: {$mail->ErrorInfo}");
        return false;
    }
}
?>
