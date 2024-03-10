<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Crear</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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
    </style>
    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="py-5 text-center">
        <img class="#" src="../images/Logo Mundo 3d.png" alt="" width="150" height="150">
    </div>

    <form class="needs-validation" novalidate method="POST" action="procesarnuevo.php">
        <input type="hidden" class="form-control" id="address2" name="tabla" value="<?php echo $_GET['tabla'] ?>">

        <?php
            include "../conexion.php";

            if (isset($_GET['tabla'])) {
                $peticion = "SHOW COLUMNS FROM " . $_GET['tabla'] . ";";
                $result = mysqli_query($link, $peticion);

                while ($fila = $result->fetch_assoc()) {
                    $campo = $fila['Field'];
                    if ($campo == 'Identificador') {
                        echo '<input type="text" name="nombre" value="'.$campo.'" disabled></br>';
                    } else {
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
<script src="form-validation.js"></script></body>
</html>