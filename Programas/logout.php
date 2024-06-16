<?php
session_start();

// Destruye todas las variables de sesión
session_destroy();

// Redirige al usuario a la página de inicio o a donde desees
header("Location: redireccionarcerrar.php"); // Cambia "index.php" por la página a la que deseas redirigir
exit;
?>