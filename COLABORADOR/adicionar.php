<?php
include __DIR__ . '/../conexion.php';
include 'Programas/controlsesion.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    // Manejar el error de sesión no activa
    die("Acceso denegado");
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id'];

// Sanitiza los datos de entrada
$tabla = isset($_GET['tabla']) ? mysqli_real_escape_string($link, $_GET['tabla']) : '';
$tipo = isset($_GET['tipo']) ? mysqli_real_escape_string($link, $_GET['tipo']) : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">
    <link href="css/bootstrap.min.css" rel="stylesheet"> 
    <link href="form-validation.css" rel="stylesheet">  
    <link href="css/estilo.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <script src="js/scripts.js"></script>
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
            <img class="mundo" src="./../images/Logo Mundo 3d.png" alt="" width="150" height="150">
        </div>

        <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data" action="procesarnuevo.php?tabla=<?php echo $tabla; ?>&tipo=<?php echo $tipo; ?>" onsubmit="return validateForm()">
            <input type="hidden" class="form-control" name="tabla" value="<?php echo $tabla; ?>">

            <?php if ($tabla == 'pedidos') { 
                    if ($tipo == 'producto') {
            ?>
                <div class="form-group">
                    <label for="cliente">Cliente (*)</label>
                    <select class="form-control" id="cliente" name="cliente" required>
                        <option value="">Seleccionar cliente</option>
                        <?php
                        $consulta = "SELECT Usu_Identificacion, Usu_Nombre_Completo FROM usuario";
                        $resultado = mysqli_query($link, $consulta);
                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $opcion = $fila['Usu_Identificacion'] . ' - ' . $fila['Usu_Nombre_Completo'];
                                echo '<option value="' . $fila['Usu_Identificacion'] . '">' . $opcion . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="estado">Estado (*)</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="">Seleccionar estado del pedido</option>
                        <?php
                        $consulta = "SELECT Es_Codigo, Es_Nombre FROM pedido_estado";
                        $resultado = mysqli_query($link, $consulta);
                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                echo '<option value="' . $fila['Es_Codigo'] . '">' . $fila['Es_Nombre'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="producto">Producto (*)</label>
                    <select class="form-control" id="producto" name="producto" required>
                        <option value="">Seleccionar el producto</option>
                        <?php
                        $consulta = "SELECT Identificador, Pro_Nombre FROM productos";
                        $resultado = mysqli_query($link, $consulta);
                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                echo '<option value="' . $fila['Identificador'] . '">' . $fila['Pro_Nombre'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad (*)</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" required />
                </div>

                <div class="form-group">
                    <label for="fechapedido">Fecha de Pedido (*)</label>
                    <input type="date" class="form-control" id="fechapedido" name="fechapedido" required />
                </div>

                <div class="form-group">
                    <label for="fechaentrega">Fecha estimada de entrega</label>
                    <input type="date" class="form-control" id="fechaentrega" name="fechaentrega" required />
                </div>

                <div class="form-group">
                    <label for="observacion">Observación</label>
                    <input type="text" class="form-control" id="observacion" name="observacion" />
                </div>

            <?php } elseif ($tipo == 'impresion') { ?>

                <div class="form-group">
                    <label for="cliente">Cliente (*)</label>
                    <select class="form-control" id="cliente" name="cliente" required>
                        <option value="">Seleccionar cliente</option>
                        <?php
                        $consulta = "SELECT Usu_Identificacion, Usu_Nombre_Completo FROM usuario";
                        $resultado = mysqli_query($link, $consulta);
                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $opcion = $fila['Usu_Identificacion'] . ' - ' . $fila['Usu_Nombre_Completo'];
                                echo '<option value="' . $fila['Usu_Identificacion'] . '">' . $opcion . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="imagen" class="form-label">Imagen del producto a imprimir</label>
                    <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad (*)</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" required />
                </div>

                <div class="form-group">
                    <label for="fechapedido">Fecha de Pedido (*)</label>
                    <input type="date" class="form-control" id="fechapedido" name="fechapedido" required />
                </div>

                <div class="form-group">
                    <label for="fechaentrega">Fecha estimada de entrega</label>
                    <input type="date" class="form-control" id="fechaentrega" name="fechaentrega" />
                </div>

                <div class="form-group">
                    <label for="tipoimpresion">Tipo de impresión</label>
                    <select class="form-control" id="tipoimpresion" name="tipoimpresion" required>
                        <option value="">Seleccionar el tipo de impresión</option>
                        <option value="Poliácido Láctico">Filamento</option>
                        <option value="Acrilonitrilo Butadieno Estireno">Resina</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="color">Color de la impresión</label>
                    <select class="form-control" id="color" name="color" required>
                        <option value="">Seleccionar el color de impresión</option>
                        <option value="Negro Fibra de Carbono">Único Color</option>
                        <option value="Blanco Menta">Color Original</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="observacion">Observación</label>
                    <input type="text" class="form-control" id="observacion" name="observacion" />
                </div>
             
             
            <?php
            }
            ?>

            <!--Inicia formulario productos-->
            <?php } elseif ($tabla == 'productos') { ?>

                <div class="form-group">
                    <label for="nombre">Nombre (*)</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required />
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción (*)</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" required />
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría (*)</label>
                    <select class="form-control" id="categoria" name="categoria" required>
                        <option value="">Seleccionar la categoría del producto</option>
                        <?php
                        $consulta = "SELECT Cgo_Codigo, Cgo_Nombre FROM categoria";
                        $resultado = mysqli_query($link, $consulta);
                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                echo '<option value="' . $fila['Cgo_Codigo'] . '">' . $fila['Cgo_Nombre'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad (*)</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" required />
                </div>

                <div class="form-group">
                    <label for="precioventa">Precio de Venta (*)</label>
                    <input type="text" class="form-control" id="precioventa" name="precioventa" required />
                </div>

                <div class="form-group">
                    <label for="costo">Costo (*)</label>
                    <input type="text" class="form-control" id="costo" name="costo" required />
                </div>

                <div class="form-group">
                    <label for="imagen" class="form-label">Imagen (*)</label>
                    <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*" required>
                </div>

            <?php } ?>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Procesar</button>
        </form>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2024 Mundo 3D</p>
    </footer>

    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="form-validation.js"></script>
    <script>
        document.getElementById('btn-cerrar-modal').addEventListener('click', function() {
            document.getElementById('modal').close();
        });
    </script>

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
