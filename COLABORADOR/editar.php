<!DOCTYPE html>
<!-- http://localhost/MUNDO 3D/COLABORADOR/editar.php -->
<html lang="en">

    <?php
        include __DIR__ . '/../conexion.php';
        include("Programas/controlsesion.php");

        //Establecer variables del proceso
        $nombreCompleto = $_SESSION['username'];
        $usuario_id = $_SESSION['user_id'];
        $tabla = $_GET['tabla'];
        $id = $_GET['id']
    ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <link href="form-validation.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="">
        <a class="Btn-1" href="index.php?tabla=<?php echo $tabla; ?>">
            <div class="sign">
                <img src="../images/iconizer-bx-home-alt-2.2.svg" alt="Inicio">
            </div>

            <div class="text">INICIO</div>
        </a>
    </div>
    
    <div class="container">

        <div class="py-5 text-center">
            <img class="" src="../images/Logo Mundo 3d.png" alt="" width="150" height="150">
        </div>

        <?php
        $querytipo = "SELECT Pe_Producto FROM pedidos WHERE Identificador = $id";
                            // Obtener variable de tipo de producto
                            $tipo = mysqli_query($link, $querytipo);
                            if ($tipo) {
                                $fila = mysqli_fetch_assoc($tipo);
                            }
        ?>

        <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data" action="procesaractualizar.php?tabla=<?php echo $tabla; ?>&id=<?php echo $id; ?>&tipo=<?php echo $fila['Pe_Producto']; ?>" onsubmit="return validateForm()">
            <input type="hidden" class="form-control" id="address2" name="tabla" value="<?php echo $_GET['tabla']; ?>">

            <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

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
                        
                        if ($fila['Pe_Producto'] != "1"){

                        $peticion1 = "SELECT * FROM pedidos WHERE Identificador = $Identificador";
                        $result = mysqli_query($link, $peticion1);
                        if ($result && $fila = mysqli_fetch_assoc($result)) {

                            // Consulta SQL para obtener los datos de la tabla Usuario
                            $queryUsuarios = "SELECT Usu_Identificacion, Usu_Nombre_completo FROM usuario";
                            $resultUsuarios = mysqli_query($link, $queryUsuarios);

                            // Consulta SQL para obtener los datos de la tabla Estado
                            $queryEstado = "SELECT Es_Codigo, Es_Nombre FROM pedido_estado";
                            $resultEstado = mysqli_query($link, $queryEstado);

                            // Consulta SQL para obtener los datos de la tabla productos
                            $queryProducto = "SELECT Identificador, Pro_Nombre FROM productos";
                            $resultProducto = mysqli_query($link, $queryProducto);

                            echo '

                            <div class="form-group">
                                <label for="cliente_select">Cliente (*)</label>
                                <select class="form-control" id="cliente_select" name="cliente_select" required>';

                            // Agregar opciones a la lista desplegable
                            while ($usuario = mysqli_fetch_assoc($resultUsuarios)) {
                                $selected = ($usuario['Usu_Identificacion'] == $fila['Pe_Cliente']) ? 'selected' : '';
                                echo '<option value="' . $usuario['Usu_Identificacion'] . '" ' . $selected . '>' . $usuario['Usu_Identificacion'] . ' - ' . $usuario['Usu_Nombre_completo'] . '</option>';
                            }

                            echo '</select>
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado (*)</label>
                                <select class="form-control" id="estado_select" name="estado_select" required>';
                            // Agregar opciones a la lista desplegable
                            while ($estado = mysqli_fetch_assoc($resultEstado)) {
                                $selected = ($estado['Es_Codigo'] == $fila['Pe_Estado']) ? 'selected' : '';
                                echo '<option value="' . $estado['Es_Codigo'] . '" ' . $selected . '>' . $estado['Es_Nombre'] . '</option>';
                            }

                            echo '</select>

                            </div>

                            <div class="form-group">
                                <label for="producto">Producto (*)</label>
                                <select class="form-control" id="producto_select" name="producto_select" required>'; 
                            // Agregar opciones a la lista desplegable
                            while ($producto = mysqli_fetch_assoc($resultProducto)) {
                                $selected = ($producto['Identificador'] == $fila['Pe_Producto']) ? 'selected' : '';
                                echo '<option value="' . $producto['Identificador'] . '" ' . $selected . '>' . $producto['Pro_Nombre'] . '</option>';
                            }

                            echo '</select>
                            </div>

                            <div class="form-group">
                                <label for="cantidad">Cantidad (*)</label>
                                <input type="text" class="form-control" id="cantidad" name="cantidad" value="' . $fila['Pe_Cantidad'] . '" required/>
                            </div>

                            <div class="form-group">
                                <label for="fechapedido">Fecha de Pedido (*)</label>
                                <input type="date" class="form-control" id="fechapedido" name="fechapedido" value="' . $fila['Pe_Fechapedido'] . '" required/> 
                            </div>

                            <div class="form-group">
                                <label for="fechaentrega">Fecha de Entrega (*)</label>
                                <input type="date" class="form-control" id="fechaentrega" name="fechaentrega" value="' . $fila['Pe_Fechaentrega'] . '" required/> 
                            </div>

                            <div class="form-group">
                                <label for="observacion">Observación</label>
                                <input type="text" class="form-control" id="observacion" name="observacion" value="' . $fila['Pe_Observacion'] . '"/> 
                            </div>';
                        }
                        } elseif ($fila['Pe_Producto'] == "1"){
                            $peticion2 = "SELECT * FROM pedidos WHERE Identificador = $Identificador";
                            $result = mysqli_query($link, $peticion2);
                        if ($result && $fila = mysqli_fetch_assoc($result)) {

                            // Consulta SQL para obtener los datos de la tabla Usuario
                            $queryUsuarios = "SELECT Usu_Identificacion, Usu_Nombre_completo FROM usuario";
                            $resultUsuarios = mysqli_query($link, $queryUsuarios);

                            // Consulta SQL para obtener los datos de la tabla Estado
                            $queryEstado = "SELECT Es_Codigo, Es_Nombre FROM pedido_estado";
                            $resultEstado = mysqli_query($link, $queryEstado);

                            // Consulta SQL para obtener los datos de la tabla productos
                            $queryProducto = "SELECT Identificador, Pro_Nombre FROM productos";
                            $resultProducto = mysqli_query($link, $queryProducto);

                            echo '

                            <div class="form-group">
                                <label for="cliente_select">Cliente (*)</label>
                                <select class="form-control" id="cliente_select" name="cliente_select" required>';

                            // Agregar opciones a la lista desplegable
                            while ($usuario = mysqli_fetch_assoc($resultUsuarios)) {
                                $selected = ($usuario['Usu_Identificacion'] == $fila['Pe_Cliente']) ? 'selected' : '';
                                echo '<option value="' . $usuario['Usu_Identificacion'] . '" ' . $selected . '>' . $usuario['Usu_Identificacion'] . ' - ' . $usuario['Usu_Nombre_completo'] . '</option>';
                            }

                            echo '</select>
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado (*)</label>
                                <select class="form-control" id="estado_select" name="estado_select" required>';
                            // Agregar opciones a la lista desplegable
                            while ($estado = mysqli_fetch_assoc($resultEstado)) {
                                $selected = ($estado['Es_Codigo'] == $fila['Pe_Estado']) ? 'selected' : '';
                                echo '<option value="' . $estado['Es_Codigo'] . '" ' . $selected . '>' . $estado['Es_Nombre'] . '</option>';
                            }

                            echo '</select>

                            </div>

                            <div class="form-group">
                                <label for="producto">Producto (*)</label>
                                <select class="form-control" id="producto_select" name="producto_select" required>'; 
                            // Agregar opciones a la lista desplegable
                            while ($producto = mysqli_fetch_assoc($resultProducto)) {
                                $selected = ($producto['Identificador'] == $fila['Pe_Producto']) ? 'selected' : '';
                                echo '<option value="' . $producto['Identificador'] . '" ' . $selected . '>' . $producto['Pro_Nombre'] . '</option>';
                            }

                            echo '</select>
                            </div>

                            <div class="form-group">
                                <label for="cantidad">Cantidad (*)</label>
                                <input type="text" class="form-control" id="cantidad" name="cantidad" value="' . $fila['Pe_Cantidad'] . '" required/>
                            </div>

                            <div class="form-group">
                                <label for="fechapedido">Fecha de Pedido (*)</label>
                                <input type="date" class="form-control" id="fechapedido" name="fechapedido" value="' . $fila['Pe_Fechapedido'] . '" required/> 
                            </div>

                            <div class="form-group">
                                <label for="fechaentrega">Fecha de Entrega (*)</label>
                                <input type="date" class="form-control" id="fechaentrega" name="fechaentrega" value="' . $fila['Pe_Fechaentrega'] . '" required/> 
                            </div>

                            <div class="form-group">
                                <label for="imagen">Imagen Actual</label>
                                <img src=' . $fila['nombre_imagen'] . ' alt="" style="width: 200px; height: 200px;">
                                <label for="imagen">Nueva Imagen
                                    <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                                </label>
                            </div>';

                            echo '
                            <div class="form-group">
                                <label for="tipo">Tipo de impresión (*)</label>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option value="' . $fila['pe_tipo_impresion'] . '">' . $fila['pe_tipo_impresion'] . '</option>
                                    <option value="' . ($fila['pe_tipo_impresion'] === 'Resina' ? 'Filamento' : 'Resina') . '">
                                        ' . ($fila['pe_tipo_impresion'] === 'Resina' ? 'Filamento' : 'Resina') . '
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tipo">Color del producto (*)</label>
                                <select class="form-control" id="color" name="color" required>
                                    <option value="' . $fila['pe_color'] . '">' . $fila['pe_color'] . '</option>
                                    <option value="' . ($fila['pe_color'] === 'Único Color' ? 'Color Original' : 'Único Color') . '">
                                    ' . ($fila['pe_color'] === 'Único Color' ? 'Color Original' : 'Único Color') . '
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="observacion">Observación</label>
                                <input type="text" class="form-control" id="observacion" name="observacion" value="' . $fila['Pe_Observacion'] . '"/> 
                            </div>';
                        }
                        }
                    } elseif ($_GET['tabla'] == 'productos') {
                        $peticion3 = "SELECT * FROM productos WHERE Identificador = $Identificador";
                        $result = mysqli_query($link, $peticion3);
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
                                <label for="nombre">Nombre (*)</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="' . $fila['Pro_Nombre'] . '" requiered/> 
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción (*)</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" value="' . $fila['Pro_Descripcion'] . '" requiered/>
                            </div>

                            <div class="form-group">
                                <label for="categoria">Categoría (*)</label>
                                <select class="form-control" id="categoria_select" name="categoria_select" requiered>'; 
                            // Agregar opciones a la lista desplegable
                            while ($categoria = mysqli_fetch_assoc($resultCategoria)) {
                                $selected = ($categoria['Cgo_Codigo'] == $fila['Pro_Categoria']) ? 'selected' : '';
                                echo '<option value="' . $categoria['Cgo_Codigo'] . '" ' . $selected . '>' . $categoria['Cgo_Nombre'] . '</option>';
                            }
                            echo '</select>
                            </div>

                            <div class="form-group">
                                <label for="cantidad">Cantidad (*)</label>
                                <input type="text" class="form-control" id="cantidad" name="cantidad" value="' . $fila['Pro_Cantidad'] . '" requiered/>
                            </div>

                            <div class="form-group">
                                <label for="precioventa">Precio de Venta (*)</label>
                                <input type="text" class="form-control" id="precioventa" name="precioventa" value="' . $fila['Pro_PrecioVenta'] . '" requiered/> 
                            </div>

                            <div class="form-group">
                                <label for="costo">Costo (*)</label>
                                <input type="text" class="form-control" id="costo" name="costo" value="' . $fila['Pro_Costo'] . '" requiered/> 
                            </div>

                            <div class="form-group">
                                <label for="imagen">Imagen Actual</label>
                                <img src=' . $fila['nombre_imagen'] . ' alt="" style="width: 200px; height: 200px;">
                                <label for="imagen">Nueva Imagen
                                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado (*)</label>
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
<script>
    function validateForm() {
        let isValid = true;
        const requiredFields = document.querySelectorAll('input[required], select[required]');

        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('is-invalid'); // Puedes aplicar una clase para marcar el campo como inválido
            } else {
                field.classList.remove('is-invalid'); // Limpiar la clase si el campo es válido
            }
        });

        if (!isValid) {
            alert('Por favor, complete todos los campos obligatorios marcados con (*).');
        }

        return isValid; // Retornar el estado de validación
    }
</script>
</body>
</html>
