<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tabla de productos</title>
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        /* Estilos personalizados */
        .cajitas {
            background-image: url('../images/bxs-wrench.svg'); /* Ruta de la imagen */
            background-repeat: repeat-x; /* Repetir la imagen horizontalmente */
            height: 30px; /* Altura de las cajitas */
        }
    </style>
    <style>
    body {
        background-color: #add8e6; /* Azul claro */
    }
    </style>

    
</head>
<body class="sb-nav-fixed">
<?php include 'funcionestabladeproductos.php'; ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">ADMINISTRADOR</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombreCompleto; ?><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../index.html" id="cerrar-sesion-button">Cerrar sesión</a></li>     
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">INICIO</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            INICIO
                        </a>
                        <div class="sb-sidenav-menu-heading">Tablas</div>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        </div>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tablas usuarios
                        </a>
                        <a class="nav-link" href="tablespedidos.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tablas Pedidos
                        </a>
                    </div>
                    <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">
                                <i class="fas fa-plus-circle me-1"></i> Agregar Nuevo Producto
                            </button>
                        </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary w-100" onclick="generarReportePDF()">
                                    <i class="fas fa-file-pdf me-1"></i> Generar Reporte PDF
                                </button>
                            </div>
                        <script>
                            function generarReportePDF() {
                                // Redirige a la página que genera el reporte PDF
                                window.open("generar_reporte_productos.php", "_blank");
                            }
                        </script>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small"></div>
                    MUNDO 3D
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
            <div class="container-fluid px-4">
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="col">
                            <h1 class="mt-4">Tabla de Productos</h1>
                        </div>
                    </div>
                    <div class="row align-items-start justify-content-end mb-4">
                        <div class="col-auto">
                            <img src="../images/Logo Mundo 3d.png" alt="Logo de la empresa" style="height: 100px; margin-top: -80px; margin-right: 20px;"> <!-- Ajustamos el margen superior -->
                        </div>
                    </div>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Tablas</li>
                    </ol>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            Esta tabla almacena información todos los productos registrados en el sistema.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            PRODUCTOS
                        </div>
                        <div class="col">
                            <div class="cajitas"></div>
                        </div>
                        <div class="card-body">
                        <!-- Agrega un campo oculto para el estado con valor "activo" -->
                        <input type="hidden" id="estado" name="estado" value="activo">

                        <!-- Modal de Agregar Nuevo Producto -->
                        <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="agregarModalLabel">Agregar Nuevo Producto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formulario-producto" enctype="multipart/form-data">
                                        <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="precio" class="form-label">Precio de Venta</label>
                                                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="categoria" class="form-label">Categoría</label>
                                                <select class="form-select" id="categoria" name="categoria" required>
                                                    <option value="">Selecciona una categoría</option>
                                                    <?php
                                                    foreach ($categorias as $categoria) {
                                                        echo "<option value=\"{$categoria['Cgo_Codigo']}\">{$categoria['Cgo_Nombre']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cantidad" class="form-label">Cantidad</label>
                                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="costo" class="form-label">Costo</label>
                                                <input type="number" class="form-control" id="costo" name="costo" step="0.01" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="imagen" class="form-label">Imagen Principal</label>
                                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-primary" id="btnAgregarProducto">Agregar Producto</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Éxito -->
                        <div class="modal fade" id="exitoModal" tabindex="-1" aria-labelledby="exitoModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exitoModalLabel">Mensaje de Éxito</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p id="exitoMensaje"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function() {
                                $('#btnAgregarProducto').click(function() {
                                    // Agrega el estado al formData
                                    $('#estado').appendTo($('#formulario-producto'));
                                    
                                    // Obtener los datos del formulario
                                    var formData = new FormData($('#formulario-producto')[0]);

                                    // Enviar los datos mediante AJAX
                                    $.ajax({
                                        type: 'POST',
                                        url: 'funcionestabladeproductos.php',
                                        data: formData,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) {
                                            // Mostrar una alerta de éxito
                                            alert('¡Producto guardado con éxito!');
                                            
                                            // Recargar la página después de 1 segundo
                                            setTimeout(function() {
                                                location.reload();
                                            }, 1000);
                                        },
                                        error: function(xhr, status, error) {
                                            // Mostrar una alerta de error
                                            alert('¡Ha ocurrido un error al guardar el producto!');
                                            
                                            // Manejar errores aquí
                                            console.error(xhr.responseText);
                                        }
                                    });
                                });
                            });

                        </script>

                        <table class="table table-bordered border-primary">
                         <thead class="table-dark">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Codigo</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th>Categoria</th>
                                        <th>Cantidad</th>
                                        <th>Costo</th>
                                        <th>Imagenes</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($row = mysqli_fetch_assoc($resultado)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['Pro_Nombre']; ?></td>
                                        <td><?php echo $row['Identificador']; ?></td>
                                        <td><?php echo $row['Pro_Descripcion']; ?></td>
                                        <td><?php echo $row['Pro_PrecioVenta']; ?></td>
                                        <td><?php echo $row['Cgo_Nombre']; ?></td>
                                        <td><?php echo $row['Pro_Cantidad']; ?></td>
                                        <td><?php echo $row['Pro_Costo']; ?></td>
                                        <td><img src="data:image/png;base64,<?php echo base64_encode($row['imagen_principal']); ?>" alt="Imagen del producto" style="width: 200px; height: 200px;"></td>
                                        <td>
                                        <div class="btn-group" role="group" aria-label="Acciones">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['Identificador']; ?>" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Modal de edición -->
                                            <div class="modal fade" id="editarModal<?php echo $row['Identificador']; ?>" tabindex="-1" aria-labelledby="editarModalLabel<?php echo $row['Identificador']; ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editarModalLabel<?php echo $row['Identificador']; ?>">Editar Producto</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Formulario para editar el producto -->
                                                            <form id="formulario-edicion-<?php echo $row['Identificador']; ?>">
                                                                <div class="mb-3">
                                                                    <label for="nombre" class="form-label">Nombre</label>
                                                                    <input type="text" class="form-control" id="nombre-<?php echo $row['Identificador']; ?>" name="nombre" value="<?php echo $row['Pro_Nombre']; ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                                    <textarea class="form-control" id="descripcion-<?php echo $row['Identificador']; ?>" name="descripcion" rows="3" required><?php echo $row['Pro_Descripcion']; ?></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="precio" class="form-label">Precio de Venta</label>
                                                                    <input type="number" class="form-control" id="precio-<?php echo $row['Identificador']; ?>" name="precio" step="0.01" value="<?php echo $row['Pro_PrecioVenta']; ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="categoria" class="form-label">Categoría</label>
                                                                    <select class="form-select" id="categoria-<?php echo $row['Identificador']; ?>" name="categoria" required>
                                                                        <?php
                                                                        foreach ($categorias as $categoria) {
                                                                            $selected = ($categoria['Cgo_Codigo'] == $row['Pro_Categoria']) ? 'selected' : '';
                                                                            echo "<option value=\"{$categoria['Cgo_Codigo']}\" $selected>{$categoria['Cgo_Nombre']}</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="cantidad" class="form-label">Cantidad</label>
                                                                    <input type="number" class="form-control" id="cantidad-<?php echo $row['Identificador']; ?>" name="cantidad" value="<?php echo isset($row['Pro_Cantidad']) ? $row['Pro_Cantidad'] : ''; ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="costo" class="form-label">Costo</label>
                                                                    <input type="number" class="form-control" id="costo-<?php echo $row['Identificador']; ?>" name="costo" step="0.01" value="<?php echo isset($row['Pro_Costo']) ? $row['Pro_Costo'] : ''; ?>" required>
                                                                </div>
                                                                <!-- Campo oculto para el estado del producto (por defecto activo) -->
                                                                <input type="hidden" name="estado" value="activo">
                                                                <!-- Muestra la imagen actual del producto -->
                                                                <div class="mb-3">
                                                                    <label for="imagen" class="form-label">Imagen Principal</label>
                                                                    <?php if (!empty($row['imagen_principal'])) : ?>
                                                                        <!-- Muestra la imagen actual si existe -->
                                                                        <img src="data:image/png;base64,<?php echo base64_encode($row['imagen_principal']); ?>" alt="Imagen actual" style="width: 100px; height: 100px;">
                                                                    <?php else : ?>
                                                                        <!-- Muestra un mensaje si no hay imagen actual -->
                                                                        <p>No hay imagen actual.</p>
                                                                    <?php endif; ?>
                                                                    <!-- Input para seleccionar una nueva imagen -->
                                                                    <input type="file" class="form-control" id="imagen-<?php echo $row['Identificador']; ?>" name="imagen" accept="image/*">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="button" class="btn btn-primary" onclick="guardar_cambios(<?php echo $row['Identificador']; ?>)">Guardar Cambios</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <script>
                                            function guardar_cambios(codigo) {
                                                // Obtener los valores del formulario
                                                var nombre = document.getElementById('nombre-' + codigo).value;
                                                var descripcion = document.getElementById('descripcion-' + codigo).value;
                                                var precio = document.getElementById('precio-' + codigo).value;
                                                var categoria = document.getElementById('categoria-' + codigo).value;
                                                var cantidad = document.getElementById('cantidad-' + codigo).value;
                                                var costo = document.getElementById('costo-' + codigo).value;
                                                var imagen = document.getElementById('imagen-' + codigo).files[0];

                                                // Crear un objeto FormData para enviar los datos
                                                var formData = new FormData();
                                                formData.append('guardar_cambios', true);
                                                formData.append('Identificador', codigo);
                                                formData.append('nombre', nombre);
                                                formData.append('descripcion', descripcion);
                                                formData.append('precio', precio);
                                                formData.append('categoria', categoria);
                                                formData.append('cantidad', cantidad);
                                                formData.append('costo', costo);
                                                formData.append('imagen', imagen);

                                                // Realizar la solicitud AJAX
                                                var xhr = new XMLHttpRequest();
                                                xhr.open("POST", "funcionestabladeproductos.php", true);
                                                xhr.onreadystatechange = function () {
                                                    if (xhr.readyState === 4) {
                                                        if (xhr.status === 200) {
                                                            // Mostrar un mensaje de éxito
                                                            alert("Los cambios se han realizado con éxito.");
                                                            // Cerrar el modal
                                                            $('#editarModal' + codigo).modal('hide');
                                                            // Recargar la página después de 1 segundo
                                                            setTimeout(function() {
                                                                location.reload();
                                                            }, 1000);
                                                        } else {
                                                            // Mostrar un mensaje de error
                                                            alert("Ha ocurrido un error al realizar los cambios.");
                                                        }
                                                    }
                                                };
                                                xhr.send(formData);
                                            }
                                            </script>
                                            <!-- Botón de eliminar -->
                                            <button type="button" class="btn btn-danger" onclick="mostrarModalConfirmacion(<?php echo $row['Identificador']; ?>)" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <!-- Modal de confirmación -->
                                            <div class="modal fade" id="modalConfirmacion_<?php echo $row['Pro_Codigo']; ?>" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar acción</h5>
                                                            <button type="button" class="btn-close" aria-label="Close" onclick="cerrarModalConfirmacion(<?php echo $row['Pro_Codigo']; ?>)"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas eliminar el producto?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" onclick="cerrarModalConfirmacion(<?php echo $row['Identificador']; ?>)">Cancelar</button>
                                                            <button type="button" class="btn btn-danger" onclick="confirmarCambioEstado(<?php echo $row['Identificador']; ?>)">Aceptar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                function mostrarModalConfirmacion(codigoProducto) {
                                                    // Muestra el modal de confirmación correspondiente al producto
                                                    $('#modalConfirmacion_' + codigoProducto).modal('show');
                                                }

                                                function cerrarModalConfirmacion(codigoProducto) {
                                                    // Cierra el modal de confirmación correspondiente al producto
                                                    $('#modalConfirmacion_' + codigoProducto).modal('hide');
                                                }

                                                function confirmarCambioEstado(codigoProducto) {
                                                    // Realiza la solicitud AJAX para cambiar el estado del producto
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'funcionestabladeproductos.php', // Cambia la URL según la ubicación de tu archivo PHP
                                                        data: { codigo: codigoProducto },
                                                        success: function(response) {
                                                            // Muestra el mensaje de éxito
                                                            alert(response);
                                                            // Cierra el modal de confirmación
                                                            cerrarModalConfirmacion(codigoProducto);
                                                            // Actualiza la tabla de productos
                                                            location.reload();
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error('Error al cambiar el estado del producto:', error);
                                                        }
                                                    });
                                                }
                                            </script>
                                        </div>
                                        <?php }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Modal de Edición -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <!-- Contenido del modal de edición aquí -->
    </div>

    <!-- Modal de Eliminación -->
    <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
        <!-- Contenido del modal de eliminación aquí -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
