<?php
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL, "es_ES");
//$hora = date("g:i:A");
include __DIR__ . './../../conexion.php';

$evento = ucwords($_REQUEST['evento']);
$f_inicio = $_REQUEST['fecha_inicio'];
$fecha_inicio = $_REQUEST['fecha_inicio'];
$color_evento = $_REQUEST['color_evento'];
$observaciones = $_REQUEST['observaciones'];
$hora_inicio = $_REQUEST['hora_inicio'];
$hora_fin = $_REQUEST['hora_fin'];

session_start();
$usuario_id = $_SESSION['user_id'];

//Validar identificador de la tabla
$sql = "SELECT MAX(identificador) AS max_id FROM calendario";
$resultado = mysqli_query($link, $sql);
// Verificar si se encontraron resultados
if (mysqli_num_rows($resultado) > 0) {
    // Obtener el resultado como un array asociativo
    $fila = mysqli_fetch_assoc($resultado);
    // Almacenar el valor del identificador más alto en una variable
    $max_id = $fila['max_id'];
} else {
    $max_id = '1';
}

$identificador = $max_id + 1;

$InsertNuevoEvento = "INSERT INTO calendario(
      identificador,
      evento,
      fecha_inicio,
      color_evento,
      observaciones,
      hora_inicio,
      hora_fin,
      usuario
      )
    VALUES (
      '" . $identificador . "',
      '" . $evento . "',
      '" . $fecha_inicio . "',
      '" . $color_evento . "',
      '" . $observaciones . "',
      '" . $hora_inicio . "',
      '" . $hora_fin . "',
      '" . $usuario_id . "'  
  )";
$resultadoNuevoEvento = mysqli_query($link, $InsertNuevoEvento);

header("Location:../index.php");

?>