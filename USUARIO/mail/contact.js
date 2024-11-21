$(function () {
    // Inicializa el formulario de contacto con validación utilizando jqBootstrapValidation.
    $("#contactForm input, #contactForm textarea").jqBootstrapValidation({
        // Impide que el formulario se envíe automáticamente si no pasa las validaciones.
        preventSubmit: true,
        
        // Callback que se ejecuta si ocurre un error durante el envío.
        submitError: function ($form, event, errors) {
            // Puedes agregar lógica aquí si deseas manejar los errores de envío.
        },
        
        // Callback que se ejecuta si el formulario pasa las validaciones y se envía correctamente.
        submitSuccess: function ($form, event) {
            // Impide el comportamiento predeterminado del formulario (como recargar la página).
            event.preventDefault();

            // Obtiene los valores ingresados en los campos del formulario.
            var name = $("input#name").val();       // Nombre del remitente.
            var email = $("input#email").val();     // Correo electrónico del remitente.
            var subject = $("input#subject").val(); // Asunto del mensaje.
            var message = $("textarea#message").val(); // Contenido del mensaje.

            // Deshabilita temporalmente el botón de envío para evitar múltiples clics.
            $this = $("#sendMessageButton");
            $this.prop("disabled", true);

            // Realiza una solicitud AJAX para enviar los datos del formulario al servidor.
            $.ajax({
                // URL al que se enviarán los datos (archivo PHP que procesará el envío).
                url: "contact.php",
                type: "POST", // Método HTTP utilizado.
                data: { // Datos enviados en la solicitud.
                    name: name,
                    email: email,
                    subject: subject,
                    message: message
                },
                cache: false, // Deshabilita el almacenamiento en caché de la solicitud.
                
                // Función que se ejecuta si el servidor responde correctamente.
                success: function () {
                    // Muestra un mensaje de éxito en el elemento con el ID "success".
                    $('#success').html("<div class='alert alert-success'>");
                    $('#success > .alert-success')
                        .html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    $('#success > .alert-success')
                        .append("<strong>Your message has been sent. </strong>");
                    $('#success > .alert-success')
                        .append('</div>');

                    // Resetea el formulario para que quede en blanco.
                    $('#contactForm').trigger("reset");
                },
                
                // Función que se ejecuta si ocurre un error en la solicitud AJAX.
                error: function () {
                    // Muestra un mensaje de error en el elemento con el ID "success".
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger')
                        .html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    $('#success > .alert-danger')
                        .append($("<strong>").text("Sorry " + name + ", it seems that our mail server is not responding. Please try again later!"));
                    $('#success > .alert-danger')
                        .append('</div>');

                    // Resetea el formulario.
                    $('#contactForm').trigger("reset");
                },
                
                // Función que se ejecuta al finalizar la solicitud AJAX (éxito o error).
                complete: function () {
                    // Vuelve a habilitar el botón de envío después de 1 segundo.
                    setTimeout(function () {
                        $this.prop("disabled", false);
                    }, 1000);
                }
            });
        },
        
        // Filtra los campos visibles para la validación (por ejemplo, ignora campos ocultos).
        filter: function () {
            return $(this).is(":visible");
        },
    });

    // Permite alternar entre pestañas en el formulario.
    $("a[data-toggle=\"tab\"]").click(function (e) {
        // Previene el comportamiento predeterminado del enlace.
        e.preventDefault();

        // Muestra la pestaña correspondiente.
        $(this).tab("show");
    });
});

// Limpia cualquier mensaje de éxito o error cuando el usuario enfoca el campo de nombre.
$('#name').focus(function () {
    $('#success').html('');
});
