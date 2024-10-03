<?php
session_start();
include __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $usuario = $_POST["username"];
        $contrasena = $_POST["password"];
        
        // Consulta con consulta preparada
        $sql = "SELECT * FROM usuario WHERE Usu_Email = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if (!$resultado) {
            die("Error en la consulta: " . $link->error);
        }

        $_SESSION['confirmado'] = false;

        if ($resultado->num_rows == 1) {
            $user_data = $resultado->fetch_assoc();

            if ($user_data["Usu_Estado"] == "inactivo") {
                echo "<script>alert('Tu cuenta está inactiva. Por favor, contacta al administrador.'); window.location.href = '../index.html';</script>";
            } else {
                if (password_verify($contrasena, $user_data["Usu_Contraseña"])) {
                    $_SESSION["user_id"] = $user_data["Usu_Identificacion"];
                    $_SESSION["username"] = $user_data["Usu_Nombre_completo"];
                    $_SESSION["user_rol"] = $user_data["Usu_Rol"];
                    $_SESSION['confirmado'] = true;

                    header("Location: ../redireccionar.php");
                    exit();
                } else {
                    echo "<script>alert('Credenciales incorrectas.'); window.location.href = '../login.html';</script>";
                }
            }
        } else {
            echo "<script>alert('Credenciales incorrectas.'); window.location.href = '../login.html';</script>";
        }

        $stmt->close();
    }
}

$link->close();
?>
