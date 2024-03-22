<!DOCTYPE html>
<html xmlns="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consulta de Pedidos</title>

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
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    th, td {
        border: 2px double black;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #333;
        color: white;
        text-align: center;
    }
    td.code, td.category {
        text-align: center;
    }
    select {
        padding: 6px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }
    input[type="submit"] {
        padding: 8px 20px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

</head>
<body>
<h1 ALIGN="CENTER">CONSULTA DE TODOS LOS PEDIDOS</h1>
<center>
<form method="post" action="">
    <label for="estado">Seleccione el estado del pedido:</label>
    <select id="estado" name="estado">
        <option value=""></option>
        <option value="1" <?php if(isset($_POST['estado']) && $_POST['estado'] == '1') echo 'selected'; ?>>Nuevo</option>
        <option value="2" <?php if(isset($_POST['estado']) && $_POST['estado'] == '2') echo 'selected'; ?>>Confirmado</option>
        <option value="3" <?php if(isset($_POST['estado']) && $_POST['estado'] == '3') echo 'selected'; ?>>En proceso</option>
        <option value="4" <?php if(isset($_POST['estado']) && $_POST['estado'] == '4') echo 'selected'; ?>>Terminado</option>
        <option value="5" <?php if(isset($_POST['estado']) && $_POST['estado'] == '5') echo 'selected'; ?>>Entregado</option>
        <option value="6" <?php if(isset($_POST['estado']) && $_POST['estado'] == '6') echo 'selected'; ?>>Cancelado</option>
        <option value="7" <?php if(isset($_POST['estado']) && $_POST['estado'] == '7') echo 'selected'; ?>>Devuelto</option>
        <option value="8" <?php if(isset($_POST['estado']) && $_POST['estado'] == '8') echo 'selected'; ?>>Todos los Productos</option>
    </select>

    <input type="submit" value="Consultar">
</form>

<?php
// Incluir el archivo de conexión
include("..\conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $estadoConsultar = $_POST["estado"];

    // Consulta a la base de datos
    $query = "SELECT Pe_Codigo, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Precio, Pe_Fechaentrega, Pe_Fechapedido, Pe_Cliente, Pe_Observacion
              FROM pedido";

    if ($estadoConsultar != 8) {
        $query .= " WHERE Pe_Estado = ?";
    }

    $query .= " ORDER BY Pe_Codigo";

    // Usar consultas preparadas
    $stmt = mysqli_prepare($link, $query);

    if ($estadoConsultar != 8) {
        mysqli_stmt_bind_param($stmt, "i", $estadoConsultar);
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<table width='900' border='1'>";
        echo "<tr><td>Codigo</td><td>Estado</td><td>Producto</td><td>Cantidad</td><td>Precio</td><td>Fecha de entrega</td><td>Fecha de Pedido</td><td>Cliente</td><td>Oservaciones</td></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['Pe_Codigo']}</td><td>{$row['Pe_Estado']}</td><td>{$row['Pe_Producto']}</td><td>{$row['Pe_Cantidad']}</td><td>{$row['Pe_Precio']}</td><td>{$row['Pe_Fechaentrega']}</td><td>{$row['Pe_Fechapedido']}</td><td>{$row['Pe_Cliente']}</td><td>{$row['Pe_Observacion']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>La consulta no encontró registros asociados.</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
</center>
<center>
    
<!-- Agregar un botón fuera de la tabla -->
<input type="button" value="Insertar Registro" onclick="window.location.href='ingresapedidos.php';">

</center>
</body>
</html>
