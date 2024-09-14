<?php
/*$host = "localhost";
$user = "root";
$password = "";
$dbname = "mundo3d";*/

$host = "localhost";
$user = "u255704174_root";
$password = "Mundo3d2024";
$dbname = "u255704174_mundo3d";

$link = mysqli_connect($host, $user, $password);

if (!$link) {
    die("Error al conectarse al servidor: " . mysqli_connect_error());
}

if (!mysqli_select_db($link, $dbname)) {
    die("Error al conectarse a la Base de Datos: " . mysqli_error($link));
}


// Consulta a la base de datos para obtener productos de la categoría 5
$sql = "SELECT * FROM productos WHERE Pro_Categoria = 2";
$result = mysqli_query($link, $sql);

?>