<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tabla de usuarios</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
    body {
        background-color: #add8e6; /* Azul claro */
    }
    </style>
    </head>
    <body class="sb-nav-fixed">
    <?php include 'funcionestabladeusuarios.php'; ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">ADMINISTRADOR</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <script>
        // Obtener la URL actual
        var currentUrl = window.location.href;

        // Extraer el nombre del archivo de la URL
        var filename = currentUrl.substring(currentUrl.lastIndexOf('/') + 1).replace('.php', '');

        // Determinar la tabla según el nombre del archivo
        var currentTable;
        switch (filename) {
            case 'tables':
                currentTable = 'usuario';
                break;
            case 'tablesproductos':
                currentTable = 'producto';
                break;
            case 'tablespedidos':
                currentTable = 'pedido';
                break;
            default:
                currentTable = null;
                break;
        }

        // Mostrar el nombre de la tabla actual
        if (currentTable) {
            console.log('Estás visualizando la tabla de ' + currentTable);
        } else {
            console.log('No se pudo determinar la tabla actual.');
        }
    </script>
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
                            <a class="nav-link" href="tablespedidos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas Pedidos
                            </a>
                            <a class="nav-link" href="tablesproductos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas Productos
                            </a>
                            
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarColaboradorModal">
                                <i class="fas fa-plus-circle me-1"></i> Agregar Nuevo Colaborador
                            </button>
                        </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary w-100" onclick="generarReportePDF()">
                                    <i class="fas fa-file-pdf me-1"></i> Generar Reporte PDF
                                </button>
                            </div>
                        <script>
                            function generarReportePDF() {
                                window.open("generar_reporte.php", "_blank");
                            }
                        </script>
                        </div>
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
                            <h1 class="mt-4">Tabla de usuarios</h1>
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
                        <div class="card mb-4">
                            <div class="card-body">
                                Esta tabla almacena información de los usuarios registrados en el sistema.
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                USUARIOS
                            </div>
<!-- Modal de Agregar Nuevo Colaborador -->
<div class="modal fade" id="agregarColaboradorModal" tabindex="-1" aria-labelledby="agregarColaboradorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarColaboradorModalLabel">Agregar Nuevo Colaborador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí va el formulario para agregar un nuevo colaborador -->
                <form id="formulario-colaborador">
                    <div class="mb-3">
                        <label for="Identificacion" class="form-label">Identificación</label>
                        <input type="text" class="form-control" id="Identificacion" name="Identificacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de Colaborador</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <select class="form-select" id="ciudad" name="ciudad" required>
                            <option value="" disabled selected>Seleccione una ciudad</option>
                            <option value="Bogotá">Bogotá D.C.</option>
                            <option value="Medellín">Medellín</option>
                            <option value="Cali">Cali</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnAgregarColaborador">Agregar Colaborador</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Manejar el clic en el botón "Agregar Colaborador"
        $("#btnAgregarColaborador").click(function() {
            // Obtener la contraseña
            var contraseña = generarContraseña(); // Función para generar una contraseña aleatoria

            // Asignar la contraseña al campo oculto
            $("#contraseña").val(contraseña);

            // Obtener los datos del formulario
            var formData = $("#formulario-colaborador").serialize();

            // Enviar la solicitud AJAX al servidor PHP
            $.ajax({
                type: "POST",
                url: "funcionestabladeusuarios.php", // Reemplaza esto con la ruta correcta a tu archivo PHP
                data: formData,
                dataType: "json",
                success: function(response) {
                    // Manejar la respuesta del servidor
                    if (response.success) {
                        // Mostrar un mensaje de éxito
                        alert(response.message);
                        // Actualizar la página o realizar otras acciones necesarias
                        location.reload(); // Por ejemplo, recargar la página
                    } else {
                        // Mostrar un mensaje de error
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                    console.error(xhr.responseText);
                    alert("Error al procesar la solicitud. Por favor, inténtalo de nuevo más tarde.");
                }
            });
        });
    });

    // Función para generar una contraseña aleatoria
    function generarContraseña() {
        // Lógica para generar una contraseña aleatoria
        // Retorna la contraseña generada
    }
</script>


                            <style>
                                .pdf-link-container {
                                    position: fixed;
                                    bottom: 20px;
                                    right: 20px; 
                                    z-index: 9999;
                                }

                                .pdf-link {
                                    display: inline-block;
                                    text-decoration: none;
                                    font-size: 18px;
                                    background-color: #2433bd; 
                                    color: #fff; 
                                    padding: 10px 15px;
                                    border-radius: 5px; 
                                }

                                .pdf-icon {
                                    margin-left: 5px;
                                }
                            </style>
                            <div class="card-body">
                            <body>
                            <table id="datatablesSimple">
                                <thead>
                                <tr>
                                    <th>Identificación</th>
                                    <th>Nombre completo</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Ciudad</th>
                                    <th>Dirección</th>
                                    <th>Rol</th>
                                    <th>Pedidos</th>
                                    <th>Acciones</th> 
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Identificación</th>
                                    <th>Nombre completo</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Ciudad</th>
                                    <th>Dirección</th>
                                    <th>Rol</th>
                                    <th>Pedidos</th>
                                    <th>Acciones</th> 
                                    <th>Estado</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($resultado)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['Usu_Identificacion']; ?></td>
                                    <td><?php echo $row['Usu_Nombre_completo']; ?></td>
                                    <td><?php echo $row['Usu_Telefono']; ?></td>
                                    <td><?php echo $row['Usu_Email']; ?></td>
                                    <td><?php echo $row['Usu_Ciudad']; ?></td>
                                    <td><?php echo $row['Usu_Direccion']; ?></td>
                                    <td>
                                        <?php
                                        $rol = $row['Usu_Rol'];

                                        switch ($rol) {
                                            case 1:
                                                echo 'Administrador';
                                                break;
                                            case 2:
                                                echo 'Colaborador';
                                                break;
                                            case 3:
                                                echo 'Cliente';
                                                break;
                                            default:
                                                echo 'Desconocido';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row['Usu_Pedidos']; ?></td>
                                    <td>
                                        <div class="btn-group d-flex justify-content-center" role="group" aria-label="Acciones">
                                            <button type="button" class="btn btn-primary btn-sm align-items-center" style="max-width: 50px;" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['Usu_Identificacion']; ?>" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>

                                    <div class="modal fade" id="editarModal<?php echo $row['Usu_Identificacion']; ?>" tabindex="-1" aria-labelledby="editarModalLabel<?php echo $row['Usu_Identificacion']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarModalLabel<?php echo $row['Usu_Identificacion']; ?>">Editar Usuario</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="funcionestabladeusuarios.php" method="POST" onsubmit="return confirmarActualizacion()">                                                   
                                                <input type="hidden" name="id_usuario" value="<?php echo $row['Usu_Identificacion']; ?>">
                                                    <div class="mb-3">
                                                        <label for="identificacion">Identificación:</label>
                                                        <input type="text" class="form-control" id="identificacion" name="identificacion" value="<?php echo $row['Usu_Identificacion']; ?>" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nombre">Nombre completo:</label>
                                                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['Usu_Nombre_completo']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="telefono">Teléfono:</label>
                                                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $row['Usu_Telefono']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email">Email:</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['Usu_Email']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="ciudad">Ciudad:</label>
                                                        <select class="form-select" id="ciudad" name="ciudad">
                                                            <option value="Bogotá" <?php echo ($row['Usu_Ciudad'] == 'Bogotá') ? 'selected' : ''; ?>>Bogotá</option>
                                                            <option value="Medellín" <?php echo ($row['Usu_Ciudad'] == 'Medellín') ? 'selected' : ''; ?>>Medellín</option>
                                                            <option value="Cali" <?php echo ($row['Usu_Ciudad'] == 'Cali') ? 'selected' : ''; ?>>Cali</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="direccion">Dirección:</label>
                                                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $row['Usu_Direccion']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="rol">Rol:</label>
                                                        <select class="form-select" id="rol" name="rol">
                                                            <option value="1" <?php echo ($row['Usu_Rol'] == 1) ? 'selected' : ''; ?>>Administrador</option>
                                                            <option value="2" <?php echo ($row['Usu_Rol'] == 2) ? 'selected' : ''; ?>>Colaborador</option>
                                                            <option value="3" <?php echo ($row['Usu_Rol'] == 3) ? 'selected' : ''; ?>>Cliente</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="pedidos">Pedidos:</label>
                                                        <input type="number" class="form-control" id="pedidos" name="pedidos" value="<?php echo $row['Usu_Pedidos']; ?>">
                                                    </div>
                                                    <label for="estado">Estado:</label>
                                                        <select class="form-select" id="estado" name="estado">
                                                            <option value="activo" <?php echo ($row['Usu_Estado'] == 'activo') ? 'selected' : ''; ?>>Activo</option>
                                                            <option value="inactivo" <?php echo ($row['Usu_Estado'] == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                                                        </select><br>
                                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                </form>
                                                <script>
                                                    function confirmarActualizacion() {
                                                        if (confirm("¿Seguro que deseas actualizar el usuario?")) {
                                                            return true;
                                                        } else {
                                                            return false;
                                                        }
                                                    }
                                                </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        </div>
                                      </td>
                                        <td class="text-center">
                                            <div class="badge <?php echo ($row['Usu_Estado'] == 'activo') ? 'bg-success' : 'bg-danger'; ?>">
                                                <?php echo ucfirst($row['Usu_Estado']); ?>
                                            </div>
                                        </div>
                                    </td>


                                    <style>
                                    .toggle-container {
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                    }

                                    </style>


                                <?php
                                }
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
