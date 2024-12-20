<?php
// Iniciar sesión
session_start();

if (isset($_SESSION["user_id"])) {
    // El usuario ha iniciado sesión, obtén su ID de usuario
    $usuario_id = $_SESSION["user_id"];
    
    // Realiza una conexión a la base de datos y realiza la consulta SQL para obtener el nombre completo
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "mundo3d";

    $link = mysqli_connect($host, $user, $password, $dbname);

    if (!$link) {
        die("Error al conectarse al servidor: " . mysqli_connect_error());
    }

    // Realiza la consulta SQL
    $sql = "SELECT Usu_nombre_completo FROM usuario WHERE Usu_Identificacion = '$usuario_id'";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        $nombreCompleto = $fila["Usu_nombre_completo"];
        
        // Devuelve el nombre completo como respuesta JSON
        echo json_encode(array("nombreCompleto" => $nombreCompleto));
    } else {
        // Error al realizar la consulta
        echo json_encode(array("error" => "Error al obtener el nombre completo del usuario."));
    }

    // Cierra la conexión a la base de datos
    mysqli_close($link);
} else {
    // El usuario no ha iniciado sesión
    echo json_encode(array("error" => "Usuario no autenticado."));
}
?>
