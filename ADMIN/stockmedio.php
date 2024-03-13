<?php
// Realizar la conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";

$conexion = mysqli_connect($host, $user, $password, $dbname);

// Comprobar si la conexión se realizó correctamente
if (!$conexion) {
    die("Error al conectarse a la Base de Datos: " . mysqli_connect_error());
}

// Consulta SQL para obtener los productos con stock medio
$sql = "SELECT p.*, c.Cgo_Nombre AS nombre_categoria FROM productos p JOIN categoria c ON p.Pro_Categoria = c.Cgo_Codigo WHERE p.Pro_Cantidad >= 10 AND p.Pro_Cantidad < 50";
$resultado = mysqli_query($conexion, $sql);

// Comprobar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<table class="table table-bordered table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Nombre</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Precio de Venta</th>
            <th>Categoría</th>
            <th>Cantidad</th>
            <th>Costo</th>
            <th>Imagen</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_Nombre']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_Codigo']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_Descripcion']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_PrecioVenta']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['nombre_categoria']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_Cantidad']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_Costo']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><img src="data:image/png;base64,<?php echo base64_encode($row['imagen_principal']); ?>" alt="Imagen del producto" style="max-width: 100px;"></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
