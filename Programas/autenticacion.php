<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Autenticación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
</head>

<body>
    <!--Ventana Modal-->
    <input type="checkbox" id="btn-modal" checked>
    <div class="container-modal">
        <div class="content-modal">
            <h2>¡Alerta!</h2>
            <p>No has iniciado sesión.</p>
            <div class="btn-cerrar">
                <label for="btn-modal" id="cerrar-modal">Cerrar</label>
            </div>
        </div>
        <label for="btn-modal" class="cerrar-modal"></label>
    </div>
    <!--Fin de Ventana Modal-->

    <script>
        // Al cargar la página, asegúrate de que el modal esté visible
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('btn-modal').checked = true;

            // Agregar evento de clic al botón "Cerrar"
            document.getElementById('cerrar-modal').addEventListener('click', function () {
                window.location.href = '../index.html'; // Redirigir al usuario a la página de inicio
            });
        });
    </script>
</body>

</html>