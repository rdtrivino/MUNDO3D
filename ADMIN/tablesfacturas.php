<!DOCTYPE html>
<html lang="en">
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
    <title>Facturas</title>
    <link rel="shortcut icon" href="../images/Logo Mundo 3d.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">

    <!-- JavaScript de jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript de DataTables -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>


    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />


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
        <?php include 'funcionestabladepedidos.php'; ?>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                    class="fas fa-bars"></i></button>
            <a class="navbar-brand ps-3" href="index.php">ADMINISTRADOR</a>
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombreCompleto; ?><i
                            class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../index.html" id="cerrar-sesion-button">Cerrar sesión</a>
                        </li>
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
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                            </div>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas usuarios
                            </a>
                            <a class="nav-link" href="tablesproductos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tablas Productos
                            </a>
                        </div>
                        <div class="mb-3 text-center" style="margin-top: 50px;">
                            <h4>FACTURAS</h4>
                            <div style="max-width: 80%; margin: 0 auto;">
                                <div class="caja-giratoria" style="display: inline-block;">
                                    <img src="./images/FACTURA.png" alt="Pedidos" class="img-fluid gira">
                                </div>
                            </div>
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
                    <div class="container-fluid px-4" style="padding-top: 20px; padding-bottom: 20px;">
                        <div class="row mt-4">
                            <div class="col text-center">
                                <h1 class="display-2 mb-0" style="font-family: 'Arial Black', sans-serif;">FACTURAS</h1>
                                <!-- Cambiar tamaño del texto y fuente -->
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col d-flex justify-content-end">
                                <div class="col-auto">
                                    <div class="input-group input-group-sm rounded-pill" style="width: 300px;">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control rounded-end" id="searchInput"
                                            placeholder="Buscar..." oninput="searchTable()" style="width: 250px;">
                                        <!-- Ajusta el ancho del campo de entrada aquí -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            function searchTable() {
                                var input, filter, table, tr, td, i, txtValue;
                                input = document.getElementById("searchInput");
                                filter = input.value.toUpperCase();
                                table = document.getElementById("datatables");
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
                        <div class="row mt-4">
                            <div class="col">
                                <div class="table-responsive" style="background-color: #f8f9fa; border-radius: 10px;">
                                    <table id="datatables" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Número de Factura</th>
                                                <th>Fecha</th>
                                                <th>Total</th>
                                                <th>Estado</th>
                                                <th>Nombre Cliente</th>
                                                <th>Creado En</th>
                                                <th>Número de Documento</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>ID de Pedido</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_facturas = "
            SELECT 
                f.id, 
                f.numero_factura, 
                f.fecha, 
                f.total, 
                f.estado, 
                f.nombre_cliente, 
                f.creado_en, 
                f.numero_documento, 
                GROUP_CONCAT(p.Pro_Nombre SEPARATOR ', ') AS productos, 
                SUM(f.cantidad) AS cantidad, 
                f.pedido_id 
            FROM 
                factura f 
            LEFT JOIN 
                productos p ON f.producto = p.Identificador
            WHERE 
                f.estado <> 'inactivo'
            GROUP BY 
                f.pedido_id
            ";
                                            $resultado_facturas = mysqli_query($link, $sql_facturas);

                                            if ($resultado_facturas && mysqli_num_rows($resultado_facturas) > 0) {
                                                while ($row = mysqli_fetch_assoc($resultado_facturas)) {
                                                    ?>
                                                    <tr id="facturaRow<?php echo $row['id']; ?>">
                                                        <td><?php echo $row['id']; ?></td>
                                                        <td><?php echo $row['numero_factura']; ?></td>
                                                        <td><?php echo $row['fecha']; ?></td>
                                                        <td><?php echo $row['total']; ?></td>
                                                        <td><?php echo $row['estado']; ?></td>
                                                        <td><?php echo $row['nombre_cliente']; ?></td>
                                                        <td><?php echo $row['creado_en']; ?></td>
                                                        <td><?php echo $row['numero_documento']; ?></td>
                                                        <td><?php echo $row['productos']; ?></td>
                                                        <td><?php echo $row['cantidad']; ?></td>
                                                        <td><?php echo $row['pedido_id']; ?></td>
                                                        <td style="display: flex; align-items: center;">
                                                            <div class="mr-2">
                                                                <a href="generarfactura.php?id=<?php echo $row['id']; ?>"
                                                                    class="btn btn-sm btn-success">
                                                                    <i class="fas fa-download"></i> Descargar
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='12'>No se encontraron facturas.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#datatables').DataTable({
                                                "paging": true,            // Habilitar paginación
                                                "lengthChange": false,     // Mostrar selección de cantidad de registros por página
                                                "searching": true,         // Habilitar búsqueda
                                                "ordering": true,          // Habilitar ordenamiento
                                                "info": true,              // Mostrar información de paginación
                                                "autoWidth": false,        // Deshabilitar ajuste automático del ancho de las columnas
                                                "responsive": true,        // Habilitar diseño responsivo
                                                "pageLength": 5            // Cantidad de registros por página
                                            });
                                        });
                                    </script>

                                </div>
                            </div>
                        </div>

    </body>
    <?php

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>