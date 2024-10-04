<?php
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL, "es_ES");

include __DIR__ . '../../../conexion.php';
session_start();
$usuario_id = $_SESSION['user_id'];
$idEvento = $_POST['idEvento'];
$evento = ucwords($_REQUEST['evento']);
$fecha_inicio = $_REQUEST['fecha_inicio'];

$hora_inicio = $_REQUEST['hora_inicio'];
$hora_fin = $_REQUEST['hora_fin'];

$color_evento = $_REQUEST['color_evento'];
$observaciones = $_REQUEST['observaciones'];

$UpdateProd = ("UPDATE calendario 
    SET evento ='$evento',
        fecha_inicio ='$fecha_inicio',
        fecha_fin ='$fecha_fin',
        color_evento ='$color_evento',
        observaciones ='$observaciones',
        hora_inicio = '$hora_inicio',
        hora_fin = '$hora_fin',
        usuario ='$usuario_id'
        
    WHERE identificador='" . $idEvento . "' ");
$result = mysqli_query($link, $UpdateProd);

header("Location:../index.php");
?>