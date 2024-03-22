<?php
require_once ('../conexion.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['success'] = false;
        $response['message'] = "El correo electrónico ingresado no es válido. Por favor, inténtelo de nuevo.";
    } else {
        $email = mysqli_real_escape_string($link, $email);

        $nueva_contrasena = generarNuevaContrasena();

        if (enviarCorreoRecuperacion($email, $nueva_contrasena)) {
            $hash_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

            $stmt = $link->prepare("UPDATE usuario SET Usu_contraseña = ? WHERE Usu_Email = ?");
            $stmt->bind_param("ss", $hash_contrasena, $email);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "¡Hemos recibido tu solicitud para restablecer la 
                                        contraseña! Por favor, verifica tu correo electrónico. 
                                        Te hemos enviado una nueva contraseña. Si no encuentras nuestro correo electrónico
                                        en tu bandeja de entrada, revisa la carpeta de correo no deseado. Gracias por elegirnos.";
            } else {
                $response['success'] = false;
                $response['message'] = "Hubo un error al restablecer la contraseña. Por favor, inténtelo de nuevo.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Hubo un error al enviar el correo de recuperación. Por favor, inténtelo de nuevo.";
        }
    }

    echo json_encode($response);
}

function generarNuevaContrasena(): string {
    $length = 10;
    $bytes = random_bytes($length);
    return substr(bin2hex($bytes), 0, $length);
}

function enviarCorreoRecuperacion($email, $nueva_contrasena) {
    $mail = new PHPMailer(true);

    try {
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
        $mail->addAddress($email);

        $mail->Subject = 'Recuperacion de Contrasena';

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
            $mail->isHTML(true);
            
        $mail->send();

        return true;
    } catch (Exception $e) {
        error_log("Error al enviar el correo: {$mail->ErrorInfo}");
        return false;
    }
}
?>
