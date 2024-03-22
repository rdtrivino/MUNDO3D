<?php
session_start();
include __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $usuario = $_POST["username"];
        $contrasena = $_POST["password"];
        $usuario = mysqli_real_escape_string($link, $usuario);

        $sql = "SELECT * FROM usuario WHERE Usu_Email = '$usuario'";
        $resultado = mysqli_query($link, $sql);

        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($link));
        }

        $_SESSION['confirmado'] = false;

        if (mysqli_num_rows($resultado) == 1) {
            $user_data = mysqli_fetch_assoc($resultado);

            if ($user_data["Usu_Estado"] == "inactivo") {
                echo "<script>alert('Tu cuenta está inactiva. Por favor, contacta al administrador.'); window.location.href = '../index.html';</script>";
            } else {
                if (password_verify($contrasena, $user_data["Usu_Contraseña"])) {

                    $_SESSION["user_id"] = $user_data["Usu_Identificacion"];
                    $_SESSION["username"] = $user_data["Usu_Nombre_completo"];

                    $_SESSION['confirmado'] = true;

                    switch ($user_data["Usu_Rol"]) {
                        case "1":
                            header("Location: ../ADMIN/index.php");
                            exit();
                        case "2":
                            header("Location: ../COLABORADOR/index.php");
                            exit();
                        case "3":
                            header("Location: ../USUARIO/indexusuario.html");
                            exit();
                        default:
                            echo "Rol no válido.";
                            break;
                    }
                } else {
                    echo "<script>alert('Credenciales incorrectas.'); window.location.href = '../index.html';</script>";
                }
            }
        } else {
            echo "<script>alert('Credenciales incorrectas.'); window.location.href = '../index.php';</script>";
        }
    }
}

mysqli_close($link);
?>
