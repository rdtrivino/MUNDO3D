<?php
// Verifica si alguno de los campos requeridos está vacío o si el correo no es válido.
if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || 
   !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Si hay un error en la validación, responde con un código HTTP 500 (Error del Servidor).
    http_response_code(500);
    exit(); // Termina la ejecución del script.
}

// Obtiene los datos enviados desde el formulario y los procesa para mayor seguridad.
// strip_tags elimina etiquetas HTML o PHP que puedan haber sido inyectadas.
// htmlspecialchars convierte caracteres especiales en entidades HTML para evitar problemas de inyección.
$name = strip_tags(htmlspecialchars($_POST['name']));      // Nombre del remitente.
$email = strip_tags(htmlspecialchars($_POST['email']));    // Correo del remitente.
$m_subject = strip_tags(htmlspecialchars($_POST['subject'])); // Asunto del mensaje.
$message = strip_tags(htmlspecialchars($_POST['message'])); // Contenido del mensaje.

// Configuración del correo electrónico
$to = "info@example.com"; // Dirección de correo donde se enviará el mensaje. Cambiar por la dirección deseada.
$subject = "$m_subject:  $name"; // Asunto del correo, que incluye el asunto enviado por el usuario y su nombre.
$body = "You have received a new message from your website contact form.\n\n". "Here are the details:\n\n". "Name: $name\n\n\n". "Email: $email\n\n". "Subject: $m_subject\n\n". "Message: $message";

// Encabezados del correo
$header = "From: $email"; // Indica que el correo fue enviado desde el correo del usuario.
$header .= "Reply-To: $email"; // Incluye la opción de responder directamente al correo del remitente.

if(!mail($to, $subject, $body, $header)) {
    // Si la función `mail` falla, responde con un código HTTP 500.
    http_response_code(500);
}
?>
