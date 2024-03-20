<!DOCTYPE html>
<!-- http://localhost/MUNDO 3D/COLABORADOR/editar.php -->
<html lang="en">
<?php
    session_start();
    include __DIR__ . '/../conexion.php';
        //Confirmacion de que el usuario ha realizado el proceso de autenticación
        if(!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false){
            //die("No ha iniciado sesión !!!");
            header("Location: ../Programas/autenticacion.php");
        }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        .link-container {
            margin: 0.5cm;
            display: inline-block;
        }
    </style>
    <link href="form-validation.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="link-container">
    <a href="index.php">
        <img class="#" src="../images/bx-home-alt-2.svg" alt="Home">
    </a>
</div>
<div class="container">
    <div class="py-5 text-center">
        <img class="" src="../images/Logo Mundo 3d.png" alt="" width="150" height="150">
    </div>
    <form class="needs-validation" novalidate method="POST" action="procesaractualizar.php">
        <input type="hidden" class="form-control" id="address2" name="tabla" value="<?php echo $_GET['tabla'] ?>">
        <input type="hidden" class="form-control" id="address2" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        $peticion = "SHOW COLUMNS FROM ".$_GET['tabla'].";";
        $result = mysqli_query($link, $peticion);

        while ($fila = $result->fetch_assoc()) {
            echo '
            <div class="mb-3">
                <label for="address2" style="text-transform:capitalize;">'.$fila['Field'].'<span class="text-muted"></span></label>';
            
            $peticion2 = "SELECT ".$fila['Field']." AS COLUMNA FROM ".$_GET['tabla']." WHERE Identificador = ".$_GET['id'].";";
            $result2 = mysqli_query($link, $peticion2);
            $fila2 = mysqli_fetch_assoc($result2);
            
            if ($fila['Field'] == 'imagen_principal') {
                echo '<img height="150px" src="data:image/jpg;base64,' . base64_encode($fila2['COLUMNA']) . '">';
            } else if ($fila['Field'] == 'Identificador'){
                echo '<input type="text" name="nombre" class="form-control" value="'.$fila2['COLUMNA'].'" disabled></br>';
            } else {
                // Cambiar el tipo de entrada a 'date' para los campos de fecha
                if ($fila['Type'] == 'date') {
                    echo '<input type="date" name="'.$fila['Field'].'" class="form-control" id="address2" value="'.$fila2['COLUMNA'].'">';
                } else {
                    echo '<input type="text" name="'.$fila['Field'].'" class="form-control" id="address2" value="'.$fila2['COLUMNA'].'">';
                }
            }
            echo '</div>';
        }
        ?>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Procesar</button>
    </form>
</div>
<footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2024 MUNDO 3D</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="form-validation.js"></script>
</body>
</html>
