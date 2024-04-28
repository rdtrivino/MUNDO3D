<?php
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL,"es_ES");
//$hora = date("g:i:A");
include __DIR__ . '../../../conexion.php';

require("config.php");
$evento            = ucwords($_REQUEST['evento']);
$f_inicio          = $_REQUEST['fecha_inicio'];
$fecha_inicio      = date('Y-m-d', strtotime($f_inicio)); 

$f_fin             = $_REQUEST['fecha_fin']; 
$seteando_f_final  = date('Y-m-d', strtotime($f_fin));  
$fecha_fin1        = strtotime($seteando_f_final."+ 1 days");
$fecha_fin         = date('Y-m-d', ($fecha_fin1));  
$color_evento      = $_REQUEST['color_evento'];

session_start();
$usuario_id = $_SESSION['user_id'];

//Validar identificador de la tabla
    $sql = "SELECT MAX(Identificador) AS max_id FROM calendario";
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
      fecha_fin,
      color_evento,
      usuario
      )
    VALUES (
      '" .$identificador. "',
      '" .$evento. "',
      '". $fecha_inicio."',
      '" .$fecha_fin. "',
      '" .$color_evento. "',
      '" .$usuario_id. "'
  )";
$resultadoNuevoEvento = mysqli_query($con, $InsertNuevoEvento);

header("Location:../index.php");

?>