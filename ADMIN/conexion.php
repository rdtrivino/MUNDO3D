<?php

// Obtener el nombre del host desde el cual se hace la solicitud
$host = $_SERVER['HTTP_HOST'];

// Configuración predeterminada
$hostName = 'localhost';

// Configuración de base de datos basada en el nombre del host
if (strpos($host, 'localhost') !== false) {
    // Configuración para el entorno de desarrollo local
    $entorno = "local";
    $dbConfig = [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'dbname' => 'mundo3d'
    ];
} elseif (strpos($host, 'mundo3d.orionweb.site') !== false) {
    // Configuración para el entorno de producción
    $entorno = "web";
    $dbConfig = [
        'host' => 'localhost',
        'user' => 'u255704174_root',
        'password' => 'Mundo3d2024',
        'dbname' => 'u255704174_mundo3d'
    ];
} else {
    die('Entorno no reconocido.');
}

// Establecer la conexión a la base de datos
$link = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['dbname']);

if (!$link) {
    die("Error al conectarse al servidor: " . mysqli_connect_error());
}

mysqli_set_charset($link, "utf8");


?>
