<!DOCTYPE html>
<html xmlns="">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Consulta de productos</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(to bottom, #f0f0f0, #c0c0c0);
    }

    h1 {
        text-align: center;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.7);
    }

    center {
        margin-top: 20px;
    }

    form {
        margin-bottom: 20px;
    }

    table {
        width: 900px;
        margin: 0 auto;
        background-color: rgba(255, 255, 255, 0.9);
        border-collapse: collapse;
        border: 2px double black;
        /* Líneas dobles y de color negro */
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    th,
    td {
        border: 2px double black;
        /* Líneas dobles y de color negro */
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #333;
        /* Color oscuro para el encabezado */
        color: white;
        /* Color de texto blanco */
        text-align: center;
        /* Centrar el texto del encabezado */
    }

    td.code,
    td.category {
        text-align: center;
        /* Centrar el contenido de Código y Categoría */
    }

    select {
        padding: 6px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    input[type="submit"] {
        padding: 8px 20px;
        background-color: #333;
        /* Color oscuro para el botón */
        color: white;
        /* Color de texto blanco */
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>
</head>

<body>
    <h1>CONSULTA DE PRODUCTOS</h1>
    <center>
        <form method="post" action="">
            <label for="producto">Seleccione una Categoria:</label>
            <select id="producto" name="producto">
                <option value=""></option>
                <option value="1" <?php if (isset($_POST['producto']) && $_POST['producto'] == '1')
                    echo 'selected'; ?>>
                    Impresoras</option>
                <option value="2" <?php if (isset($_POST['producto']) && $_POST['producto'] == '2')
                    echo 'selected'; ?>>
                    Repuestos</option>
                <option value="3" <?php if (isset($_POST['producto']) && $_POST['producto'] == '3')
                    echo 'selected'; ?>>
                    Mantenimiento</option>
                <option value="4" <?php if (isset($_POST['producto']) && $_POST['producto'] == '4')
                    echo 'selected'; ?>>
                    Impresion</option>
                <option value="5" <?php if (isset($_POST['producto']) && $_POST['producto'] == '5')
                    echo 'selected'; ?>>
                    Archivos 3D</option>
                <option value="6" <?php if (isset($_POST['producto']) && $_POST['producto'] == '6')
                    echo 'selected'; ?>>
                    Todos los Productos</option>
            </select>
            <input type="submit" value="Consultar">
        </form>

        <?php
        // Incluir el archivo de conexión
        include ("../conexion.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productoConsultar = $_POST["producto"];

            // Construir la consulta SQL dinámicamente
            $query = "SELECT Pro_Nombre, Pro_Codigo, Pro_Descripcion, Pro_Precio, Pro_Categoria
              FROM producto";

            if ($productoConsultar != 6) {
                $query .= " WHERE Pro_Categoria = ?";
            }

            $query .= " ORDER BY Pro_Categoria";

            // Usar consultas preparadas
            $stmt = mysqli_prepare($link, $query);

            if ($productoConsultar != 6) {
                mysqli_stmt_bind_param($stmt, "i", $productoConsultar);
            }

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                echo "<table width='900' border='1'>";
                echo "<tr><th>Código</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Categoría</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='code'>{$row['Pro_Codigo']}</td><td>{$row['Pro_Nombre']}</td><td>{$row['Pro_Descripcion']}</td><td>{$row['Pro_Precio']}</td><td class='category'>{$row['Pro_Categoria']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "La consulta no encontró registros asociados.";
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($link);
        ?>
    </center>
</body>

</html>