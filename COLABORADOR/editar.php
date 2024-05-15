<!DOCTYPE html>
<!-- http://localhost/MUNDO 3D/COLABORADOR/editar.php -->
<html lang="en">
<?php
        session_start();
        include __DIR__ . '/../conexion.php';

        // Confirmación de que el usuario ha realizado el proceso de autenticación
        if (!isset($_SESSION['confirmado']) || $_SESSION['confirmado'] == false) {
            header("Location: ../Programas/autenticacion.php");
            exit(); // Terminamos la ejecución del script después de redirigir
        }

        // Realizamos la consulta para obtener el rol del usuario
        $peticion = "SELECT Usu_rol FROM usuario WHERE Usu_Identificacion = '".$_SESSION['user_id']."'";
        $result = mysqli_query($link, $peticion);

        // Verificamos si la consulta tuvo éxito
        if (!$result) {
            // Manejo de errores de consulta
            // Redirigir a la página de autenticación o mostrar un mensaje de error
            header("Location: ../Programas/autenticacion.php");
            exit(); // Terminamos la ejecución del script después de redirigir
        }

        // Verificamos si la consulta devolvió exactamente un resultado
        if (mysqli_num_rows($result) != 1) {
            // Si la consulta no devuelve un solo resultado, puede ser un problema de base de datos
            // Redirigir a la página de autenticación o mostrar un mensaje de error
            header("Location: ../Programas/autenticacion.php");
            exit(); // Terminamos la ejecución del script después de redirigir
        }

        // Obtenemos el rol del usuario
        $fila = mysqli_fetch_assoc($result);
        $rolUsuario = $fila['Usu_rol'];

        // Verificar si el rol del usuario es diferente de 2
        if ($rolUsuario != 2) {
            // Si el rol no es 2, redirigir a la página de autenticación
            header("Location: ../Programas/autenticacion.php");
            exit(); // Terminamos la ejecución del script después de redirigir
        }

        // Si llegamos aquí, el usuario está autenticado y tiene el rol 2
        // Continuar con el resto del código
        $nombreCompleto = $_SESSION['username'];
        $usuario_id = $_SESSION['user_id'];
    ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
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
    <?php $tabla = $_GET['tabla']?>
    <?php $id = $_GET['id']?>
    <a href="index.php?tabla=<?php echo $tabla;?>">
        <img class="#" src="../images/bx-home-alt-2.svg" alt="Home">
    </a>
</div>
<div class="container">
    <div class="py-5 text-center">
        <img class="" src="../images/Logo Mundo 3d.png" alt="" width="150" height="150">
    </div>
    <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data" action="procesaractualizar.php?tabla=<?php echo $tabla; ?>&id=<?php echo $id; ?>">
        <input type="hidden" class="form-control" id="address2" name="tabla" value="<?php echo $_GET['tabla']; ?>">

        <?php
        // Verificar si se ha enviado un formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Aquí maneja la actualización de los datos del usuario y redirección
            // Después de procesar los datos del formulario
        } else {
            // Mostrar el formulario de edición
            if (isset($_GET['id'])) {
                $Identificador = $_GET['id'];
                // Consulta SQL para obtener los datos de la tabla
                if ($_GET['tabla'] == 'pedidos') {
                    $peticion1 = "SELECT * FROM pedidos WHERE Identificador = $Identificador";
                    $result = mysqli_query($link, $peticion1);
                    if ($result && $fila = mysqli_fetch_assoc($result)) {

                        // Consulta SQL para obtener los datos de la tabla Usuario
                        $queryUsuarios = "SELECT Usu_Identificacion, Usu_Nombre_completo FROM Usuario";
                        $resultUsuarios = mysqli_query($link, $queryUsuarios);

                        // Consulta SQL para obtener los datos de la tabla Estado
                        $queryEstado = "SELECT Es_Codigo, Es_Nombre FROM pedido_estado";
                        $resultEstado = mysqli_query($link, $queryEstado);

                        // Consulta SQL para obtener los datos de la tabla productos
                        $queryProducto = "SELECT Identificador, Pro_Nombre FROM productos";
                        $resultProducto = mysqli_query($link, $queryProducto);

                        echo '

                        <div class="form-group">
                            <label for="cliente_select">Cliente</label>
                            <select class="form-control" id="cliente_select" name="cliente_select">';

                        // Agregar opciones a la lista desplegable
                        while ($usuario = mysqli_fetch_assoc($resultUsuarios)) {
                            $selected = ($usuario['Usu_Identificacion'] == $fila['Pe_Cliente']) ? 'selected' : '';
                            echo '<option value="' . $usuario['Usu_Identificacion'] . '" ' . $selected . '>' . $usuario['Usu_Identificacion'] . ' - ' . $usuario['Usu_Nombre_completo'] . '</option>';
                        }

                        echo '</select>
                        </div>

                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select class="form-control" id="estado_select" name="estado_select">';
                        // Agregar opciones a la lista desplegable
                        while ($estado = mysqli_fetch_assoc($resultEstado)) {
                            $selected = ($estado['Es_Codigo'] == $fila['Pe_Estado']) ? 'selected' : '';
                            echo '<option value="' . $estado['Es_Codigo'] . '" ' . $selected . '>' . $estado['Es_Nombre'] . '</option>';
                        }

                        echo '</select>

                        </div>

                        <div class="form-group">
                            <label for="producto">Producto</label>
                            <select class="form-control" id="producto_select" name="producto_select">'; 
                        // Agregar opciones a la lista desplegable
                        while ($producto = mysqli_fetch_assoc($resultProducto)) {
                            $selected = ($producto['Identificador'] == $fila['Pe_Producto']) ? 'selected' : '';
                            echo '<option value="' . $producto['Identificador'] . '" ' . $selected . '>' . $producto['Pro_Nombre'] . '</option>';
                        }

                        echo '</select>
                        </div>

                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad" name="cantidad" value="' . $fila['Pe_Cantidad'] . '"/>
                        </div>

                        <div class="form-group">
                            <label for="fechapedido">Fecha de Pedido</label>
                            <input type="date" class="form-control" id="fechapedido" name="fechapedido" value="' . $fila['Pe_Fechapedido'] . '"/> 
                        </div>

                        <div class="form-group">
                            <label for="fechaentrega">Fecha de Entrega</label>
                            <input type="date" class="form-control" id="fechaentrega" name="fechaentrega" value="' . $fila['Pe_Fechaentrega'] . '"/> 
                        </div>

                        <div class="form-group">
                            <label for="imagen">Imagen Actual</label>
                            <img src=' . $fila['nombre_imagen'] . ' alt="" style="width: 200px; height: 200px;">
                            <label for="imagen">Nueva Imagen
                                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="tipo">Tipo de impresión</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" value="' . $fila['pe_tipo_impresion'] . '"/> 
                        </div>

                        <div class="form-group">
                        <label for="color">Color del producto</label>
                            <input type="text" class="form-control" id="color" name="color" value="' . $fila['pe_color'] . '"/> 
                        </div>

                        <div class="form-group">
                            <label for="observacion">Observación</label>
                            <input type="text" class="form-control" id="observacion" name="observacion" value="' . $fila['Pe_Observacion'] . '"/> 
                        </div>';
                    }
                } elseif ($_GET['tabla'] == 'productos') {
                    $peticion2 = "SELECT * FROM productos WHERE Identificador = $Identificador";
                    $result = mysqli_query($link, $peticion2);
                    if ($result && $fila = mysqli_fetch_assoc($result)) {
                        // Consulta SQL para obtener los datos de la tabla categoria
                        $queryCategoria = "SELECT Cgo_Codigo, Cgo_Nombre FROM categoria";
                        $resultCategoria = mysqli_query($link, $queryCategoria);

                        echo '
                        <div class="form-group">
                            <label for="identificador">Identificador</label>
                            <input type="text" class="form-control" id="identificador" name="identificador" value="' . $fila['Identificador'] . '" readonly/> 
                        </div>

                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="' . $fila['Pro_Nombre'] . '"/> 
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="' . $fila['Pro_Descripcion'] . '"/>
                        </div>

                        <div class="form-group">
                            <label for="categoria">Categoría</label>
                            <select class="form-control" id="categoria_select" name="categoria_select">'; 
                        // Agregar opciones a la lista desplegable
                        while ($categoria = mysqli_fetch_assoc($resultCategoria)) {
                            $selected = ($categoria['Cgo_Codigo'] == $fila['Pro_Categoria']) ? 'selected' : '';
                            echo '<option value="' . $categoria['Cgo_Codigo'] . '" ' . $selected . '>' . $categoria['Cgo_Nombre'] . '</option>';
                        }
                        echo '</select>
                        </div>

                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad" name="cantidad" value="' . $fila['Pro_Cantidad'] . '"/>
                        </div>

                        <div class="form-group">
                            <label for="precioventa">Precio de Venta</label>
                            <input type="text" class="form-control" id="precioventa" name="precioventa" value="' . $fila['Pro_PrecioVenta'] . '"/> 
                        </div>

                        <div class="form-group">
                            <label for="costo">Costo</label>
                            <input type="text" class="form-control" id="costo" name="costo" value="' . $fila['Pro_Costo'] . '"/> 
                        </div>

                        <div class="form-group">
                            <label for="imagen">Imagen Actual</label>
                            <img src=' . $fila['nombre_imagen'] . ' alt="" style="width: 200px; height: 200px;">
                            <label for="imagen">Nueva Imagen
                            <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" value="' . $fila['Pro_Estado'] . '" readonly/> 
                        </div>';
                    }
                }
            }
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
