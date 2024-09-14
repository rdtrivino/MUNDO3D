<?php
// Realizar la conexión a la base de datos

include __DIR__ . '/../conexion.php';

// Consulta SQL para obtener los productos activos con más de 50 unidades en stock
$sql = "SELECT p.*, c.Cgo_Nombre AS nombre_categoria 
        FROM productos p 
        JOIN categoria c ON p.Pro_Categoria = c.Cgo_Codigo 
        WHERE p.Pro_Estado = 'activo' AND p.Pro_Cantidad >= 50";
$resultado = mysqli_query($link, $sql);

// Comprobar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($link));
}
?>

<table class="table">
    <thead>
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
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Identificador']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_Descripcion']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_PrecioVenta']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['nombre_categoria']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_Cantidad']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><?php echo $row['Pro_Costo']; ?></td>
                <td style="border: 1px solid #dddddd; padding: 8px;">
                <td style="border: 1px solid #dddddd; padding: 8px;"><img src="<?php echo $row['nombre_imagen']; ?>" height="150px"></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($link);
?>