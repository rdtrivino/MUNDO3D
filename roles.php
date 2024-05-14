
<?php
session_start();

// Verificar si el usuario ha iniciado sesión y su rol está definido
if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['confirmado']) && isset($_SESSION['user_rol'])) {
    // Dependiendo del rol del usuario, redirigirlo a su página correspondiente
    switch ($_SESSION['user_rol']) {
        case "1":
            header("Location: ../MUNDO 3D/ADMIN/index.php");
            exit();
        case "2":
            header("Location: ../MUNDO 3D/COLABORADOR/index.php");
            exit();
        case "3":
            header("Location: ../MUNDO 3D/USUARIO/Catalogologin.php");
            exit();
        default:
            echo "Rol no válido.";
            break;
    }
} else {
    // Si el usuario no ha iniciado sesión o su rol no está definido, redirigirlo a la página de inicio de sesión
    header("Location: ../Index.html");
    exit();
}
?>