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
    <link href="css/estilo.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <script src="js/scripts.js"></script>
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
    <?php $tabla = $_GET['tabla'];?>
    
    <a href="index.php?tabla=<?php echo $tabla;?>">
        <img class="home" src="../images/bx-home-alt-2.svg" alt="Home">
    </a>
</div>

<div class="container">
    <div class="py-5 text-center">
        <img class="mundo" src="../images/Logo Mundo 3d.png" alt="" width="150" height="150">
</div>

    <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data" action="procesarnuevo.php?tabla=<?php echo $tabla; ?>">
        <input type="hidden" class="form-control" id="address2" name="tabla" value="<?php echo $_GET['tabla'] ?>">
        <?php if ($_GET['tabla'] == 'pedidos') { ?>

            <div class="form-group">
                <label for="cliente">Cliente (*)</label>
                <select class="form-control" id="cliente" name="cliente">
                    <option value="">Seleccionar cliente</option> <!-- Opción vacía por defecto -->
                    <?php
                    // Realizar la consulta SQL para obtener la lista de clientes
                    $consulta = "SELECT Usu_Identificacion, Usu_Nombre_Completo FROM usuario";
                    $resultado = mysqli_query($link, $consulta);
                    
                    // Verificar si la consulta tuvo éxito y mostrar las opciones
                    if ($resultado && mysqli_num_rows($resultado) > 0) {
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            // Concatenar Identificador y Nombre con un guion (-)
                            $opcion = $fila['Usu_Identificacion'] . ' - ' . $fila['Usu_Nombre_Completo'];
                            echo '<option value="' . $fila['Usu_Identificacion'] . '">' . $opcion . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="estado">Estado (*)</label>
                <select class="form-control" id="estado" name="estado">
                    <option value="">Seleccionar estado del pédido</option>
                    <?php
                        $consulta = "SELECT Es_Codigo, Es_Nombre FROM pedido_estado";
                        $resultado = mysqli_query($link, $consulta);
                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $opcion = $fila['Es_Nombre'];
                                echo '<option value="' . $fila['Es_Codigo'] . '">' . $opcion . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="producto">Producto (*)</label>
                <select class="form-control" id="producto" name="producto">
                    <option value="">Seleccionar el producto</option>
                    <?php
                        $consulta = "SELECT Identificador, Pro_Nombre FROM productos";
                        $resultado = mysqli_query($link, $consulta);
                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $opcion = $fila['Pro_Nombre'];
                                echo '<option value="' . $fila['Identificador'] . '">' . $opcion . '</option>';
                            }
                        }
                    ?>
                </select> 
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad (*)</label>
                <input type="text" class="form-control" id="cantidad" name="cantidad" />
            </div>

            <div class="form-group">
                <label for="fechapedido">Fecha de Pedido (*)</label>
                <input type="date" class="form-control" id="fechapedido" name="fechapedido" /> 
            </div>

            <div class="form-group">
                <label for="fechaentrega">Fecha estimada de entrega</label>
                <input type="date" class="form-control" id="fechaentrega" name="fechaentrega" /> 
            </div>

            <div class="form-group">
                <label for="imagen">Imagen del producto</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">  
            </div>

            <div class="form-group">
                <label for="tipoimpresion">Tipo de impresión</label>
                <select class="form-control" id="tipoimpresion" name="tipoimpresion">
                <option value="No informado">Seleccionar el tipo de impresión</option>
                    <option value="Poliácido Láctico">Poliácido Láctico</option>
                    <option value="Acrilonitrilo Butadieno Estireno">Acrilonitrilo Butadieno Estireno</option>
                    <option value="Tereftalato de Polietileno">Tereftalato de Polietileno</option>
                    <option value="Tereftalato de Polietileno Glicol">Tereftalato de Polietileno Glicol</option>
                    <option value="Nylon">Nylon</option>
                    <option value="Poliestireno de alto impacto">Poliestireno de alto impacto</option>
                    <option value="Elastómero termoplástico o TPE">Elastómero termoplástico o TPE</option>
                    <option value="Filamento Fibra de Carbono">Filamento Fibra de Carbono</option>
                    <option value="Filamento PP Polipropileno">Filamento PP Polipropileno</option>
                </select>
            </div>

            <div class="form-group">
                <label for="color">Color de la impresión</label>
                <select class="form-control" id="color" name="color">
                    <option value="No informado">Seleccionar el color de impresión</option>
                    <option value="Negro Fibra de Carbono">Negro Fibra de Carbono</option>
                    <option value="Blanco Menta">Blanco Menta</option>
                    <option value="Negro Clásico">Negro Clásico</option>
                    <option value="Naranja metálizado">Naranja metálizado</option>
                    <option value="Verde Glass">Verde Glass</option>
                </select>
            </div>

            <div class="form-group">
                <label for="observacion">Observación</label>
                <input type="text" class="form-control" id="observacion" name="observacion" /> 
            </div>
        <?php } elseif ($_GET['tabla'] == 'productos') { ?>


            <div class="form-group">
                <label for="nombre">Nombre (*)</label>
                <input type="text" class="form-control" id="nombre" name="nombre" /> 
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción (*)</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" />
            </div>

            <div class="form-group">
                <label for="categoria">Categoría (*)</label>
                <select class="form-control" id="categoria" name="categoria">
                    <option value="">Seleccionar la categoría del producto</option>
                    <?php
                        $consulta = "SELECT Cgo_Codigo, Cgo_Nombre FROM categoria";
                        $resultado = mysqli_query($link, $consulta);
                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $opcion = $fila['Cgo_Nombre'];
                                echo '<option value="' . $fila['Cgo_Codigo'] . '">' . $opcion . '</option>';
                            }
                        }
                    ?>
                </select> 
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad (*)</label>
                <input type="text" class="form-control" id="cantidad" name="cantidad" />
            </div>

            <div class="form-group">
                <label for="precioventa">Precio de Venta (*)</label>
                <input type="text" class="form-control" id="precioventa" name="precioventa" /> 
            </div>

            <div class="form-group">
                <label for="costo">Costo (*)</label>
                <input type="text" class="form-control" id="costo" name="costo" /> 
            </div>

            <div class="form-group">
                <label for="imagen" class="form-label">Imagen (*)</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*"> 
            </div>

        <?php } ?>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Procesar</button>
                <!-- Modal de confirmacion -->
                    <dialog id="modal">
                        <h2>!Alerta¡</h2>
                        <p>Registro almacenado con éxito</p>
                        <p></p>
                        <button id="btn-cerrar-modal">Cerrar modal</button>
                    </dialog>
                <!----------------------------->
    </form>
</div>

<footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2024 Mundo 3D</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="form-validation.js"></script>
</body>
</html>

