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
    // Obtener los datos del formulario y sanitizar la entrada
    $documento = mysqli_real_escape_string($link, $_POST["Usu_Identificacion"]);
    $nombres = mysqli_real_escape_string($link, $_POST["Usu_Nombre_completo"]);
    $telefono = mysqli_real_escape_string($link, $_POST["Usu_Telefono"]);
    $correo = mysqli_real_escape_string($link, $_POST["Usu_Email"]);
    $ciudad = mysqli_real_escape_string($link, $_POST["Usu_Ciudad"]);
    $direccion = mysqli_real_escape_string($link, $_POST["Usu_Direccion"]);
    $contrasena = $_POST["Usu_Contraseña"];

    // Verificar si el documento de identificación o el correo electrónico ya están registrados
    $verificar_sql = "SELECT Usu_Identificacion, Usu_Email FROM usuario WHERE Usu_Identificacion = '$documento' OR Usu_Email = '$correo'";
    $resultado_verificacion = mysqli_query($link, $verificar_sql);

    if (mysqli_num_rows($resultado_verificacion) > 0) {
        // El documento o el correo ya están registrados
        $response = array("success" => false, "message" => "El usuario con el número de identificación $documento o el correo electrónico $correo ya está registrado.");
        echo json_encode($response);
    } else {
        // Generar un hash de la contraseña
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // El usuario no está registrado, insertar en la base de datos
        $tipo = 3; // Supongamos que el ID 3 corresponde al rol "usuario"

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

