<?php
// Inicia una sesión en PHP para manejar las variables de sesión y mantener el estado del usuario.
session_start();

// Incluye un archivo externo que contiene la conexión a la base de datos.
include __DIR__ . '/../conexion.php';

// Verifica que el método de solicitud sea POST (esto asegura que el formulario fue enviado).
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Comprueba si se han enviado los campos "username" y "password" en el formulario.
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Asigna los valores enviados desde el formulario a variables locales.
        $usuario = $_POST["username"];
        $contrasena = $_POST["password"];
        
        // Consulta SQL preparada para buscar un usuario en la base de datos por su correo electrónico.
        $sql = "SELECT * FROM usuario WHERE Usu_Email = ?";
        $stmt = $link->prepare($sql); // Prepara la consulta para evitar inyección SQL.
        $stmt->bind_param("s", $usuario); // Asocia el correo electrónico a la consulta preparada.
        $stmt->execute(); // Ejecuta la consulta.
        $resultado = $stmt->get_result(); // Obtiene los resultados de la consulta.

        // Verifica si hubo un error al realizar la consulta y termina la ejecución si es el caso.
        if (!$resultado) {
            die("Error en la consulta: " . $link->error);
        }

        // Inicializa la sesión con la variable 'confirmado' como falsa.
        $_SESSION['confirmado'] = false;

        // Comprueba si se encontró exactamente un registro con el correo proporcionado.
        if ($resultado->num_rows == 1) {
            // Obtiene los datos del usuario como un array asociativo.
            $user_data = $resultado->fetch_assoc();

            // Verifica si el usuario está inactivo.
            if ($user_data["Usu_Estado"] == "inactivo") {
                // Si la cuenta está inactiva, muestra una alerta al usuario y lo redirige a la página principal.
                echo "<script>alert('Tu cuenta está inactiva. Por favor, contacta al administrador.'); window.location.href = '../index.html';</script>";
            } else {
                // Verifica que la contraseña ingresada por el usuario coincida con la contraseña cifrada almacenada en la base de datos.
                if (password_verify($contrasena, $user_data["Usu_Contraseña"])) {
                    // Si las credenciales son correctas, se almacenan los datos del usuario en variables de sesión.
                    $_SESSION["user_id"] = $user_data["Usu_Identificacion"];
                    $_SESSION["username"] = $user_data["Usu_Nombre_completo"];
                    $_SESSION["user_rol"] = $user_data["Usu_Rol"];
                    $_SESSION['confirmado'] = true;

                    // Redirige al usuario a la página de redireccionamiento.
                    header("Location: ../redireccionar.php");
                    exit(); // Finaliza la ejecución del script después de redirigir.
                } else {
                    // Si la contraseña no es válida, muestra una alerta y redirige al usuario al formulario de inicio de sesión.
                    echo "<script>alert('Credenciales incorrectas.'); window.location.href = '../login.html';</script>";
                }
            }
        } else {
            // Si no se encontró un usuario con el correo proporcionado, muestra una alerta y redirige al formulario de inicio de sesión.
            echo "<script>alert('Credenciales incorrectas.'); window.location.href = '../login.html';</script>";
        }

        // Cierra la consulta preparada.
        $stmt->close();
    }
}

// Cierra la conexión con la base de datos.
$link->close();
?>
