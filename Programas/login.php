<?php
    session_start();
    include __DIR__ . '/../conexion.php';

    // Verificar si el formulario se ha enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario si están disponibles
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $usuario = $_POST["username"];
            $contrasena = $_POST["password"];

            // Escapar los datos del usuario para prevenir SQL Injection
            $usuario = mysqli_real_escape_string($link, $usuario);

            // Ejecutar una consulta SQL para verificar las credenciales del usuario
            $sql = "SELECT * FROM usuario WHERE Usu_Email = '$usuario'";
            $resultado = mysqli_query($link, $sql);

            if (!$resultado) {
                die("Error en la consulta: " . mysqli_error($link));
            }

            $_SESSION['confirmado'] = false;

            if (mysqli_num_rows($resultado) == 1) {
                // El usuario y la contraseña son correctos
                $user_data = mysqli_fetch_assoc($resultado);

                // Verificar la contraseña utilizando password_verify
                if (password_verify($contrasena, $user_data["Usu_Contraseña"])) {
                    // Contraseña correcta

                    // Iniciar una sesión y establecer variables de sesión
                    $_SESSION["user_id"] = $user_data["Usu_Identificacion"];
                    $_SESSION["username"] = $user_data["Usu_Nombre_completo"];

                    // Establecer la variable para controlar el inicio de sesión
                    $_SESSION['confirmado'] = true;

                    // Redirigir según el rol
                    switch ($user_data["Usu_Rol"]) {
                        case "1":
                            header("Location: ../ADMIN/index.php");
                            break;
                        case "2":
                            header("Location: ../COLABORADOR/index.php");
                            break;
                        case "3":
                            header("Location: ../indexusuario.html");
                            break;
                        default:
                            echo "Rol no válido.";
                            break;
                    }
                    exit;
                } else {
                    echo "Credenciales incorrectas.";
                }
            } else {
                // No se encontró un usuario con ese nombre de usuario (correo electrónico)
                echo "Credenciales incorrectas.";
            }
        }
    }

    // Cerrar la conexión
    mysqli_close($link);
?>
