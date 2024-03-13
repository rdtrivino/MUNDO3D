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

// Consulta SQL para obtener los datos de los pedidos entregados
$sql = "SELECT Pe_Fechaentrega, SUM(Pe_Precio * Pe_Cantidad) AS MontoTotal FROM pedido WHERE Pe_Estado = '5' GROUP BY Pe_Fechaentrega";
$resultado = mysqli_query($conexion, $sql);

// Crear arrays para almacenar las fechas y los montos totales
$fechas = [];
$montos = [];

// Obtener los datos de la consulta y almacenarlos en los arrays
while ($row = mysqli_fetch_assoc($resultado)) {
    $fechas[] = $row['Pe_Fechaentrega'];
    $montos[] = $row['MontoTotal'];
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
