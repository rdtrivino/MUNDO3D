<?php
session_start();
require '../conexion.php';

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit(); // Es importante salir del script después de redirigir
}

$nombreCompleto = $_SESSION['username'];
$usuario_id = $_SESSION['user_id']; // Debes obtener el ID del usuario de alguna manera

// Consulta SQL para seleccionar datos de la tabla usuario
$sql = "SELECT  Usu_Identificacion, Usu_Nombre_completo, Usu_Telefono, Usu_Email, Usu_Ciudad, Usu_Direccion, Usu_Rol,Usu_Pedidos FROM usuario";
$resultado = mysqli_query($link, $sql);

// Verifica si hubo un error en la consulta SQL
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($link));
}
?>
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
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
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
                            <a class="nav-link" href="tablespedidos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas Pedidos
                            </a>
                            <a class="nav-link" href="tablesproductos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas Productos
                            </a>
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
                        <h1 class="mt-4">Tabla de usuarios</h1>
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
                            <div class="pdf-link-container">
                                <!-- Enlace con el ícono de PDF -->
                                <a href="generar_reporte.php" class="pdf-link" target="_blank">
                                    Generar Reporte PDF <i class="fas fa-file-pdf pdf-icon"></i>
                                </a>
                            </div>
                            <style>
                                /* Estilo para el contenedor del enlace */
                                .pdf-link-container {
                                    position: fixed;
                                    bottom: 20px; /* Ajusta la distancia desde la parte inferior de la página */
                                    right: 20px; /* Ajusta la distancia desde el lado derecho de la página */
                                    z-index: 9999; /* Asegura que esté sobre otros elementos */
                                }

                                /* Estilo para el enlace */
                                .pdf-link {
                                    display: inline-block;
                                    text-decoration: none;
                                    font-size: 18px;
                                    background-color: #2433bd; /* Color de fondo */
                                    color: #fff; /* Color de texto */
                                    padding: 10px 15px; /* Espacio interno */
                                    border-radius: 5px; /* Bordes redondeados */
                                }

                                /* Estilo para el ícono */
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
                                    <th>Acciones</th> <!-- Nueva columna para acciones -->
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
                                    <th>Acciones</th> <!-- Nueva columna para acciones -->
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                // Recorre los resultados de la consulta y muestra los datos en la tabla
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

                                        // Mapea el valor del rol a una descripción
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
                                        <button class="accion-button" style="background-color: #3498db; color: #fff;"><i class="fas fa-edit" style="font-size: 14px; margin-right: 5px;"></i></button>
                                        <button class="accion-button" style="background-color: #e74c3c; color: #fff;"><i class="fas fa-trash" style="font-size: 14px; margin-right: 5px;"></i></button>
                                    </td>
                                </tr>
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
