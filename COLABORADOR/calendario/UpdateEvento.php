<?php
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL, "es_ES");

include __DIR__ . '../../../conexion.php';
session_start();
$usuario_id = $_SESSION['user_id'];

$idEvento = $_POST['idEvento'];

$evento = ucwords($_REQUEST['evento']);
$f_inicio = $_REQUEST['fecha_inicio'];
$fecha_inicio = date('Y-m-d', strtotime($f_inicio));

$f_fin = $_REQUEST['fecha_fin'];
$seteando_f_final = date('Y-m-d', strtotime($f_fin));
$fecha_fin1 = strtotime($seteando_f_final . "+ 1 days");
$fecha_fin = date('Y-m-d', ($fecha_fin1));
$color_evento = $_REQUEST['color_evento'];
$observaciones = $_REQUEST['observaciones'];

$UpdateProd = ("UPDATE calendario 
    SET evento ='$evento',
        fecha_inicio ='$fecha_inicio',
        fecha_fin ='$fecha_fin',
        color_evento ='$color_evento',
        observaciones ='$observaciones',
        usuario ='$usuario_id'
        
    WHERE identificador='" . $idEvento . "' ");
$result = mysqli_query($link, $UpdateProd);

header("Location:../index.php");
?>