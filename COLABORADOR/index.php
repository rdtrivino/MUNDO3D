<!DOCTYPE html>
<html>
<head>
    <title>Panel de Colaborador</title>
</head>
<body>
    <?php
        session_start();
        include __DIR__ . '/../conexion.php';
            //Confirmacion de que el usuario ha realizado el proceso de autenticación
            if(!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false){
                die("No ha iniciado sesión !!!");
            }

        echo '<header style="color: white;">Bienvenid@, ' . $_SESSION['username'];   
    ?>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
