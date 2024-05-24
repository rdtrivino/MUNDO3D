document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.querySelector('#registroForm');
    const modal = document.getElementById('myModal');
    const closeModalBtn = document.getElementById('closeModal');
    const modalMessage = document.getElementById('modalMessage');

    formulario.addEventListener('submit', function (e) {
        e.preventDefault(); // Evita que la página se recargue

        // Enviar el formulario usando AJAX
        const formData = new FormData(formulario);

        fetch('Programas/registro.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Registro exitoso, mostrar el modal y redirigir después de 3 segundos
                modalMessage.textContent = '¡Registro exitoso!';
                modalMessage.style.color = 'green';
                modal.style.display = 'block';
                closeModalBtn.style.backgroundColor = '#4CAF50'; // Cambia el color a verde

                // Redirigir después de 3 segundos
                setTimeout(function () {
                    window.location.href = 'index.html'; // Cambia 'inicio.html' por la URL de tu página de inicio
                }, 3000); // 3000 milisegundos (3 segundos)
            } else {
                // Mostrar un mensaje de error y cambiar el color del botón a rojo
                modalMessage.textContent = data.message;
                modalMessage.style.color = 'red';
                modal.style.display = 'block';
                closeModalBtn.style.backgroundColor = 'red'; // Cambia el color a rojo
            }
        })
        .catch(error => {
            // Mostrar un mensaje de error en caso de error de red y cambiar el color del botón a rojo
            console.error(error);
            modalMessage.textContent = 'Ocurrió un error al procesar el registro.';
            modalMessage.style.color = 'red';
            modal.style.display = 'block';
            closeModalBtn.style.backgroundColor = 'red'; // Cambia el color a rojo
        });
    });

    // Cerrar el modal sin redirección
    closeModalBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });
});
function adjustFontSize(size) {
            const body = document.body;
            body.classList.remove('font-small', 'font-medium', 'font-large');

            switch(size) {
                case 'small':
                    body.classList.add('font-small');
                    break;
                case 'medium':
                    body.classList.add('font-medium');
                    break;
                case 'large':
                    body.classList.add('font-large');
                    break;
            }
        }

        function aumentarTamano() {
            // Funcionalidad específica para el icono de silla de ruedas
        }

        function cambiarCursor(event) {
            event.target.style.cursor = 'pointer';
        }

        function restaurarCursor(event) {
            event.target.style.cursor = 'default';
        }

        function checkPasswordMatch() {
            const password = document.getElementById('edit-contrasena').value;
            const confirmPassword = document.getElementById('edit-confirm-contrasena').value;
            const passwordError = document.getElementById('password-error');

            if (password !== confirmPassword) {
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        }

        document.querySelector("#disabled-icon .fa-wheelchair").style.color = "#fff";