<?php
session_start();
include __DIR__ . '/../../conexion.php';

/*Limit*/

$limit = isset($_POST['registros']) ? $link->real_escape_string($_POST['registros']) : 10;
$sLimit = "LIMIT $limit";

/*Consulta*/

$sql = "SELECT " . implode(", ", $columns) . "
FROM $table
$where
$sLimit";
$resultado = $link->query($sql);
$num_rows = $resultado->num_rows;

?>