<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

// Establecer la conexión a la base de datos
$link = mysqli_connect($host, $user, $password, $dbname);

if (!$link) {
    die("Error al conectarse al servidor: " . mysqli_connect_error());
}

// Verificar si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $documento = $_POST["Usu_Identificacion"];
    $nombres = $_POST["Usu_Nombre_completo"];
    $telefono = $_POST["Usu_Telefono"];
    $correo = $_POST["Usu_Email"];
    $ciudad = $_POST["Usu_Ciudad"];
    $direccion = $_POST["Usu_Direccion"];
    $contrasena = $_POST["Usu_Contraseña"];

    // Verificar si el usuario ya está registrado
    $verificar_sql = "SELECT Usu_Identificacion FROM usuario WHERE Usu_Identificacion = '$documento'";
    $resultado_verificacion = mysqli_query($link, $verificar_sql);

    if (mysqli_num_rows($resultado_verificacion) > 0) {
        // El usuario ya está registrado
        $response = array("success" => false, "message" => "El usuario con el número de identificación $documento ya está registrado.");
        echo json_encode($response);
    } else {
        // Generar un hash de la contraseña
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // El usuario no está registrado, insertar en la base de datos
        $tipo = 3; // Supongamos que el ID 1 corresponde al rol "usuario"

        $sql = "INSERT INTO usuario (Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Contraseña, Usu_Rol) VALUES ('$documento', '$nombres', '$telefono', '$correo', '$ciudad', '$direccion', '$hashed_password', $tipo)";

        if (mysqli_query($link, $sql)) {
            $response = array("success" => true);
            echo json_encode($response);
        } else {
            $response = array("success" => false, "message" => "Error al registrar el usuario: " . mysqli_error($link));
            echo json_encode($response);
        }
    }
}

// Cerrar la conexión
mysqli_close($link);
?>
