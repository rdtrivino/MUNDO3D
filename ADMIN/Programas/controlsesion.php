<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Confirmación de que el usuario ha realizado el proceso de autenticación
    if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
        header("/../../Programas/autenticacion.php");
        exit(); // Terminamos la ejecución del script después de redirigir
    }

    include __DIR__ . '/../../conexion.php';
    // Realizamos la consulta para obtener el rol del usuario
    $peticion = "SELECT Usu_rol FROM usuario WHERE Usu_Identificacion = '".$_SESSION['user_id']."'";
    $result = mysqli_query($link, $peticion);

    // Verificamos si la consulta tuvo éxito
    if (!$result) {
        // Manejo de errores de consulta
        // Redirigir a la página de autenticación o mostrar un mensaje de error
        header("Location: /../../Programas/autenticacion.php");
        exit(); // Terminamos la ejecución del script después de redirigir
    }

    // Verificamos si la consulta devolvió exactamente un resultado
    if (mysqli_num_rows($result) != 1) {
        // Si la consulta no devuelve un solo resultado, puede ser un problema de base de datos
        // Redirigir a la página de autenticación o mostrar un mensaje de error
        header("Location: /../../Programas/autenticacion.php");
        exit(); // Terminamos la ejecución del script después de redirigir
    }

    // Obtenemos el rol del usuario
    $fila = mysqli_fetch_assoc($result);
    $rolUsuario = $fila['Usu_rol'];

    // Verificar si el rol del usuario es diferente de 2
    if ($rolUsuario != 1) {
        // Si el rol no es 1, redirigir a la página de autenticación
        header("Location: /../../Programas/autenticacion.php");
        exit(); // Terminamos la ejecución del script después de redirigir
    }

    // Si llegamos aquí, el usuario está autenticado y tiene el rol 1
    // Continuar con el resto del código
    $nombreCompleto = $_SESSION['username'];
    $usuario_id = $_SESSION['user_id'];
?>