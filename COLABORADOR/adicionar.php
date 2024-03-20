<!DOCTYPE html>
<!-- http://localhost/MUNDO 3D/COLABORADOR/adicionar.php -->
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear</title>
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
        <img class="#" src="../images/Logo Mundo 3d.png" alt="" width="150" height="150">
    </div>

    <form class="needs-validation" novalidate method="POST" action="procesarnuevo.php">
        <input type="hidden" class="form-control" id="address2" name="tabla" value="<?php echo $_GET['tabla'] ?>">

        <?php
        if (isset($_GET['tabla'])) {
            $peticion = "SHOW COLUMNS FROM " . $_GET['tabla'] . ";";
            $result = mysqli_query($link, $peticion);

            while ($fila = $result->fetch_assoc()) {
                $campo = $fila['Field'];

                // Si el campo es 'Pe_Cliente', mostramos una lista desplegable con los identificadores de la tabla 'usuario'
                if ($campo == 'Pe_Cliente') {
                    echo '<div class="mb-3">
                            <label for="Pe_Cliente" style="text-transform: capitalize;">Cliente<span class="text-muted"></span></label>
                            <select class="form-control" id="Pe_Cliente" name="Pe_Cliente" required>';
                    // Consultamos los identificadores de la tabla 'usuario'
                    $query = "SELECT Identificador FROM usuario";
                    $result_usuario = mysqli_query($link, $query);

                    // Agregamos opciones al select
                    while ($row_usuario = mysqli_fetch_assoc($result_usuario)) {
                        echo '<option value="' . $row_usuario['Identificador'] . '">' . $row_usuario['Identificador'] . '</option>';
                    }

                    echo '</select></div>';
                } elseif ($campo != 'Identificador') {
                    // Resto del código para los campos que no son 'Pe_Cliente' ni 'Identificador'
                    $tipoInput = 'text';
                    if ($campo == 'Pe_Fechapedido' || $campo == 'Pe_Fechaentrega') {
                        $tipoInput = 'date';
                    } elseif ($campo == 'imagen_principal') {
                        $tipoInput = 'file';
                    }

                    echo '
                        <div class="mb-3">
                            <label for="' . $campo . '" style="text-transform: capitalize;">' . $campo . '<span class="text-muted"></span></label>
                            <input type="' . $tipoInput . '" class="form-control" id="' . $campo . '" name="' . $campo . '" placeholder="Ingrese ' . $campo . '" required>
                        </div>
                    ';
                }
            }
        }
        ?>

        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Procesar</button>
    </form>
</div>

<footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2024 Orion ERP</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="form-validation.js"></script>
</body>
</html>

