document.addEventListener("DOMContentLoaded", function () {
    // Función para hacer la solicitud AJA
    function obtenerNombreDeUsuario() {
        console.log("Solicitud AJAX en proceso...");
        // Realiza una solicitud AJAX a tu script PHP
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../MUNDO 3D/Programas/get_username.php", true);// Reemplaza con la ruta correcta a tu script PHP
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // La solicitud se completó con éxito
                var respuesta = JSON.parse(xhr.responseText);
                if (respuesta.nombreCompleto) {
                    // Si se obtuvo el nombre completo del usuario, actualiza el elemento HTML
                    document.getElementById("user-name").textContent = respuesta.nombreCompleto;
                }
            }
        }; document.addEventListener("DOMContentLoaded", function () {
            // Función para hacer la solicitud AJAX
            function obtenerNombreDeUsuario() {
                // Realiza una solicitud AJAX a tu script PHP
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "../programas/get_username.php", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // La solicitud se completó con éxito
                            var respuesta = JSON.parse(xhr.responseText);
                            if (respuesta.nombreCompleto) {
                                // Si se obtuvo el nombre completo del usuario, actualiza el elemento HTML
                                document.getElementById("user-name").textContent = respuesta.nombreCompleto;
                            }
                        } else {
                            console.error("Error en la solicitud AJAX: " + xhr.status);
                        }
                    }
                };
                xhr.send();
            }

            // Llama a la función para obtener el nombre de usuario cuando la página se carga
            obtenerNombreDeUsuario();
        });

        xhr.send();
    }

    // Llama a la función para obtener el nombre de usuario cuando la página se carga
    obtenerNombreDeUsuario();
});
