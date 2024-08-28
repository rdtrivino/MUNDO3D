<?php
session_start();
include __DIR__ . '/../conexion.php';

// Configurar encabezados para JSON
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Usu_Identificacion"]) && isset($_POST["Usu_Contraseña"])) {
        $usuario = mysqli_real_escape_string($link, $_POST["Usu_Identificacion"]);
        $contrasena = $_POST["Usu_Contraseña"];

        $sql = "SELECT * FROM usuario WHERE Usu_Email = '$usuario'";
        $resultado = mysqli_query($link, $sql);

        if (!$resultado) {
            $response['message'] = "Error en la consulta: " . mysqli_error($link);
        } else {
            if (mysqli_num_rows($resultado) == 1) {
                $user_data = mysqli_fetch_assoc($resultado);

                if ($user_data["Usu_Estado"] == "inactivo") {
                    $response['message'] = 'Tu cuenta está inactiva. Por favor, contacta al administrador.';
                } else {
                    if (password_verify($contrasena, $user_data["Usu_Contraseña"])) {
                        $_SESSION["user_id"] = $user_data["Usu_Identificacion"];
                        $_SESSION["username"] = $user_data["Usu_Nombre_completo"];
                        $_SESSION["user_rol"] = $user_data["Usu_Rol"];
                        $_SESSION['confirmado'] = true;

                        $response['success'] = true;
                        $response['message'] = 'Inicio de sesión correcto.';
                    } else {
                        $response['message'] = 'Credenciales incorrectas.';
                    }
                }
            } else {
                $response['message'] = 'Credenciales incorrectas.';
            }
        }
    } else {
        $response['message'] = 'Datos de entrada faltantes.';
    }
} else {
    $response['message'] = 'Método de solicitud no permitido.';
}

mysqli_close($link);
echo json_encode($response);
