<?php
$hostname = "localhost";
$usuariodb = "root";
$contrasenadb = "root";
$dbname = "php_evento";
	
// Generar conexion con el servidor MySQl
$conexion = mysqli_connect($hostname, $usuariodb, $contrasenadb, $dbname);