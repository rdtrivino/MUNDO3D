<!DOCTYPE html>
<html lang="es">
<?php
include __DIR__ . '/../conexion.php';
include ("Programas/controlsesion.php");
?>

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
</head>

<body style="background: linear-gradient(135deg, #2980b9, #2c3e50); color: white;">
    <style>
        .modal-content {
            background-color: rgba(255, 255, 255, 0.9) !important;
            /* Color de fondo */
            color: #000 !important;
            /* Color del texto */
        }

        .modal-title {
            color: #000 !important;
        }
    </style>

    <body class="sb-nav-fixed">
        <?php include 'funcionestabladeproductos.php'; ?>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                    class="fas fa-bars"></i></button>
            <a class="navbar-brand ps-3" href="index.php">ADMINISTRADOR</a>
            <ul class="navbar-nav ms-auto ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombreCompleto; ?><i
                            class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="confi.php">Configuracion de cuenta</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="../Programas/logout.php" id="cerrar-sesion-button">Cerrar
                                sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                INICIO
                            </a>
                            <div class="sb-sidenav-menu-heading">Tablas</div>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                            </div>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas usuarios
                            </a>
                            <a class="nav-link" href="tablespedidos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas Pedidos
                            </a>
                            <a class="nav-link" href="tablesfacturas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Facturas
                            </a>
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
                        <div class="mb-3 text-center" style="margin-top: 70px;">
                            <h4>PRODUCTOS</h4>
                            <div style="max-width: 80%; margin: 0 auto;">
                                <div class="caja-giratoria" style="display: inline-block;">
                                    <img src="..\images\productos.png" alt="Pedidos" class="img-fluid gira">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#agregarModal">
                            <i class="fas fa-plus-circle me-1"></i> Agregar Nuevo Producto
                        </button>
                    </div>

                    <div class="sb-sidenav-footer">
                        <div class="small"></div>
                        MUNDO 3D
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4" style="padding-top: 20px; padding-bottom: 20px;">
                        <div class="row mt-4">
                            <div class="col text-center">
                                <h1 class="display-4 mb-2" style="font-family: 'Arial Black', sans-serif;">PRODUCTOS
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--boton de busqueda de la tabla-->
                        <div class="col d-flex justify-content-end mt-4 align-items-center">
                            <div class="d-flex justify-content-end ">
                                <div class="input-group input-group-sm rounded-pill" style="width: 300px;">
                                    <span class="input-group-text" id="basic-addon1">
                                     <!-- Ajusta el ancho total aquí -->
                                        <i class="fas fa-search"></i></span>
                                     <!-- Espacio adicional para la izquierda -->
                                    <input type="text" class="form-control rounded-end" id="searchInput"
                                        placeholder="Buscar..." oninput="searchTable()" style="width: 250px;">
                                     <!-- Ajusta el ancho del campo de entrada aquí -->
                                </div>
                            </div>
                        </div>
                    <!--paginacion -->
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <label for="num_registros" class="col-form-label"></label>
                            </div>
                            <div class="col-auto">
                                <select name="num_registros" id="num_registros" class="form-select" onchange="cambiarRegistrosPorPagina()">
                                    <option value="10" <?php if ($registrosPorPagina == 10) echo 'selected'; ?>>10</option> <!---selected"la opcion selecciona por defecto"-->
                                    <option value="25" <?php if ($registrosPorPagina == 25) echo 'selected'; ?>>25</option>
                                    <option value="50" <?php if ($registrosPorPagina == 50) echo 'selected'; ?>>50</option>
                                    <option value="100" <?php if ($registrosPorPagina == 100) echo 'selected'; ?>>100</option>
                                </select>
                            </div>
                        </div>


                    <script>
                        function searchTable() {
                            var input, filter, table, tr, td, i, txtValue;
                            input = document.getElementById("searchInput");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("datatable");
                            tr = table.getElementsByTagName("tr");
                            for (i = 0; i < tr.length; i++) {
                                // Verifica si es la fila del encabezado
                                if (tr[i].getElementsByTagName("th").length > 0) {
                                    continue; // Si es el encabezado, pasa a la siguiente fila
                                }
                                td = tr[i].getElementsByTagName("td");
                                var found = false;
                                for (var j = 0; j < td.length; j++) {
                                    if (td[j]) {
                                        txtValue = td[j].textContent || td[j].innerText;
                                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                            found = true;
                                            break;
                                        }
                                    }
                                }
                                if (found) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    </script>

                    <div class="card-body">
                        <!-- Agrega un campo oculto para el estado con valor "activo" -->
                        <input type="hidden" id="estado" name="estado" value="activo">

                        <!-- Modal de Agregar Nuevo Producto -->
                        <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="agregarModalLabel">Agregar Nuevo Producto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formulario-producto" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <textarea class="form-control" id="descripcion" name="descripcion"
                                                    rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="precio" class="form-label">Precio de Venta</label>
                                                <input type="number" class="form-control" id="precio" name="precio"
                                                    step="0.01" required>
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
                                                <input type="number" class="form-control" id="cantidad" name="cantidad"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="costo" class="form-label">Costo</label>
                                                <input type="number" class="form-control" id="costo" name="costo"
                                                    step="0.01" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="imagen" class="form-label">Imagen Principal</label>
                                                <input type="file" class="form-control" id="imagen" name="imagen"
                                                    accept="image/*" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-primary"
                                                    id="btnAgregarProducto">Agregar Producto</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Éxito -->
                        <div class="modal fade" id="exitoModal" tabindex="-1" aria-labelledby="exitoModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exitoModalLabel">Mensaje de Éxito</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p id="exitoMensaje"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function () {
                                $('#btnAgregarProducto').click(function () {
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
                                        success: function (response) {
                                            // Mostrar una alerta de éxito
                                            alert('¡Producto guardado con éxito!');

                                            // Recargar la página después de 1 segundo
                                            setTimeout(function () {
                                                location.reload();
                                            }, 1000);
                                        },
                                        error: function (xhr, status, error) {
                                            // Mostrar una alerta de error
                                            alert('¡Ha ocurrido un error al guardar el producto!');

                                            // Manejar errores aquí
                                            console.error(xhr.responseText);
                                        }
                                    });
                                });
                            });

                        </script>

                        <div class="col">
                            <div class="table-responsive" style="background-color: #f8f9fa; border-radius: 10px;">
                                <table id="datatable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Código</th>
                                            <th>Descripción</th>
                                            <th>Precio</th>
                                            <th>Categoría</th>
                                            <th>Cantidad</th>
                                            <th>Costo</th>
                                            <th>Imágenes</th>
                                            <th>Acciones</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
                                            <tr>
                                                <td><?php echo $row['Pro_Nombre']; ?></td>
                                                <td><?php echo $row['Identificador']; ?></td>
                                                <td><?php echo $row['Pro_Descripcion']; ?></td>
                                                <td><?php echo $row['Pro_PrecioVenta']; ?></td>
                                                <td><?php echo $row['Cgo_Nombre']; ?></td>
                                                <td><?php echo $row['Pro_Cantidad']; ?></td>
                                                <td><?php echo $row['Pro_Costo']; ?></td>
                                                <td><img src="<?php echo $row['nombre_imagen']; ?>" height="150px"></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Acciones">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editarModal<?php echo $row['Identificador']; ?>"
                                                            data-toggle="tooltip" data-placement="top" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <!-- Modal de edición -->
                                                        <div class="modal fade"
                                                            id="editarModal<?php echo $row['Identificador']; ?>"
                                                            tabindex="-1"
                                                            aria-labelledby="editarModalLabel<?php echo $row['Identificador']; ?>"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="editarModalLabel<?php echo $row['Identificador']; ?>">
                                                                            Editar Producto</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Formulario para editar el producto -->
                                                                        <form
                                                                            id="formulario-edicion-<?php echo $row['Identificador']; ?>"
                                                                            class="row g-3">
                                                                            <div class="col-md-6">
                                                                                <label for="nombre"
                                                                                    class="form-label">Nombre</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="nombre-<?php echo $row['Identificador']; ?>"
                                                                                    name="nombre"
                                                                                    value="<?php echo $row['Pro_Nombre']; ?>"
                                                                                    required>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="precio"
                                                                                    class="form-label">Precio de
                                                                                    Venta</label>
                                                                                <input type="number" class="form-control"
                                                                                    id="precio-<?php echo $row['Identificador']; ?>"
                                                                                    name="precio" step="0.01"
                                                                                    value="<?php echo $row['Pro_PrecioVenta']; ?>"
                                                                                    required>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="descripcion"
                                                                                    class="form-label">Descripción</label>
                                                                                <textarea class="form-control"
                                                                                    id="descripcion-<?php echo $row['Identificador']; ?>"
                                                                                    name="descripcion" rows="3"
                                                                                    required><?php echo $row['Pro_Descripcion']; ?></textarea>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="categoria"
                                                                                    class="form-label">Categoría</label>
                                                                                <select class="form-select"
                                                                                    id="categoria-<?php echo $row['Identificador']; ?>"
                                                                                    name="categoria" required>
                                                                                    <?php
                                                                                    // Verificar si $categorias está definido y no está vacío
                                                                                    if (isset($categorias) && !empty($categorias)) {
                                                                                        foreach ($categorias as $categoria) {
                                                                                            // Verificar si la categoría actual coincide con la categoría del producto
                                                                                            $selected = ($categoria['Cgo_Codigo'] == $row['Pro_Categoria']) ? 'selected' : '';
                                                                                            echo "<option value=\"{$categoria['Cgo_Codigo']}\" $selected>{$categoria['Cgo_Nombre']}</option>";
                                                                                        }
                                                                                    } else {
                                                                                        echo "<option value=\"\">No hay categorías disponibles</option>";
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="cantidad"
                                                                                    class="form-label">Cantidad</label>
                                                                                <input type="number" class="form-control"
                                                                                    id="cantidad-<?php echo $row['Identificador']; ?>"
                                                                                    name="cantidad"
                                                                                    value="<?php echo isset($row['Pro_Cantidad']) ? $row['Pro_Cantidad'] : ''; ?>"
                                                                                    required>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="costo"
                                                                                    class="form-label">Costo</label>
                                                                                <input type="number" class="form-control"
                                                                                    id="costo-<?php echo $row['Identificador']; ?>"
                                                                                    name="costo" step="0.01"
                                                                                    value="<?php echo isset($row['Pro_Costo']) ? $row['Pro_Costo'] : ''; ?>"
                                                                                    required>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="estado"
                                                                                    class="form-label">Estado</label>
                                                                                <select class="form-select"
                                                                                    id="estado-<?php echo $row['Identificador']; ?>"
                                                                                    name="estado" required>
                                                                                    <option value="activo" <?php echo ($row['Pro_Estado'] == 'activo') ? 'selected' : ''; ?>>Activo</option>
                                                                                    <option value="inactivo" <?php echo ($row['Pro_Estado'] == 'inactivo') ? 'selected' : ''; ?>>Inactivo
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <label for="imagen"
                                                                                    class="form-label">Imagen
                                                                                    Principal</label>
                                                                                <!-- Muestra la imagen actual del producto -->
                                                                                <?php if (!empty($row['nombre_imagen'])): ?>
                                                                                    <!-- Muestra la imagen actual si existe -->
                                                                                    <img src="<?php echo $row['nombre_imagen']; ?>"
                                                                                        alt="Imagen actual"
                                                                                        style="width: 100px; height: 100px;">
                                                                                <?php else: ?>
                                                                                    <!-- Muestra un mensaje si no hay imagen actual -->
                                                                                    <p>No hay imagen actual.</p>
                                                                                <?php endif; ?>
                                                                                <!-- Input para seleccionar una nueva imagen -->
                                                                                <input type="file" class="form-control"
                                                                                    id="imagen-<?php echo $row['Identificador']; ?>"
                                                                                    name="imagen" accept="image/*">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="button" class="btn btn-primary"
                                                                            onclick="guardar_cambios(<?php echo $row['Identificador']; ?>)">Guardar
                                                                            Cambios</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <td>
                                                    <div
                                                        class="badge <?php echo ($row['Pro_Estado'] == 'activo') ? 'bg-success' : 'bg-danger'; ?>">
                                                        <?php echo ucfirst($row['Pro_Estado']); ?>
                                                    </div>
                                                </td>
                                                <script>
                                                    function guardar_cambios(codigo) {
                                                        // Obtener los valores del formulario
                                                        var nombre = document.getElementById('nombre-' + codigo).value;
                                                        var descripcion = document.getElementById('descripcion-' + codigo).value;
                                                        var precio = document.getElementById('precio-' + codigo).value;
                                                        var categoria = document.getElementById('categoria-' + codigo).value;
                                                        var cantidad = document.getElementById('cantidad-' + codigo).value;
                                                        var costo = document.getElementById('costo-' + codigo).value;
                                                        var estado = document.getElementById('estado-' + codigo).value; // Obtener el estado
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
                                                        formData.append('estado', estado); // Añadir el estado al FormData
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
                                                                    setTimeout(function () {
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

                                            <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Funciones de paginación -->
                        <ul class="pagination" id="pagination">
                            <?php if ($pagina > 1): ?>
                                <li>
                                    <button onclick="cambiarPagina(<?php echo ($pagina - 1); ?>)">Anterior</button>
                                </li>
                            <?php endif; ?>

                            <?php
                            $totalPaginas = ceil($totalProductos / $registrosPorPagina);
                            $rango = 2; // Mostrar dos páginas antes y después de la actual
                            $inicio = max(1, $pagina - $rango);
                            $fin = min($totalPaginas, $pagina + $rango);
                            ?>

                            <?php if ($inicio > 1): ?>
                                <li>
                                    <button onclick="cambiarPagina(1)">1</button>
                                </li>
                                <?php if ($inicio > 2): ?>
                                    <li>...</li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $inicio; $i <= $fin; $i++): ?>
                                <li>
                                    <button onclick="cambiarPagina(<?php echo $i; ?>)" <?php if ($i == $pagina) echo 'disabled'; ?>><?php echo $i; ?></button>
                                </li>
                            <?php endfor; ?>

                            <?php if ($fin < $totalPaginas): ?>
                                <?php if ($fin < $totalPaginas - 1): ?>
                                    <li>...</li>
                                <?php endif; ?>
                                <li>
                                    <button onclick="cambiarPagina(<?php echo $totalPaginas; ?>)"><?php echo $totalPaginas; ?></button>
                                </li>
                            <?php endif; ?>

                            <?php if ($pagina < $totalPaginas): ?>
                                <li>
                                    <button onclick="cambiarPagina(<?php echo ($pagina + 1); ?>)">Siguiente</button>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <script>
                            function cambiarRegistrosPorPagina() {
                                const registrosPorPagina = document.getElementById('num_registros').value;
                                window.location.href = `?pagina=1&registrosPorPagina=${registrosPorPagina}`;
                            }

                            function cambiarPagina(pagina) {
                                const registrosPorPagina = document.getElementById('num_registros').value;
                                window.location.href = `?pagina=${pagina}&registrosPorPagina=${registrosPorPagina}`;
                            }
                        </script>
            <!--estilos de paginacion-->
            <style>
                    /* Estilos existentes de la paginación */

                    .pagination {
                        display: flex;
                        justify-content: center;
                        list-style: none;
                        padding: 0;
                    }

                    .pagination li {
                        margin: 0 5px;
                    }

                    .pagination button {
                        padding: 5px 10px;
                        cursor: pointer;
                        border: 1px solid #000; /* Borde negro */
                        background-color: #fff; /* Fondo blanco */
                        border-radius: 5px; /* Bordes redondeados */
                    }

                    .pagination button:hover {
                        background-color: #f0f0f0; /* Fondo gris claro al pasar el ratón */
                    }

                    .pagination button:disabled {
                        cursor: not-allowed;
                        background-color: #ddd; /* Fondo gris claro para botones deshabilitados */
                    }
                </style>
                <!--estilos de paginacion-->

                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">© Mundo 3D 2024</div>
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
        <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel"
            aria-hidden="true">
            <!-- Contenido del modal de eliminación aquí -->
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
            crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

</html>