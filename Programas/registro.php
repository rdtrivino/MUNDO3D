<?php
include __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST["Usu_Identificacion"];
    $nombres = $_POST["Usu_Nombre_completo"];
    $telefono = $_POST["Usu_Telefono"];
    $correo = $_POST["Usu_Email"];
    $ciudad = $_POST["Usu_Ciudad"];
    $direccion = $_POST["Usu_Direccion"];
    $contrasena = $_POST["Usu_Contraseña"];

    // Verificar si el usuario ya está registrado
    $verificar_sql = "SELECT Usu_Identificacion FROM usuario WHERE Usu_Identificacion = ?";
    $stmt = $link->prepare($verificar_sql);
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('El usuario con el número de identificación $documento ya está registrado.'); window.history.back();</script>";
    } else {
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar el usuario en la base de datos
        $sql = "INSERT INTO usuario (Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Contraseña, Usu_Rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $link->prepare($sql);
        $tipo = 3;
        $stmt->bind_param("sssssssi", $documento, $nombres, $telefono, $correo, $ciudad, $direccion, $hashed_password, $tipo);

        if ($stmt->execute()) {
            echo "<script>window.location.href='confirmacion.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el usuario: " . $link->error . "'); window.history.back();</script>";
        }
    }

    $stmt->close();
    $link->close();
}
?>


